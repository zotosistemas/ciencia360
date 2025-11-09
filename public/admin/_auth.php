<?php

// session_start();

// // 1) Cargar el autoloader de Composer (sube 2 niveles desde /public/admin/)
// require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

// use Ciencia360\Config\Config;

// // 2) Cargar variables de entorno
// Config::load(dirname(__DIR__, 2) . '/config/.env');

// // 3) Helpers de sesión
// function admin_logged(): bool
// {
//   return !empty($_SESSION['admin_logged']);
// }
// function admin_require()
// {
//   if (!admin_logged()) {
//     header('Location: login.php');
//     exit;
//   }
// }

// function admin_redirect_if_logged()
// {
//   if (admin_logged()) {
//     header('Location: articulos.php');
//     exit;
//   }
// }

session_set_cookie_params([
  'lifetime' => 0,
  'path'     => '/',
  'secure'   => !empty($_SERVER['HTTPS']), // true en producción con HTTPS
  'httponly' => true,
  'samesite' => 'Lax'
]);
session_start();

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Ciencia360\Config\Config;

Config::load(dirname(__DIR__, 2) . '/config/.env');

function admin_logged(): bool
{
  return !empty($_SESSION['admin_logged']);
}

function admin_require()
{
  if (!admin_logged()) {
    header('Location: login.php');
    exit;
  }
}

function admin_redirect_if_logged()
{
  if (admin_logged()) {
    header('Location: articulos.php');
    exit;
  }
}

function csrf_token(): string
{
  if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf'];
}
function csrf_check(string $t): bool
{
  return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $t);
}
