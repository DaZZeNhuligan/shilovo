<?php
header('Content-Type: application/json; charset=utf-8');
require __DIR__.'/../../db.php';

$pdo = pdo();
$pdo->exec("UPDATE plots
  SET status='available', hold_until=NULL
  WHERE status='hold' AND hold_until IS NOT NULL AND hold_until < NOW()");

$rows = $pdo->query("SELECT id, area_sot, price_rub, pkk_url, status, geometry_json
                     FROM plots ORDER BY id")->fetchAll();

foreach ($rows as &$r) {
    
    $r['geometry_json'] = $r['geometry_json']
        ? json_decode($r['geometry_json'], true)
        : [];
}

echo json_encode(['plots' => $rows], JSON_UNESCAPED_UNICODE);