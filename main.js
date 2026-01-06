
document.querySelectorAll('[data-scrollto]').forEach((el) => {
  el.addEventListener('click', () => {
    const id = el.getAttribute('data-scrollto');
    document.querySelector(id)?.scrollIntoView({ behavior: 'smooth' });
  });
});


let plots = [];
let map = null;
let collection = null;
const polys = new Map();

function cssVar(name) {
 
  if (!name || name[0] !== '-') return name;
  const v = getComputedStyle(document.documentElement).getPropertyValue(name).trim();
  return v || name;
}


function statusColor(status) {
  const varName = status === 'available' ? '--ok' : status === 'hold' ? '--hold' : '--sold';

  const fallback = status === 'available' ? '#2F855A' : status === 'hold' ? '#D97706' : '#DC2626';
  return cssVar(varName) || fallback;
}

function buildBalloon(plot) {
  const canReserve = plot.status === 'available';
  const badge =
    plot.status === 'available'
      ? 'Свободно'
      : plot.status === 'hold'
      ? 'В бронь'
      : 'Продано';
  const btn = canReserve
    ? `<button id="reserve-${plot.id}" class="btn btn-success btn-sm mt-2">Забронировать</button>`
    : '';

  return `
    <div style="font:14px/1.4 Inter,system-ui">
      <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px">
        <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:${statusColor(
          plot.status
        )}"></span>
        <strong>Участок №${plot.id}</strong> • ${badge}
      </div>
      <div>Площадь: <b>${plot.area_sot}</b> сот.</div>
      <div>Цена: <b>${Number(plot.price_rub).toLocaleString('ru-RU')}</b> ₽</div>
      <div class="mt-1"><a target="_blank" rel="noopener" href="${plot.pkk_url}">Открыть в ППК</a></div>
      ${btn}
    </div>`;
}


function refreshPlotStyle(id) {
  const plot = plots.find((p) => p.id === id);
  const poly = polys.get(id);
  if (!plot || !poly) return;
  const col = statusColor(plot.status);
  poly.options.set({ fillColor: col, strokeColor: col });
  poly.properties.set('balloonContent', buildBalloon(plot));
}


function updateStats() {
  const free = plots.filter((p) => p.status === 'available').length;
  const hold = plots.filter((p) => p.status === 'hold').length;
  const sold = plots.filter((p) => p.status === 'sold').length;
  const sFree = document.getElementById('stat-free');
  const sHold = document.getElementById('stat-hold');
  const sSold = document.getElementById('stat-sold');
  if (sFree) sFree.textContent = free;
  if (sHold) sHold.textContent = hold;
  if (sSold) sSold.textContent = sold;
}


function ensureModal() {
  if (document.getElementById('modalReserve')) return;
  const csrf = document.querySelector('input[name="csrf"]')?.value || '';
  const html = `
  <div class="modal fade" id="modalReserve" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Бронь участка <span id="modalPlot"></span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
        </div>
        <div class="modal-body">
        <p id="modalPlotHint" class="small text-secondary mb-2"></p>
          <form id="modalForm" class="vstack gap-2">
            <input type="hidden" name="csrf" value="${csrf}">
            <input type="hidden" id="modalPlotId" name="plotId">
            <div><label class="form-label">Имя</label><input class="form-control" name="name" required></div>
            <div><label class="form-label">Телефон</label><input class="form-control" name="phone" required placeholder="+7"></div>
            <div><label class="form-label">Комментарий</label><textarea class="form-control" name="comment" rows="3"></textarea></div>
            <div class="d-flex justify-content-end gap-2 mt-2">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Отменить</button>
              <button class="btn btn-success" type="submit">Отправить</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>`;
  document.body.insertAdjacentHTML('beforeend', html);
}

function openModal(plotId){
  ensureModal();
  const pl = plots.find(p=>p.id===plotId);
  document.getElementById('modalPlot').textContent = '№' + plotId;
  document.getElementById('modalPlotId').value = plotId;
  const commonPlot = document.getElementById('plotId');
  if (commonPlot) commonPlot.value = plotId;


  const hint = document.getElementById('modalPlotHint');
  if (pl && hint){
    hint.innerHTML = `Площадь: <b>${pl.area_sot}</b> сот • Цена: <b>${pl.price_rub.toLocaleString('ru-RU')}</b> ₽`;
  }
  new bootstrap.Modal(document.getElementById('modalReserve')).show();
}



document.addEventListener('submit', async (e) => {
  if (e.target?.id !== 'modalForm') return;
  e.preventDefault();
  const fd = new FormData(e.target);
  const id = Number(fd.get('plotId'));
  try {
    const r = await fetch('api/reserve.php', { method: 'POST', body: fd });
    const text = await r.text();
    let data;
    try {
      data = JSON.parse(text);
    } catch (_) {
      console.error('reserve.php ответил не JSON, пришло:\n', text);
      throw new Error('Сервер вернул неверный ответ');
    }
    if (!data.ok) throw new Error(data.error || 'Ошибка брони');

    const pl = plots.find((p) => p.id === id);
    if (pl) pl.status = 'hold';
    refreshPlotStyle(id);
    updateStats();
    bootstrap.Modal.getInstance(document.getElementById('modalReserve'))?.hide();
    alert('Бронь принята! Менеджер подтвердит в Telegram.');
  } catch (err) {
    alert(err.message);
  }
});


