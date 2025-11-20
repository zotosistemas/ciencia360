<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'Ciencia360') ?></title>
  <meta name="description" content="<?= htmlspecialchars($metaDescription ?? 'Ciencia clara y visual') ?>">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome (iconos) -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />

  <!-- Estilos propios -->
  <link href="assets/css/styles.css" rel="stylesheet">

  <?php if (!empty(\Ciencia360\Config\Config::get('ADSENSE_CLIENT'))): ?>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=<?= \Ciencia360\Config\Config::get('ADSENSE_CLIENT') ?>" crossorigin="anonymous"></script>
  <?php endif; ?>
</head>

<body class="about-bg">