<main class="container py-4">
  <div class="row g-4">
    <div class="col-lg-8">
      <article class="articulo-detalle">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="articulos.php">Artículos</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($art['titulo']) ?></li>
          </ol>
        </nav>

        <h1 class="mb-2"><?= htmlspecialchars($art['titulo']) ?></h1>
        <p class="text-muted">
          <?= date("d M Y", strtotime($art['fecha_publicacion'])) ?>
          — <?= htmlspecialchars($art['autor'] ?? 'Ciencia360') ?>
        </p>

        <?php if (!empty($adTopContent)): ?>
          <div class="mb-3">
            <?= $adTopContent ?>
          </div>
        <?php endif; ?>

        <?php if (!empty($art['imagen'])): ?>
          <img src="assets/images/<?= htmlspecialchars($art['imagen']) ?>"
            class="img-fluid rounded mb-4"
            alt="<?= htmlspecialchars($art['titulo']) ?>">
        <?php endif; ?>

        <?php

        use Ciencia360\Helpers\Utils;

        $contenido = $art['contenido'] ?? '';
        $pCount = Utils::countParagraphs($contenido);

        /**
         * Inyección de anuncios dentro del contenido
         * Reglas:
         * - Después del párrafo 2  → $adInArticle1 (si hay al menos 2 párrafos)
         * - Después del párrafo 5  → $adInArticle2 (si hay al menos 5 párrafos)
         * - Después del párrafo 8  → $adInArticle3 (si hay al menos 8 párrafos)
         */
        $positions = [];
        $ads = [];

        if (!empty($adInArticle1) && $pCount >= 2) {
          $positions[] = 2;
          $ads[] = $adInArticle1;
        }

        if (!empty($adInArticle2) && $pCount >= 5) {
          $positions[] = 5;
          $ads[] = $adInArticle2;
        }

        if (!empty($adInArticle3) && $pCount >= 8) {
          $positions[] = 8;
          $ads[] = $adInArticle3;
        }

        $contenidoRender = (!empty($positions) && !empty($ads))
          ? Utils::injectMultiple($contenido, $positions, $ads)
          : $contenido;
        ?>
        <div class="contenido-articulo">
          <?= $contenidoRender ?>
        </div>

        <?php if (!empty($adDisplayEnd)): ?>
          <?= $adDisplayEnd ?>
        <?php endif; ?>

        <hr class="my-5">

        <?php if (!empty($art['relacionados'])): ?>
          <h3>Artículos relacionados</h3>
          <div class="row g-4">
            <?php foreach ($art['relacionados'] as $rel): ?>
              <div class="col-md-4">
                <div class="card h-100">
                  <a href="articulo.php?slug=<?= urlencode($rel['slug']) ?>" class="ratio ratio-16x9">
                    <img src="assets/images/<?= htmlspecialchars($rel['imagen'] ?? 'placeholder.jpg') ?>"
                      class="card-img-top"
                      alt="<?= htmlspecialchars($rel['titulo']) ?>">
                  </a>
                  <div class="card-body">
                    <a href="articulo.php?slug=<?= urlencode($rel['slug']) ?>"
                      class="stretched-link text-decoration-none">
                      <?= htmlspecialchars($rel['titulo']) ?>
                    </a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div class="mt-4">
          <a href="articulos.php" class="btn btn-outline-primary">← Volver a artículos</a>
        </div>
      </article>
    </div>

    <aside class="col-lg-4 d-none d-lg-block">
      <div class="sidebar-sticky">
        <div class="card shadow-sm mb-4">
          <div class="card-body text-center">
            <?php if (!empty($adSidebar)): ?>
              <?= $adSidebar ?>
            <?php else: ?>
              <div class="p-4 ad-slot" style="background:#fff; border:1px dashed #e5e7eb; border-radius:12px;">
                <small class="text-muted">Espacio publicitario 300×600</small>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <aside class="card">
          <div class="card-header fw-semibold">Más leídos (30 días)</div>
          <ul class="list-group list-group-flush">
            <?php if (!empty($mostRead)): ?>
              <?php foreach ($mostRead as $mr): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <a href="articulo.php?slug=<?= urlencode($mr['slug']) ?>">
                    <?= htmlspecialchars($mr['titulo']) ?>
                  </a>
                  <span class="badge rounded-pill text-bg-light">
                    <?= (int)($mr['views'] ?? 0) ?>
                  </span>
                </li>
              <?php endforeach; ?>
            <?php else: ?>
              <li class="list-group-item text-muted">Aún no hay datos.</li>
            <?php endif; ?>
          </ul>
        </aside>
      </div>
    </aside>
  </div>
</main>