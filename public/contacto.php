<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';

use Ciencia360\Config\Config;

Config::load(__DIR__ . '/../config/.env');

// Generar token CSRF
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

$title = 'Contacto | Ciencia360';
$metaDescription = 'Formulario de contacto para consultas y colaboraciones con Ciencia360.';

include __DIR__ . '/../views/layout/head.php';
include __DIR__ . '/../views/layout/header.php';
?>

<main class="container py-4">
    <h1 class="mb-4">Contáctanos</h1>

    <p>¿Tienes preguntas, sugerencias o deseas colaborar con <strong>Ciencia360</strong>? Completa el siguiente formulario y te responderemos lo antes posible.</p>

    <form action="enviar_contacto.php" method="POST" class="mt-4 p-4 border rounded shadow-sm bg-white">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <div class="mb-3">
            <label class="form-label">Nombre completo</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mensaje</label>
            <textarea name="mensaje" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enviar mensaje</button>
    </form>
</main>

<?php include __DIR__ . '/../views/layout/footer.php'; ?>