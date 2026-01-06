<?php session_start(); if (empty($_SESSION['csrf'])) { $_SESSION['csrf']=bin2hex(random_bytes(16)); }
require __DIR__.'/../config.php';
?><!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Земельные участки — деревня Шилово</title>
  <meta name="description" content="Выбор и бронирование земельных участков в деревне Шилово. Карта с участками, цены, как добраться, заявка на просмотр."/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/main.css" rel="stylesheet" />
</head>
<body>
  
<header class="sticky-top border-bottom site-header">
  <nav class="navbar navbar-expand-lg py-3">
    <div class="container px-3">

   
      <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="#hero">
        <span class="logo-dot"></span>
        Шилово
      </a>

     
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
        <span class="navbar-toggler-icon"></span>
      </button>

    
      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-auto gap-4 align-items-lg-center">
          <li class="nav-item"><a class="nav-link" href="#hero">Начало</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">Преимущества</a></li>
          <li class="nav-item"><a class="nav-link" href="#map-section">Доступные участки</a></li>
          <li class="nav-item"><a class="nav-link" href="#route">Как туда добраться</a></li>
          <li class="nav-item"><a class="nav-link" href="#gallery">Галерея</a></li>
          <li class="nav-item"><a class="nav-link" href="#lead">Форма записи</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Контакты</a></li>
        </ul>
      </div>

    </div>
  </nav>
</header>


<main>
 <section id="hero" class="hero-section">
  <div class="container">
    <div class="row min-vh-75 align-items-center">

    
      <div class="col-lg-6">
        <span class="hero-label">Сюжет Вашей Мечты ждет Вас</span>

        <h1 class="hero-title mt-3">
          Откройте для себя идеальное место для строительства вашего будущего дома в нашей
живописной деревне.
        </h1>

        <p class="hero-text mt-3">
          Окруженный природой, с современной инфраструктурой и отличной транспортной доступностью.
        </p>

        <div class="d-flex gap-3 mt-4 flex-wrap">
          <a class="btn btn-success px-4 py-2 rounded-pill" href="#lead">
            Запишитесь на просмотр →
          </a>
          <a class="btn btn-outline-light px-4 py-2 rounded-pill" href="#map-section">
            Просмотр доступных участков
          </a>
        </div>
      </div>

     
      <div class="col-lg-6 d-none d-lg-block"></div>

    </div>
  </div>
</section>

  <section id="about" class="py-5">
  <div class="container">

    
    <div class="text-center mb-5">
      <h2 class="h4">Почему Вы выбрали именно Нашу деревню</h2>
      <p class="text-secondary mt-2">
        Насладитесь идеальным сочетанием спокойной загородной жизни с современными городскими удобствами
      </p>
    </div>

    
    <div class="row g-4">

      <div class="col-lg-3 col-md-6">
        <div class="feature-card green">
          <div class="icon">📍</div>
          <h5>Выгодное расположение</h5>
          <p>Всего в 25 км от центра города с отличным доступом к дорогам и общественному транспорту.</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="feature-card blue">
          <div class="icon">⚡</div>
          <h5>Полная инфраструктура</h5>
          <p>Подключены все коммуникации: электричество, газ, водоснабжение и канализация.</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="feature-card green">
          <div class="icon">🌳</div>
          <h5>Природная среда</h5>
          <p>Окруженный лесом и зелеными насаждениями, он идеально подходит для семейного проживания и активного отдыха.</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="feature-card red">
          <div class="icon">🛡️</div>
          <h5>Безопасность</h5>
          <p>Круглосуточная охрана, закрытый комплекс с контролируемым доступом и видеонаблюдением.</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="feature-card purple">
          <div class="icon">🚗</div>
          <h5>Easy Access</h5>
          <p>Paved roads throughout the village, convenient parking, and regular bus service.</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="feature-card orange">
          <div class="icon">🏠</div>
          <h5>Готов к строительству</h5>
          <p>Все участки имеют четкие границы, кадастровую документацию и разрешения на строительство.</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="feature-card blue">
          <div class="icon">🎓</div>
          <h5>Школы поблизости</h5>
          <p>Детские сады, школы и образовательные центры находятся в пределах 5-10 минут езды.</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="feature-card pink">
          <div class="icon">🛍️</div>
          <h5>Услуги</h5>
          <p>Торговые центры, медицинские учреждения и развлекательные заведения находятся в непосредственной близости.</p>
        </div>
      </div>

    </div>
  </div>
</section>

  <section id="map-section" class="py-5">
    <div class="container">
   <div class="text-center mb-4">
  <h2 class="h4">Доступные участки</h2>
  <p class="text-secondary">
    Изучите нашу интерактивную карту, чтобы найти идеальный для вас участок.
 Нажмите на любой маркер, чтобы просмотреть подробную информацию.
  </p>
