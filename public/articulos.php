<?php
require __DIR__ . '/../vendor/autoload.php';

use Ciencia360\Config\Config;
use Ciencia360\Repositories\ArticleRepository;
use Ciencia360\Services\ArticleService;
use Ciencia360\Http\Request;
use Ciencia360\Support\Cache;

Config::load(__DIR__ . '/../config/.env');

$repo = new ArticleRepository();
$service = new ArticleService($repo);

$filters = [
  'q'     => Request::get('q', ''),
  'tema'  => Request::get('tema', ''),
  'orden' => Request::get('orden', 'recientes'),
];

$page = (int) Request::get('page', 1);
$data = $service->listPaginated($filters, $page, 12);

$title = 'Artículos | Ciencia360';
$metaDescription = 'Explora artículos claros y visuales en ciencia, tecnología y sociedad.';

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
include __DIR__ . '/../views/articles/list.php';
include __DIR__ . '/../views/layout/footer.php';
