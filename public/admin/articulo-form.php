<?php
require __DIR__ . '/_auth.php';
admin_require();
require __DIR__ . '/../../vendor/autoload.php';

use Ciencia360\Config\Database;
use Ciencia360\Config\Config;

$tinyKey = Config::get('TINYMCE_API_KEY', 'no-api-key');
function slugify(string $text): string
{
  $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  $text = trim($text, '-');
  $text = strtolower($text);
  $text = preg_replace('~[^-a-z0-9]+~', '', $text);
  if (empty($text)) return 'articulo-' . time();
  return $text;
}
function slug_exists(PDO $pdo, string $slug, ?int $excludeId = null): bool
{
  if ($excludeId) {
    $st = $pdo->prepare("SELECT 1 FROM articulos WHERE slug = ? AND id <> ? LIMIT 1");
    $st->execute([$slug, $excludeId]);
  } else {
    $st = $pdo->prepare("SELECT 1 FROM articulos WHERE slug = ? LIMIT 1");
    $st->execute([$slug]);
  }
  return (bool)$st->fetchColumn();
}
$pdo = Database::pdo();
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$item = null;
if ($id) {
  $st = $pdo->prepare("SELECT * FROM articulos WHERE id = ?");
  $st->execute([$id]);
  $item = $st->fetch();
  if (!$item) {
    http_response_code(404);
    echo 'No encontrado';
    exit;
  }
}
$errors = [];
function convert_to_webp($srcPath, $mime, $quality = 82)
{
  if (!function_exists('imagewebp')) return null;
  switch ($mime) {
    case 'image/jpeg':
      $src = imagecreatefromjpeg($srcPath);
      break;
    case 'image/png':
      $src = imagecreatefrompng($srcPath);
      imagepalettetotruecolor($src);
      imagealphablending($src, true);
      imagesavealpha($src, true);
      break;
    case 'image/gif':
      $src = imagecreatefromgif($srcPath);
      break;
    case 'image/webp':
      return basename($srcPath);
    default:
      return null;
  }
  if (!$src) return null;
  $webpPath = preg_replace('/\.[a-zA-Z0-9]+$/', '.webp', $srcPath);
  if (imagewebp($src, $webpPath, $quality)) {
    imagedestroy($src);
    return basename($webpPath);
  }
  imagedestroy($src);
  return null;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $titulo = trim($_POST['titulo'] ?? '');
  $slug = trim($_POST['slug'] ?? '');
  $resumen = trim($_POST['resumen'] ?? '');
  $contenido = $_POST['contenido'] ?? '';
  $tema = $_POST['tema'] ?? 'ciencia-tecnologia';
  $tipo = $_POST['tipo'] ?? 'articulo';
  $estado = $_POST['estado'] ?? 'publicado';
  $autor = trim($_POST['autor'] ?? 'Redacción Ciencia360');
  $fecha_publicacion = $_POST['fecha_publicacion'] ?? date('Y-m-d H:i:s');
  if ($slug === '') $slug = slugify($titulo);
  if (slug_exists($pdo, $slug, $id ?: null)) {
    $base = $slug;
    $i = 2;
    while (slug_exists($pdo, $base . '-' . $i, $id ?: null)) {
      $i++;
    }
    $suggested = $base . '-' . $i;
    $errors[] = "El slug «{$slug}» ya existe. Sugerencia: «{$suggested}».";
  }
  $imagen = $item['imagen'] ?? null;
  if (!empty($_FILES['imagen']['name']) && is_uploaded_file($_FILES['imagen']['tmp_name'])) {
    $tmp = $_FILES['imagen']['tmp_name'];
    $size = (int) $_FILES['imagen']['size'];
    $maxBytes = 3 * 1024 * 1024;
    if ($size > $maxBytes) {
      $errors[] = "La imagen de portada supera 3MB.";
    }
    $info = @getimagesize($tmp);
    if (!$info) {
      $errors[] = "No se pudo leer la imagen de portada.";
    } else {
      list($w, $h) = $info;
      if ($w < 600 || $h < 400) {
        $errors[] = "Portada: mín 600x400 px.";
      } elseif ($w > 4000 || $h > 4000) {
        $errors[] = "Portada: máx 4000x4000 px.";
      }
    }
  }
  if (!empty($errors)) {
    $item = ['titulo' => $titulo, 'slug' => $slug, 'resumen' => $resumen, 'contenido' => $contenido, 'tema' => $tema, 'tipo' => $tipo, 'estado' => $estado, 'autor' => $autor, 'fecha_publicacion' => $fecha_publicacion, 'imagen' => $item['imagen'] ?? null];
  } else {
    if (!empty($_FILES['imagen']['name']) && is_uploaded_file($_FILES['imagen']['tmp_name'])) {
      $finfo = new finfo(FILEINFO_MIME_TYPE);
      $mime = $finfo->file($_FILES['imagen']['tmp_name']);
      $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION) or 'jpg');
      $fname = $slug . '-' . time() . '.' . $ext;
      $dest = __DIR__ . '/../assets/images/' . $fname;
      if (move_uploaded_file($_FILES['imagen']['tmp_name'], $dest)) {
        $webp = convert_to_webp($dest, $mime);
        if ($webp) {
          $imagen = $webp;
        } else {
          $imagen = $fname;
        }
      }
    }
    if ($id) {
      $sql = "UPDATE articulos SET slug=?, titulo=?, resumen=?, contenido=?, imagen=?, tema=?, autor=?, fecha_publicacion=?, estado=?, tipo=? WHERE id=?";
      $pdo->prepare($sql)->execute([$slug, $titulo, $resumen, $contenido, $imagen, $tema, $autor, $fecha_publicacion, $estado, $tipo, $id]);
    } else {
      $sql = "INSERT INTO articulos (slug,titulo,resumen,contenido,imagen,tema,autor,fecha_publicacion,estado,tipo) VALUES (?,?,?,?,?,?,?,?,?,?)";
      $pdo->prepare($sql)->execute([$slug, $titulo, $resumen, $contenido, $imagen, $tema, $autor, $fecha_publicacion, $estado, $tipo]);
      $id = (int)$pdo->lastInsertId();
    }
    header('Location: articulos.php?msg=saved');
    exit;
  }
}
$title = ($id ? 'Editar' : 'Nuevo') . ' artículo | Admin Ciencia360';
include __DIR__ . '/_layout_header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4 mb-0"><?= $id ? 'Editar' : 'Nuevo' ?> artículo</h1>
  <a href="articulos.php" class="btn btn-outline-secondary">Volver</a>
