<?php
require __DIR__ . '/../vendor/autoload.php';

use Ciencia360\Config\Config;

Config::load(__DIR__ . '/../config/.env');

$title = 'Política de privacidad | Ciencia360';
$metaDescription = 'Política de privacidad de Ciencia360, plataforma de divulgación científica.';

include __DIR__ . '/../views/layout/head.php';
include __DIR__ . '/../views/layout/header.php';
?>

<main class="container py-4">
    <h1 class="mb-4">Política de Privacidad</h1>

    <p>En <strong>Ciencia360</strong>, accesible desde <em>https://tudominio.com</em>, nos comprometemos a proteger la privacidad de nuestros usuarios. Esta Política de Privacidad describe qué datos recopilamos, cómo los utilizamos y los derechos que tienes respecto a tu información.</p>

    <h2>1. Información que recopilamos</h2>
    <p>Podemos recopilar la siguiente información:</p>
    <ul>
        <li>Datos proporcionados por el usuario en formularios de contacto.</li>
        <li>Dirección IP, navegador, país y dispositivo (para estadísticas y seguridad).</li>
        <li>Cookies utilizadas por Google AdSense y herramientas de análisis.</li>
    </ul>

    <h2>2. Uso de la información</h2>
    <p>La información recopilada se utiliza para:</p>
    <ul>
        <li>Mejorar la calidad del contenido y la experiencia de navegación.</li>
        <li>Mostrar publicidad relevante mediante Google AdSense.</li>
        <li>Analizar métricas de rendimiento y uso del sitio.</li>
    </ul>

    <h2>3. Cookies y publicidad</h2>
    <p>Usamos servicios de terceros como Google AdSense, que pueden utilizar cookies para mostrar anuncios personalizados. Puedes gestionar tus preferencias de anuncios desde:</p>
    <p>
        <a href="https://www.google.com/settings/ads" target="_blank" rel="noopener noreferrer">
            https://www.google.com/settings/ads
        </a>
    </p>

    <h2>4. Enlaces externos</h2>
    <p>Ciencia360 puede contener enlaces a otros sitios web. No somos responsables del contenido ni de las políticas de privacidad de dichos sitios externos.</p>

    <h2>5. Derechos del usuario</h2>
    <p>Como usuario, puedes solicitar:</p>
    <ul>
        <li>Acceso a los datos que nos hayas proporcionado.</li>
        <li>Corrección o eliminación de información enviada a través de formularios.</li>
    </ul>

    <h2>6. Conservación de los datos</h2>
    <p>Los datos enviados mediante formularios se conservan durante el tiempo necesario para responder a la consulta o mientras exista una relación activa con el usuario.</p>

    <h2>7. Cambios en esta política</h2>
    <p>Podemos actualizar esta Política de Privacidad para reflejar cambios legales o mejoras del servicio. La versión vigente será siempre la publicada en esta página.</p>

    <p class="text-muted mt-4">Última actualización: <?= date('d/m/Y') ?></p>
</main>

<?php include __DIR__ . '/../views/layout/footer.php'; ?>