<?php
require __DIR__ . '/_auth.php';
admin_require();
require __DIR__ . '/../../vendor/autoload.php';

use Ciencia360\Config\Database;

$pdo = Ciencia360\Config\Database::pdo();
if (($_GET['action'] ?? '') === 'delete' && isset($_GET['id'])) {
  $id = (int) $_GET['id'];
  $pdo->prepare("DELETE FROM articulos WHERE id = ?")->execute([$id]);
  header('Location: articulos.php?msg=deleted');
  exit;
}
$q = trim($_GET['q'] ?? '');
$tema = $_GET['tema'] ?? '';
$estado = $_GET['estado'] ?? '';
$sql = "SELECT * FROM articulos WHERE 1=1";
$params = [];
if ($q !== '') {
  $sql .= " AND (titulo LIKE ? OR resumen LIKE ?)";
  $params[] = "%$q%";
  $params[] = "%$q%";
}
if ($tema !== '') {
  $sql .= " AND tema = ?";
  $params[] = $tema;
}
if ($estado !== '') {
  $sql .= " AND estado = ?";
  $params[] = $estado;
}
$sql .= " ORDER BY updated_at DESC, id DESC";
$st = $pdo->prepare($sql);
$st->execute($params);
$items = $st->fetchAll();
$title = 'Artículos | Admin Ciencia360';
include __DIR__ . '/_layout_header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4 mb-0">Artículos</h1>
  <a href="articulo-form.php" class="btn btn-primary">Nuevo artículo</a>
</div>
<form class="row gy-2 gx-2 mb-3">
  <div class="col-md-4"><input class="form-control" type="search" name="q" placeholder="Buscar..." value="<?= htmlspecialchars($q) ?>"></div>
  <div class="col-md-3">
    <select name="tema" class="form-select">
      <option value="">Todos los temas</option>
      <option value="ciencia-tecnologia" <?= $tema === 'ciencia-tecnologia' ? 'selected' : ''; ?>>Ciencia y Tecnología</option>
      <option value="medio-ambiente" <?= $tema === 'medio-ambiente' ? 'selected' : ''; ?>>Medio Ambiente</option>
      <option value="salud-biologia" <?= $tema === 'salud-biologia' ? 'selected' : ''; ?>>Salud y Biología</option>
      <option value="espacio-futuro" <?= $tema === 'espacio-futuro' ? 'selected' : ''; ?>>Espacio y Futuro</option>
    </select>
  </div>
  <div class="col-md-3">
    <select name="estado" class="form-select">
      <option value="">Todos los estados</option>
      <option value="publicado" <?= $estado === 'publicado' ? 'selected' : ''; ?>>Publicado</option>
      <option value="borrador" <?= $estado === 'borrador' ? 'selected' : ''; ?>>Borrador</option>
    </select>
  </div>
  <div class="col-md-2"><button class="btn btn-outline-secondary w-100">Filtrar</button></div>
</form>
<?php if (isset($_GET['msg']) && $_GET['msg'] === 'saved'): ?>
  <div class="alert alert-success">Artículo guardado correctamente.</div>
<?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
  <div class="alert alert-warning">Artículo eliminado.</div>
<?php endif; ?>
<div class="table-responsive">
  <table class="table table-hover align-middle">
    <thead>
      <tr>
        <th>ID</th>
        <th>Imagen</th>
        <th>Título</th>
        <th>Tema</th>
        <th>Tipo</th>
        <th>Estado</th>
        <th>Actualizado</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($items as $it): ?>
        <tr>
          <td><?= (int)$it['id'] ?></td>
          <td><?php if (!empty($it['imagen'])): ?><img class="img-thumb" src="../assets/images/<?= htmlspecialchars($it['imagen']) ?>" alt=""><?php endif; ?></td>
          <td><a href="articulo-form.php?id=<?= (int)$it['id'] ?>"><?= htmlspecialchars($it['titulo']) ?></a></td>
          <td><?= htmlspecialchars($it['tema']) ?></td>
          <td><?= htmlspecialchars($it['tipo'] ?? 'articulo') ?></td>
          <td><span class="badge <?= ($it['estado'] ?? 'publicado') === 'publicado' ? 'text-bg-success' : 'text-bg-secondary' ?>"><?= htmlspecialchars($it['estado'] ?? 'publicado') ?></span></td>
          <td><?= htmlspecialchars($it['updated_at'] ?? $it['fecha_publicacion']) ?></td>
          <td class="text-end">
            <a class="btn btn-sm btn-outline-primary" href="../articulo.php?slug=<?= urlencode($it['slug']) ?>" target="_blank">Ver</a>
            <a class="btn btn-sm btn-outline-secondary" href="articulo-form.php?id=<?= (int)$it['id'] ?>">Editar</a>
            <a class="btn btn-sm btn-outline-danger" href="articulos.php?action=delete&id=<?= (int)$it['id'] ?>" onclick="return confirm('¿Eliminar artículo?');">Eliminar</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php include __DIR__ . '/_layout_footer.php'; ?>