</div>
<?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    <ul class="mb-0"><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
  </div>
<?php endif; ?>
<form method="post" enctype="multipart/form-data" class="row g-3">
  <input type="hidden" id="article-id" value="<?= $id ? (int)$id : '' ?>">
  <div class="col-md-8">
    <div class="mb-3">
      <label class="form-label">Título</label>
      <input type="text" name="titulo" class="form-control" required value="<?= htmlspecialchars($item['titulo'] ?? '') ?>">
    </div>
    <div class="mb-1 d-flex align-items-center gap-2">
      <div class="flex-grow-1">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" class="form-control" placeholder="si lo dejas vacío, se genera automáticamente" value="<?= htmlspecialchars($item['slug'] ?? '') ?>">
        <div class="help-text">URL del artículo. Ejemplo: <code>las-estrellas-mas-brillantes</code> | <span id="slug-status" class="slug-status"></span></div>
      </div>
      <div class="mt-4">
        <button id="btn-genera-slug" class="btn btn-outline-secondary" title="Generar desde título">Generar desde título</button>
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Resumen</label>
      <textarea name="resumen" class="form-control" rows="3"><?= htmlspecialchars($item['resumen'] ?? '') ?></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Contenido (HTML)</label>
      <textarea id="contenido" name="contenido" class="form-control" rows="14"><?= htmlspecialchars($item['contenido'] ?? '') ?></textarea>
      <div class="form-text">Inserta imágenes desde el editor (se suben al servidor). Peso máx 3MB, mín. 600x400 px.</div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="mb-3">
      <label class="form-label">Tema</label>
      <select name="tema" class="form-select">
        <?php $temaSel = $item['tema'] ?? 'ciencia-tecnologia'; ?>
        <option value="ciencia-tecnologia" <?= $temaSel === 'ciencia-tecnologia' ? 'selected' : ''; ?>>Ciencia y Tecnología</option>
        <option value="medio-ambiente" <?= $temaSel === 'medio-ambiente' ? 'selected' : ''; ?>>Medio Ambiente</option>
        <option value="salud-biologia" <?= $temaSel === 'salud-biologia' ? 'selected' : ''; ?>>Salud y Biología</option>
        <option value="espacio-futuro" <?= $temaSel === 'espacio-futuro' ? 'selected' : ''; ?>>Espacio y Futuro</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Tipo</label>
      <?php $tipoSel = $item['tipo'] ?? 'articulo'; ?>
      <select name="tipo" class="form-select">
        <option value="articulo" <?= $tipoSel === 'articulo' ? 'selected' : ''; ?>>Artículo</option>
        <option value="infografia" <?= $tipoSel === 'infografia' ? 'selected' : ''; ?>>Infografía</option>
        <option value="video" <?= $tipoSel === 'video' ? 'selected' : ''; ?>>Video</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Estado</label>
      <?php $estadoSel = $item['estado'] ?? 'publicado'; ?>
      <select name="estado" class="form-select">
        <option value="publicado" <?= $estadoSel === 'publicado' ? 'selected' : ''; ?>>Publicado</option>
        <option value="borrador" <?= $estadoSel === 'borrador' ? 'selected' : ''; ?>>Borrador</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Autor</label>
      <input type="text" name="autor" class="form-control" value="<?= htmlspecialchars($item['autor'] ?? 'Redacción Ciencia360') ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Fecha publicación</label>
      <input type="datetime-local" name="fecha_publicacion" class="form-control"
        value="<?= htmlspecialchars(isset($item['fecha_publicacion']) ? date('Y-m-d\TH:i', strtotime($item['fecha_publicacion'])) : date('Y-m-d\TH:i')) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Imagen portada (subir)</label>
      <input type="file" name="imagen" class="form-control" accept="image/*">
      <div class="form-text">Peso máx 3MB. Dimensiones mínimas 600x400 px (máx 4000x4000 px). Se convertirá a WebP si el servidor lo permite.</div>
      <?php if (!empty($item['imagen'])): ?>
        <img src="../assets/images/<?= htmlspecialchars($item['imagen']) ?>" class="img-fluid mt-2 rounded" style="max-height:140px" alt="">
      <?php endif; ?>
    </div>
    <button class="btn btn-primary w-100"><?= $id ? 'Actualizar' : 'Publicar' ?></button>
  </div>
</form>
<?php include __DIR__ . '/_layout_footer.php'; ?>