</div>
      <div id="map" class="rounded-4 shadow" style="height:540px"></div>
      <div class="d-flex gap-2 flex-wrap mt-2 small">
        <span class="legend key"><span class="dot" style="background:var(--ok)"></span> Свободно</span>
        <span class="legend key"><span class="dot" style="background:var(--hold)"></span> В бронь</span>
        <span class="legend key"><span class="dot" style="background:var(--sold)"></span> Продано</span>
      </div>
    </div>
  </section>


  <section id="route" class="py-5">
  <div class="container">

    <div class="route-header text-center mb-4">
      <h2 class="h4">Как туда добраться</h2>
      <p class="text-secondary">
        Укажите свое начальное местоположение, и мы покажем вам наилучший маршрут до нашей деревни
      </p>
    </div>

    <div class="route-form-wrapper mb-5">
      <div class="route-form-card">
        <label class="form-label">Начальное местоположение</label>

        <div class="d-flex gap-2">
          <input id="fromInput" class="form-control">
          <button class="btn" id="buildRouteBtn">➜ Построить маршрут</button>
        </div>

        <small class="text-secondary mt-2 d-block">
          Мы не храним ваше геолокационное местоположение
        </small>
      </div>
    </div>

  </div>

 <div id="routeMap" style="height:380px; border-radius:14px; overflow:hidden"></div>
</section>
  


  <section id="gallery" class="py-5">
    <div class="container">
      <h2 class="h3 mb-3">Галерея</h2>
      <div id="galleryCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-touch="true">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#galleryCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Слайд 1"></button>
          <button type="button" data-bs-target="#galleryCarousel" data-bs-slide-to="1" aria-label="Слайд 2"></button>
          <button type="button" data-bs-target="#galleryCarousel" data-bs-slide-to="2" aria-label="Слайд 3"></button>
          <button type="button" data-bs-target="#galleryCarousel" data-bs-slide-to="3" aria-label="Слайд 4"></button>
        </div>
        <div class="carousel-inner rounded-4 shadow">
        <div class="carousel-item active">
  <div class="gallery-item">
    <img src="./assets/DJI_20250506142941_0147_D.JPG" alt="Фото 1">
    <div class="gallery-overlay">
      <span>Вид на поле</span>
    </div>
  </div>
</div>

                <div class="carousel-item">
  <div class="gallery-item">
    <img src="./assets/DJI_20250903171153_0280_D.JPG" alt="Фото 1">
    <div class="gallery-overlay">
      <span>Подъездная дорога</span>
    </div>
  </div>
</div>
                <div class="carousel-item">
  <div class="gallery-item">
    <img src="./assets/DJI_20250911180217_0327_D.JPG" alt="Фото 1">
    <div class="gallery-overlay">
      <span>Окрестности</span>
    </div>
  </div>
</div>
              <div class="carousel-item">
  <div class="gallery-item">
    <img src="./assets/DJI_20250903171217_0282_D.JPG" alt="Фото 1">
    <div class="gallery-overlay">
      <span>Загородная тишина</span>
    </div>
  </div>
</div>
      </div>
    </div>
  </section>

<section id="terms" class="terms-section py-5">
  <div class="container">
 
    <div class="terms-wrapper">
    <div class="terms-header text-center mb-5">
      <span class="terms-icon">📄</span>
      <h2 class="h4 mb-2">Правила и условия сделки</h2>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-md-6">
        <div class="terms-card">
          <h5>Способы оплаты</h5>
          <p>
          Доступны гибкие схемы оплаты: полная оплата, рассрочка
до 24 месяцев или помощь в оформлении ипотеки.
          </p>
        </div>
      </div>

      <div class="col-md-6">
        <div class="terms-card">
          <h5>Документация</h5>
          <p>
            Предоставлены все необходимые документы: кадастровый паспорт,
свидетельство о праве собственности и разрешение на строительство.
          </p>
        </div>
      </div>

      <div class="col-md-6">
        <div class="terms-card">
          <h5>Юридическая поддержка</h5>
          <p>
            Бесплатная юридическая консультация и помощь в
оформлении сделки за наш счет.
          </p>
        </div>
      </div>

      <div class="col-md-6">
        <div class="terms-card">
          <h5>Бронирование</h5>
          <p>
            Зарезервируйте свой участок, внеся предоплату в размере 10%. Полный возврат средств, если вы
передумаете в течение 14 дней.
          </p>
        </div>
</div>
      </div>
    </div>

    <div class="terms-offer">
      <strong>Cпециальное предложение:</strong>
      Закажите просмотр в январе и получите скидку 5% на покупку любого участка!
    </div>

  </div>
