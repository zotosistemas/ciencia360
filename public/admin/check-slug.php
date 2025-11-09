<?php
require __DIR__ . '/_auth.php';
admin_require();
require __DIR__ . '/../../vendor/autoload.php';
use Ciencia360\Config\Database;
header('Content-Type: application/json');
$pdo = Database::pdo();
$slug = trim($_GET['slug'] ?? '');
$excludeId = isset($_GET['excludeId']) ? (int) $_GET['excludeId'] : null;
if ($slug === '') { echo json_encode(['exists'=>false]); exit; }
if ($excludeId) {
  $st = $pdo->prepare("SELECT 1 FROM articulos WHERE slug = ? AND id <> ? LIMIT 1");
  $st->execute([$slug, $excludeId]);
} else {
  $st = $pdo->prepare("SELECT 1 FROM articulos WHERE slug = ? LIMIT 1");
  $st->execute([$slug]);
}
$exists = (bool)$st->fetchColumn();
$suggestion = null;
if ($exists) {
  $base = $slug; $i=2;
  do {
    $try = $base.'-'+$i;
    if ($excludeId) {
      $t = $pdo->prepare("SELECT 1 FROM articulos WHERE slug = ? AND id <> ? LIMIT 1");
      $t->execute([$try, $excludeId]);
    } else {
      $t = $pdo->prepare("SELECT 1 FROM articulos WHERE slug = ? LIMIT 1");
      $t->execute([$try]);
    }
    $existsTry = (bool)$t->fetchColumn();
    if (!$existsTry) { $suggestion = $try; break; }
    $i++;
  } while ($i < 9999);
}
echo json_encode(['exists'=>$exists, 'suggestion'=>$suggestion]);
