<?php
header('Content-Type: application/json; charset=utf-8');
session_start();
require __DIR__.'/../../db.php';
require __DIR__.'/../../config.php';


if (empty($_POST['csrf']) || empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
http_response_code(403); echo json_encode(['ok'=>false,'error'=>'CSRF']); exit;
}


$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$plot = (int)($_POST['plotId'] ?? 0);
$comment = trim($_POST['comment'] ?? '');


if ($name==='' || $phone==='' || !$plot) { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Проверьте поля']); exit; }


$pdo = pdo();
try {
$pdo->beginTransaction();


$q = $pdo->prepare("SELECT status FROM plots WHERE id=? FOR UPDATE");
$q->execute([$plot]);
$row = $q->fetch();
if (!$row) { throw new RuntimeException('Участок не найден'); }



if ($row['status']==='hold') {
$pdo->exec("UPDATE plots SET status='available', hold_until=NULL WHERE id=".intval($plot)." AND status='hold' AND hold_until < NOW()");
$q->execute([$plot]); $row = $q->fetch();
}


if ($row['status']!=='available') { $pdo->rollBack(); echo json_encode(['ok'=>false,'error'=>'Участок недоступен']); exit; }



$pdo->prepare("UPDATE plots SET status='hold', hold_until=DATE_ADD(NOW(), INTERVAL ".intval(HOLD_HOURS)." HOUR) WHERE id=?")->execute([$plot]);


$pdo->prepare("INSERT INTO reservations(plot_id,name,phone,comment) VALUES(?,?,?,?)")
->execute([$plot,$name,$phone,$comment]);
$resId = $pdo->lastInsertId();


$pdo->commit();


$text = "<b>Новая бронь участка №{$plot}</b>\nИмя: ".htmlspecialchars($name,ENT_QUOTES)."\nТелефон: ".htmlspecialchars($phone,ENT_QUOTES);
if ($comment!=='') $text .= "\nКомментарий: ".htmlspecialchars($comment,ENT_QUOTES);


$kb = ['inline_keyboard'=>[[
['text'=>'✅ Подтвердить продажу','callback_data'=>"confirm:$plot:$resId"],
['text'=>'↩️ Снять бронь','callback_data'=>"release:$plot:$resId"]
]]];


$payload = [
'chat_id'=>CHAT_ID,
'text'=>$text,
'parse_mode'=>'HTML',
'reply_markup'=>json_encode($kb, JSON_UNESCAPED_UNICODE)
];
@file_get_contents('https://api.telegram.org/bot'.BOT_TOKEN.'/sendMessage?'.http_build_query($payload));


echo json_encode(['ok'=>true]);


} catch(Throwable $e){
if ($pdo->inTransaction()) $pdo->rollBack();
http_response_code(500); echo json_encode(['ok'=>false,'error'=>'Ошибка сервера']);
}