</section>

  <section id="lead" class="lead-section py-5">
  <div class="container">

    
    <div class="text-center mb-5">
      <h2 class="h4 mb-2">Запишитесь на просмотр</h2>
      <p class="text-secondary">
        Запланируйте индивидуальную экскурсию по нашей деревне и доступным участкам.
 Наши специалисты ответят на все ваши вопросы.
      </p>
    </div>

    
    <div class="lead-form-wrapper">
      <div class="lead-form-card">

        <form id="leadForm" class="row g-3">
          <input type="hidden" name="csrf" value="<?=htmlspecialchars($_SESSION['csrf'])?>">

          <div class="col-md-6">
            <label class="form-label">Фамилия и имя *</label>
            <input class="form-control" required placeholder="Шилов Максим">
          </div>

          <div class="col-md-6">
            <label class="form-label">Номер телефона *</label>
            <input class="form-control" required placeholder="+7 (___) ___-__-__">
          </div>

          <div class="col-md-6">
            <label class="form-label">Адрес электронной почты</label>
            <input class="form-control" placeholder="shilov@example.com">
          </div>

          <div class="col-md-6">
            <label class="form-label">Предпочтительная дата *</label>
            <input type="date" class="form-control" required>
          </div>

          <div class="col-12">
            <label class="form-label">Дополнительная информация</label>
            <textarea class="form-control" rows="4"
              placeholder="Любые конкретные вопросы, которые вас интересуют..."></textarea>
          </div>

          <div class="col-12 small text-secondary">
            <label>
              <input type="checkbox" required>
              Я даю согласие на обработку моих персональных данных
            </label>
          </div>

          <div class="col-12">
            <button class="btn btn-success w-100 py-2">
             Отправить запрос на просмотр
            </button>
          </div>

          <div class="col-12 text-center small text-secondary">
            * Обязательные для заполнения поля
          </div>
        </form>

      </div>
    </div>


    <div class="row g-4 mt-5 text-center">
      <div class="col-md-4">
        <div class="lead-feature">
          📅
          <h6>Гибкий график работы</h6>
          <p>Просмотры доступны 7 дней в неделю</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="lead-feature">
          🚗
          <h6>Бесплатный трансфер</h6>
          <p>Мы можем организовать транспортировку</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="lead-feature">
          💼
          <h6>Консультация эксперта</h6>
          <p>Профессиональное руководство включало</p>
        </div>
      </div>
    </div>

  </div>
</section>
</main>

<footer class="site-footer">
  <div class="container">

    <div class="row gy-4">

     
      <div class="col-lg-6">
        <h6 class="footer-title" id="contact">Контактная информация</h6>
        <p class="footer-text">
         Свяжитесь с нами по любым вопросам или запланируйте посещение.
 Наша команда готова помочь вам найти идеальный участок для вашего дома.
        </p>

        <ul class="footer-list">
          <li>
            <span class="footer-icon">📞</span>
            <div>
              <strong>Телефоны</strong><br>
              +7 (999) 123-45-67<br>
              +7 (999) 987-65-43
            </div>
          </li>

          <li>
            <span class="footer-icon">✉️</span>
            <div>
              <strong>Почта</strong><br>
              info@shilovo.ru<br>
              sales@shilovo.ru
            </div>
          </li>

          <li>
            <span class="footer-icon">📍</span>
            <div>
              <strong>Адрес офиса</strong><br>
              д. Шилово, Московская область
            </div>
          </li>

          <li>
            <span class="footer-icon">⏰</span>
            <div>
              <strong>Рабочее время</strong><br>
              Пн–Пт: 9:00–19:00<br>
              Сб–Вс: 10:00–17:00
            </div>
          </li>
        </ul>
      </div>

     
      <div class="col-lg-6">
        <h6 class="footer-title">Свяжитесь с Нами</h6>
        <p class="footer-text">
        Следите за нами в социальных сетях, чтобы быть в курсе последних обновлений, новостей
и доступных сюжетов.
        </p>

        <div class="footer-socials mb-4">
          <a href="#">VK</a>
          <a href="#">Telegram</a>
          <a href="#">WhatsApp</a>
        </div>

        <div class="footer-quick">
          <strong>Быстрый контакт</strong>
          <p>
      Нужна срочная помощь? Позвоните нам прямо сейчас или отправьте сообщение в WhatsApp!
          </p>
          <a href="tel:+79991234567" class="btn btn-success btn-sm">
            Позвонить
          </a>
        </div>
      </div>

    </div>

    <hr class="footer-divider">

    <div class="footer-bottom">
      <span>© 2026 Шилово · Участки. Все права защищены.</span>
      <div class="footer-links">
        <a href="#">Политика конфиденциальности</a>
        <a href="#">Пользовательское соглашение</a>
      </div>
    </div>

  </div>
</footer>


<script src="https://api-maps.yandex.ru/2.1/?apikey=3956693b-a452-4317-b9a2-6769353875de&lang=ru_RU"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/main.js"></script>
</body></html>