<?php
require __DIR__ . '/../vendor/autoload.php';

use Ciencia360\Config\Config;

Config::load(__DIR__ . '/../config/.env');

$title = 'Política de cookies | Ciencia360';
$metaDescription = 'Política de cookies utilizada por el sitio Ciencia360.';

include __DIR__ . '/../views/layout/head.php';
include __DIR__ . '/../views/layout/header.php';
?>

<main class="container py-4">
    <h1 class="mb-4">Política de Cookies</h1>

    <p>En <strong>Ciencia360</strong> utilizamos cookies para mejorar la experiencia del usuario, analizar el tráfico del sitio y mostrar anuncios relevantes a través de Google AdSense.</p>

    <h2>1. ¿Qué son las cookies?</h2>
    <p>Las cookies son pequeños archivos de texto que se almacenan en tu dispositivo cuando visitas un sitio web. Permiten recordar tus preferencias y registrar cierta actividad de navegación.</p>

    <h2>2. Tipos de cookies que utilizamos</h2>
    <ul>
        <li><strong>Cookies esenciales:</strong> necesarias para el funcionamiento básico del sitio.</li>
        <li><strong>Cookies de análisis:</strong> nos ayudan a entender cómo se utiliza el sitio (por ejemplo, mediante herramientas de analítica).</li>
        <li><strong>Cookies publicitarias:</strong> utilizadas por Google AdSense u otros socios para mostrar anuncios personalizados o basados en tus intereses.</li>
    </ul>

    <h2>3. Cookies de Google AdSense</h2>
    <p>Google puede utilizar cookies, como la cookie de DoubleClick, para mostrar anuncios basados en las visitas anteriores del usuario a nuestro sitio u otros sitios de Internet. Puedes gestionar o desactivar la publicidad personalizada desde:</p>
    <p>
        <a href="https://www.google.com/settings/ads" target="_blank" rel="noopener noreferrer">
            Configuración de anuncios de Google
        </a>
    </p>

    <h2>4. Cómo gestionar las cookies</h2>
    <p>Puedes configurar tu navegador para bloquear o eliminar cookies. Los pasos varían según el navegador, pero normalmente se encuentran en el apartado de <em>Privacidad</em> o <em>Seguridad</em>:</p>
    <ul>
        <li>Chrome: Configuración &gt; Privacidad y seguridad &gt; Cookies.</li>
        <li>Firefox: Opciones &gt; Privacidad y seguridad.</li>
        <li>Safari: Preferencias &gt; Privacidad.</li>
        <li>Edge: Configuración &gt; Cookies y permisos del sitio.</li>
    </ul>

    <p>Ten en cuenta que desactivar cookies puede afectar el funcionamiento de algunas partes del sitio.</p>

    <p class="text-muted mt-4">Última actualización: <?= date('d/m/Y') ?></p>
</main>

<?php include __DIR__ . '/../views/layout/footer.php'; ?>