async function loadPlots() {
  const url = new URL('api/plots.php', window.location.href);
  const r = await fetch(url, { cache: 'no-store' });
  if (!r.ok) throw new Error('API ' + url + ' HTTP ' + r.status);
  const text = await r.text();
  let data;
  try {
    data = JSON.parse(text);
  } catch (e) {
    console.error('Ожидал JSON, а пришло:\n', text);
    throw e;
  }

  return (data.plots || []).map((p) => {
    let geom = p.geometry_json;
  
    if (typeof geom === 'string') {
      try {
        geom = JSON.parse(geom);
      } catch (_) {
        geom = [];
      }
    }
    if (!Array.isArray(geom)) geom = [];
    return {
      id: Number(p.id),
      area_sot: Number(p.area_sot),
      price_rub: Number(p.price_rub),
      status: p.status,
      pkk_url: p.pkk_url,
      coords: geom.map((x) => [Number(x[0]), Number(x[1])]),
    };
  });
}


async function init() {
  try {
    plots = await loadPlots();
    console.log('plots loaded:', plots);
  } catch (e) {
    console.error('loadPlots failed:', e);
    plots = [];
  }

  if (!window.ymaps || !ymaps.ready) {
    console.error('Yandex Maps API не загрузился (проверь ключ/рефереры)');
    return;
  }

  ymaps.ready(function () {
    const center = [55.23318, 36.7303];
    map = new ymaps.Map('map', {
      center: center,
      zoom: 16,
      controls: ['zoomControl', 'typeSelector', 'fullscreenControl'],
    });

    collection = new ymaps.GeoObjectCollection();

    plots.forEach((plot) => {
      if (!plot.coords.length) return; 
const col = statusColor(plot.status);

const poly = new ymaps.Polygon(
  [plot.coords],
  {
    hintContent: `Участок №${plot.id}`,
    balloonContent: buildBalloon(plot),
  },
  {
    fillColor: col,
    fillOpacity: 0.35,
    strokeColor: col,
    strokeWidth: 2,
    interactivityModel: 'default#opaque',
  }
);


function refreshPlotStyle(id) {
  const plot = plots.find(p => p.id === id);
  const poly = polys.get(id);
  if (!plot || !poly) return;
  const col = statusColor(plot.status);
  poly.options.set({ fillColor: col, strokeColor: col });
  poly.properties.set('balloonContent', buildBalloon(plot));
}

      poly.events.add('balloonopen', () =>
        setTimeout(() => {
          const btn = document.getElementById('reserve-' + plot.id);
          if (btn) btn.onclick = () => openModal(plot.id);
        }, 0)
      );

      collection.add(poly);
      polys.set(plot.id, poly);
    });

    map.geoObjects.add(collection);
    const bounds = collection.getBounds();
    if (bounds) map.setBounds(bounds, { checkZoomRange: true, zoomMargin: 40 });

    updateStats();
  });
}

async function refreshFromServer(){
  try{
    const fresh = await loadPlots();          
    const byId = new Map(fresh.map(p=>[p.id,p]));
    plots.forEach(p=>{
      const f = byId.get(p.id);
      if (!f) return;
      if (p.status !== f.status){            
        p.status = f.status;
        refreshPlotStyle(p.id);              
      }
    });
    updateStats();
  }catch(e){ console.warn('refreshFromServer failed', e); }
}
function startUpdates(){ setInterval(refreshFromServer, 15000); } 
document.addEventListener('DOMContentLoaded', startUpdates);

function initRoute(){
  if (!window.ymaps) return;
  ymaps.ready(()=> {
    const DEST = [55.23318, 36.73030]; 
    const rMap = new ymaps.Map('routeMap', { center: DEST, zoom: 12, controls:['zoomControl'] });

    async function build(fromPoint){
      const multi = new ymaps.multiRouter.MultiRoute({
        referencePoints: [fromPoint, DEST],
        params: { routingMode: 'auto' }
      }, { wayPointVisible:false, viaPointVisible:false });
      rMap.geoObjects.removeAll();
      rMap.geoObjects.add(multi);
      multi.model.events.add('requestsuccess', ()=>{
        const bounds = multi.getBounds();
        if (bounds) rMap.setBounds(bounds, { checkZoomRange: true, zoomMargin: 40 });
      });
    }

    async function detectAndBuild(){
      const text = document.getElementById('fromInput').value.trim();
      if (text){
        ymaps.geocode(text).then(res=>{
          const p = res.geoObjects.get(0)?.geometry.getCoordinates();
          if (p) build(p); else alert('Не нашёл такой адрес');
        });
      } else {

        if (navigator.geolocation){
          navigator.geolocation.getCurrentPosition(
            pos => build([pos.coords.latitude, pos.coords.longitude]),
            () => ymaps.geolocation.get({ provider:'auto', mapStateAutoApply:false }).then(r=>{
              const p = r.geoObjects.position; if (p) build(p);
            })
          );
        } else {
          ymaps.geolocation.get({ provider:'auto', mapStateAutoApply:false }).then(r=>{
            const p = r.geoObjects.position; if (p) build(p);
          });
        }
      }
    }

    document.getElementById('buildRouteBtn').addEventListener('click', detectAndBuild);
    
    detectAndBuild();
  });
}
document.addEventListener('DOMContentLoaded', initRoute);

document.addEventListener('DOMContentLoaded', init);
