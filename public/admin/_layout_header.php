<?php
require_once __DIR__ . '/_auth.php';
$logged = admin_logged();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'Admin | Ciencia360') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      padding-top: 70px;
    }

    .navbar {
      box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
    }

    .table td,
    .table th {
      vertical-align: middle;
    }

    .img-thumb {
      width: 72px;
      height: 48px;
      object-fit: cover;
      border-radius: 6px;
    }

    .help-text {
      font-size: .9rem;
      color: #6b7280;
    }

    .slug-status {
      font-size: .85rem;
    }
  </style>
</head>

<body>
  <?php if ($logged): ?> <!-- ✅ Solo mostrar si hay sesión -->
    <nav class="navbar navbar-expand-lg bg-light fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="articulos.php">Admin Ciencia360</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navAdmin">
          <ul class="navbar-nav me-auto">
            <li class="nav-item"><a href="articulos.php" class="nav-link">Artículos</a></li>
            <li class="nav-item"><a href="../articulos.php" class="nav-link" target="_blank">Ver sitio</a></li>
          </ul>
          <div class="d-flex">
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Salir</a>
          </div>
        </div>
      </div>
    </nav>
  <?php endif; ?>
  <div class="container">