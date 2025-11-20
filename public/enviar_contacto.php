<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';

use Ciencia360\Config\Config;

Config::load(__DIR__ . '/../config/.env');

// Solo permitir POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contacto.php');
    exit;
}

// ---------- Protección CSRF ----------
if (
    !isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
    $_POST['csrf_token'] !== $_SESSION['csrf_token']
) {

    $status = 'error';
    $message = 'Token CSRF no válido. Por favor, recarga la página e inténtalo nuevamente.';
} else {

    // ---------- Sanitización ----------
    function limpiar($str)
    {
        return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
    }

    $nombre  = limpiar($_POST['nombre'] ?? '');
    $email   = limpiar($_POST['email'] ?? '');
    $mensaje = limpiar($_POST['mensaje'] ?? '');

    if ($nombre === '' || $email === '' || $mensaje === '') {
        $status = 'error';
        $message = 'Por favor completa todos los campos del formulario.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $status = 'error';
        $message = 'El correo electrónico ingresado no es válido.';
    } else {
        // ---------- Envío de correo ----------
        $destinatario = 'juan.soto.sistemas@gmail.com'; // 👈 REEMPLAZA ESTO POR TU CORREO REAL
        $asunto = 'Nuevo mensaje desde el formulario de contacto - Ciencia360';

        $cuerpo = "Nuevo mensaje desde Ciencia360:\n\n"
            . "Nombre:  {$nombre}\n"
            . "Correo:  {$email}\n"
            . "Mensaje:\n{$mensaje}\n\n"
            . "Fecha: " . date('d/m/Y H:i:s') . "\n"
            . "IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'desconocida') . "\n";

        $headers = "From: Ciencia360 <no-reply@ciencia360.com>\r\n";
        $headers .= "Reply-To: {$email}\r\n";

        $enviado = @mail($destinatario, $asunto, $cuerpo, $headers);

        if ($enviado) {
            $status = 'ok';
            $message = '¡Gracias por tu mensaje! Lo hemos recibido correctamente y te responderemos pronto.';
        } else {
            $status = 'error';
            $message = 'Ocurrió un problema al enviar el mensaje. Por favor inténtalo más tarde.';
        }
    }
}

// ---------- Título y meta ----------
$title = 'Contacto | Ciencia360';
$metaDescription = 'Resultado del envío del formulario de contacto de Ciencia360.';

include __DIR__ . '/../views/layout/head.php';
include __DIR__ . '/../views/layout/header.php';
?>

<main class="container py-4">
    <h1 class="mb-4">Contacto</h1>

    <?php if ($status === 'ok'): ?>
        <div class="alert alert-success" role="alert">
            <?= $message ?>
        </div>
    <?php else: ?>
        <div class="alert alert-danger" role="alert">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <a href="index.php" class="btn btn-outline-primary mt-3">Volver al inicio</a>
    <a href="contacto.php" class="btn btn-link mt-3">Volver al formulario de contacto</a>
</main>

<?php include __DIR__ . '/../views/layout/footer.php'; ?>