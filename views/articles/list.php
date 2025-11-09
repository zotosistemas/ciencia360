<main class="py-4 container">
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
    <div>
      <h1 class="h2 mb-1" style="color: var(--color-primary);">Artículos</h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
          <li class="breadcrumb-item active" aria-current="page">Artículos</li>
        </ol>
      </nav>
    </div>
    <form class="d-flex gap-2 mt-3 mt-md-0" role="search" method="get" action="articulos.php">
      <input class="form-control" type="search" name="q" placeholder="Buscar artículos..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" />
      <select class="form-select" name="tema">
        <option value="">Todos los temas</option>
        <option value="ciencia-tecnologia" <?= (($_GET['tema'] ?? '') === 'ciencia-tecnologia') ? 'selected' : ''; ?>>Ciencia y Tecnología</option>
        <option value="medio-ambiente" <?= (($_GET['tema'] ?? '') === 'medio-ambiente') ? 'selected' : ''; ?>>Medio Ambiente</option>
        <option value="salud-biologia" <?= (($_GET['tema'] ?? '') === 'salud-biologia') ? 'selected' : ''; ?>>Salud y Biología</option>
        <option value="espacio-futuro" <?= (($_GET['tema'] ?? '') === 'espacio-futuro') ? 'selected' : ''; ?>>Espacio y Futuro</option>
      </select>
      <select class="form-select" name="orden">
        <option value="recientes" <?= (($_GET['orden'] ?? 'recientes') === 'recientes') ? 'selected' : ''; ?>>Más recientes</option>
        <option value="populares" <?= (($_GET['orden'] ?? '') === 'populares') ? 'selected' : ''; ?>>Más leídos</option>
      </select>
      <button class="btn btn-primary">Filtrar</button>
    </form>
  </div>

  <div class="row g-4">
    <div class="col-lg-8">
      <div class="row g-4">
        <?php if (empty($data['items'])): ?>
          <div class="col-12">
            <div class="alert alert-info">Aún no hay artículos publicados. Inserta datos en la tabla <code>articulos</code>.</div>
          </div>
        <?php endif; ?>

        <?php foreach ($data['items'] as $art): ?>
          <div class="col-md-6">
            <article class="card h-100 shadow-sm">
              <a href="articulo.php?slug=<?= urlencode($art['slug']) ?>" class="ratio ratio-16x9">
                <img src="assets/images/<?= htmlspecialchars($art['imagen'] ?? 'placeholder.jpg') ?>" class="card-img-top object-fit-cover" alt="<?= htmlspecialchars($art['titulo']) ?>" loading="lazy" />
              </a>
              <div class="card-body d-flex flex-column">
                <a class="badge text-bg-info mb-2" href="articulos.php?tema=<?= urlencode($art['tema']) ?>"><?= htmlspecialchars(ucwords(str_replace('-', ' ', $art['tema']))) ?></a>
                <h2 class="h5">
                  <a href="articulo.php?slug=<?= urlencode($art['slug']) ?>" class="stretched-link text-decoration-none" style="color: var(--color-primary);">
                    <?= htmlspecialchars($art['titulo']) ?>
                  </a>
                </h2>
                <p class="text-muted mb-2 small"><?= date('d M Y', strtotime($art['fecha_publicacion'])) ?> · <?= (int)$art['visitas'] ?> visitas</p>
                <p class="mb-0"><?= htmlspecialchars($art['resumen'] ?? '') ?></p>
              </div>
            </article>
          </div>
        <?php endforeach; ?>
      </div>

      <?php if (($data['pages'] ?? 1) > 1): ?>
        <nav class="mt-4" aria-label="Paginación">
          <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $data['pages']; $i++): ?>
              <?php
              $query = $_GET;
              $query['page'] = $i;
              $url = 'articulos.php?' . http_build_query($query);
              ?>
              <li class="page-item <?= $i == ($data['page'] ?? 1) ? 'active' : '' ?>">
                <a class="page-link" href="<?= htmlspecialchars($url) ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      <?php endif; ?>
    </div>

    <aside class="col-lg-4">
      <div class="mb-4 text-center">
        <div class="ad-slot p-4" style="display:block; width:100%; min-height:250px; background:#fff; border:1px dashed #e5e7eb; border-radius:12px;">
          <small class="text-muted">Espacio publicitario 300×250</small>
        </div>
      </div>

      <!-- <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white"><strong>Más leídos</strong></div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><a href="#" class="text-decoration-none">Ejemplo 1</a></li>
          <li class="list-group-item"><a href="#" class="text-decoration-none">Ejemplo 2</a></li>
          <li class="list-group-item"><a href="#" class="text-decoration-none">Ejemplo 3</a></li>
        </ul>
      </div> -->
      <aside class="card mb-4 shadow-sm">
        <div class="card-header fw-semibold">Más leídos (30 días)</div>
        <ul class="list-group list-group-flush">
          <?php if (!empty($mostRead)): ?>
            <?php foreach ($mostRead as $mr): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="articulo.php?slug=<?= urlencode($mr['slug']) ?>">
                  <?= htmlspecialchars($mr['titulo']) ?>
                </a>
                <span class="badge rounded-pill text-bg-light"><?= (int)($mr['views'] ?? 0) ?></span>
              </li>
            <?php endforeach; ?>
          <?php else: ?>
            <li class="list-group-item text-muted">Aún no hay datos.</li>
          <?php endif; ?>
        </ul>
      </aside>

      <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white"><strong>Categorías</strong></div>
        <div class="list-group list-group-flush">
          <a class="list-group-item list-group-item-action" href="articulos.php?tema=ciencia-tecnologia">Ciencia y Tecnología</a>
          <a class="list-group-item list-group-item-action" href="articulos.php?tema=medio-ambiente">Medio Ambiente</a>
          <a class="list-group-item list-group-item-action" href="articulos.php?tema=salud-biologia">Salud y Biología</a>
          <a class="list-group-item list-group-item-action" href="articulos.php?tema=espacio-futuro">Espacio y Futuro</a>
        </div>
      </div>
    </aside>
  </div>
</main>