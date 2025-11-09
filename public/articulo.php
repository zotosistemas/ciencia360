<?php
require __DIR__ . '/../vendor/autoload.php';

use Ciencia360\Config\Config;
use Ciencia360\Repositories\ArticleRepository;
use Ciencia360\Services\ArticleService;
use Ciencia360\Config\Database;
use Ciencia360\Support\Cache;

// Cargar variables de entorno
Config::load(__DIR__ . '/../config/.env');

$slug = $_GET['slug'] ?? '';
if (!$slug) {
  header('Location: articulos.php');
  exit;
}

$service = new ArticleService(new ArticleRepository());
$art = $service->detailBySlug($slug);
if (!$art) {
  http_response_code(404);
  echo 'Artículo no encontrado.';
  exit;
}

$title = $art['titulo'] . ' | Ciencia360';
$metaDescription = $art['resumen'] ?? '';

// =========================
// Conteo de vistas por periodo + Bot filter + Cookie throttle
// =========================
$cookieKey = 'viewed_' . (int)$art['id'];
$throttleHit = !empty($_COOKIE[$cookieKey]);
if (!$throttleHit) {
  setcookie($cookieKey, '1', time() + 6 * 3600, "/");
}

$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
$uaLower = strtolower($ua);
$isBot = (
  $uaLower === '' ||
  str_contains($uaLower, 'bot') ||
  str_contains($uaLower, 'crawler') ||
  str_contains($uaLower, 'spider') ||
  str_contains($uaLower, 'curl') ||
  str_contains($uaLower, 'wget') ||
  str_contains($uaLower, 'python-requests') ||
  str_contains($uaLower, 'monitoring') ||
  str_contains($uaLower, 'headless')
);

if (!$isBot && !$throttleHit) {
  $pdo = Database::pdo();
  $ipRaw = $_SERVER['REMOTE_ADDR'] ?? null;
  $ipBin = null;
  if ($ipRaw && filter_var($ipRaw, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) $ipBin = inet_pton($ipRaw);
  elseif ($ipRaw && filter_var($ipRaw, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) $ipBin = inet_pton($ipRaw);
  $st = $pdo->prepare("INSERT INTO article_views (article_id, viewed_at, ip, user_agent) VALUES (?, NOW(), ?, LEFT(?, 255))");
  $st->execute([$art['id'], $ipBin, $ua]);
}

// =========================
// Ads blocks (usa ADSENSE_CLIENT de .env)
// =========================
$adsClient = Config::get('ADSENSE_CLIENT', '');
$adInArticle = $adInArticle2 = $adSidebar = $adDisplayEnd = '';

if (!empty($adsClient)) {
  // In-article 1 (después del 2º párrafo)
  $adInArticle = <<<HTML
  <div class="my-4 ad-slot text-center">
    <ins class="adsbygoogle"
         style="display:block; text-align:center;"
         data-ad-client="{$adsClient}"
         data-ad-slot="1234567890"
         data-adtest="on"
         data-ad-format="fluid"
         data-ad-layout="in-article"></ins>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
  </div>
  HTML;

  // In-article 2 (después del 5º párrafo)
  $adInArticle2 = <<<HTML
  <div class="my-4 ad-slot text-center">
    <ins class="adsbygoogle"
         style="display:block; text-align:center;"
         data-ad-client="{$adsClient}"
         data-ad-slot="2234567890"
         data-adtest="on"
         data-ad-format="fluid"
         data-ad-layout="in-article"></ins>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
  </div>
  HTML;

  // Sidebar (300x600 responsivo)
  $adSidebar = <<<HTML
  <div class="ad-slot-sidebar">
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="{$adsClient}"
         data-ad-slot="3234567890"
         data-adtest="on"
         data-ad-format="auto"
         data-full-width-responsive="false"></ins>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
  </div>
  HTML;

  // Display al final
  $adDisplayEnd = <<<HTML
  <div class="my-4 ad-slot text-center">
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="{$adsClient}"
         data-ad-slot="0987654321"
         data-adtest="on"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
  </div>
  HTML;
}

// =========================
// Cargar 'Más leídos' por periodo con Cache
// =========================
$cache = new Cache(__DIR__ . '/../storage/cache', 600); // 10 min
$period = '30d';
$cacheKey = "mostRead_{$period}_limit5";

$mostRead = $cache->get($cacheKey);
if ($mostRead === null) {
  $mostRead = $service->mostReadByPeriod($period, 5);
  $cache->set($cacheKey, $mostRead);
}

include __DIR__ . '/../views/layout/head.php';
include __DIR__ . '/../views/layout/header.php';
include __DIR__ . '/../views/article/detail.php';
include __DIR__ . '/../views/layout/footer.php';
