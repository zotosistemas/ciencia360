<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'Ciencia360') ?></title>
  <meta name="description" content="<?= htmlspecialchars($metaDescription ?? 'Ciencia clara y visual') ?>">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/styles.css" rel="stylesheet">

  <?php if (!empty(\Ciencia360\Config\Config::get('ADSENSE_CLIENT'))): ?>
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=<?= \Ciencia360\Config\Config::get('ADSENSE_CLIENT') ?>" crossorigin="anonymous"></script>
  <?php endif; ?>
</head>
<body class="about-bg">
