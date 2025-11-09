<header>
  <nav class="navbar navbar-expand-lg navbar-light fixed-top nav-articles">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
        <img src="assets/images/logo.png" alt="Ciencia360" width="92" height="64">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navArticulos"
        aria-controls="navArticulos" aria-expanded="false" aria-label="Abrir menú">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navArticulos">
        <ul class="navbar-nav ms-auto align-items-lg-center">
          <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="articulos.php?orden=recientes">Últimos</a></li>
          <li class="nav-item"><a class="nav-link" href="articulos.php?orden=populares">Populares</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="catDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categorías</a>
            <ul class="dropdown-menu" aria-labelledby="catDropdown">
              <li><a class="dropdown-item" href="articulos.php?tema=ciencia-tecnologia">Ciencia y Tecnología</a></li>
              <li><a class="dropdown-item" href="articulos.php?tema=medio-ambiente">Medio Ambiente</a></li>
              <li><a class="dropdown-item" href="articulos.php?tema=salud-biologia">Salud y Biología</a></li>
              <li><a class="dropdown-item" href="articulos.php?tema=espacio-futuro">Espacio y Futuro</a></li>
            </ul>
          </li>
          <!-- <li class="nav-item"><a class="nav-link" href="articulos.php?tipo=infografia">Infografías</a></li>
          <li class="nav-item"><a class="nav-link" href="articulos.php?tipo=video">Videos</a></li>
          <li class="nav-item ms-lg-3">
            <a class="btn btn-primary rounded-pill px-3" href="#suscripcion">Suscríbete</a>
          </li> -->
        </ul>
      </div>
    </div>
  </nav>
</header>