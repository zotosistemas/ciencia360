<?php
// require __DIR__ . '/_auth.php';

// use Ciencia360\Config\Config;

// $title = 'Ingresar | Admin Ciencia360';

// // NUEVO: si ya está logueado, no mostrar login
// admin_redirect_if_logged();

// $error = '';
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   $u = $_POST['user'] ?? '';
//   $p = $_POST['pass'] ?? '';
//   $eu = Config::get('ADMIN_USER', 'admin');
//   $ep = Config::get('ADMIN_PASS', 'admin123');
//   if ($u === $eu && $p === $ep) {
//     $_SESSION['admin_logged'] = true;
//     header('Location: articulos.php');
//     exit;
//   } else {
//     $error = 'Usuario o contraseña inválidos';
//   }
// }
// include __DIR__ . '/_layout_header.php';
// 

require __DIR__ . '/_auth.php';

use Ciencia360\Config\Config;

$title = 'Ingresar | Admin Ciencia360';
admin_redirect_if_logged();

$error = '';
// Rate limit simple (por IP o sesión)
$maxAttempts = 5;
$lockSeconds = 10 * 60; // 10 min

if (!isset($_SESSION['login_attempts'])) {
  $_SESSION['login_attempts'] = 0;
  $_SESSION['login_lock_until'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Lock activo
  if (time() < ($_SESSION['login_lock_until'] ?? 0)) {
    $error = 'Espera unos minutos antes de intentar nuevamente.';
  } else {
    $u   = trim($_POST['user'] ?? '');
    $p   = (string)($_POST['pass'] ?? '');
    $tok = (string)($_POST['csrf'] ?? '');

    $eu  = Config::get('ADMIN_USER', 'admin');
    $hp  = Config::get('ADMIN_PASS_HASH', ''); // <-- HASH en .env

    // CSRF
    if (!csrf_check($tok)) {
      $error = 'Solicitud inválida.';
    } else {
      // Comparación segura: user + password_hash
      if (hash_equals($eu, $u) && $hp && password_verify($p, $hp)) {
        session_regenerate_id(true);                 // <-- Importante
        $_SESSION['admin_logged'] = true;
        $_SESSION['username']     = $u;
        $_SESSION['login_attempts'] = 0;
        $_SESSION['login_lock_until'] = 0;
        header('Location: articulos.php');           // o articulo-form.php
        exit;
      } else {
        // fallo
        $_SESSION['login_attempts']++;
        if ($_SESSION['login_attempts'] >= $maxAttempts) {
          $_SESSION['login_lock_until'] = time() + $lockSeconds;
          $_SESSION['login_attempts']   = 0; // resetea contador
        }
        $error = 'Credenciales inválidas.'; // mensaje genérico
      }
    }
  }
}

include __DIR__ . '/_layout_header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-4">
    <h1 class="h4 mb-3">Panel de administración</h1>
    <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post" autocomplete="off">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token()) ?>">
      <div class="mb-3"><label class="form-label">Usuario</label><input type="text" class="form-control" name="user" required></div>
      <div class="mb-3"><label class="form-label">Contraseña</label><input type="password" class="form-control" name="pass" required></div>
      <button class="btn btn-primary w-100">Ingresar</button>
    </form>
  </div>
</div>
<?php include __DIR__ . '/_layout_footer.php'; ?>