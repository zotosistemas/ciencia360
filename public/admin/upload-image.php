<?php
require __DIR__ . '/_auth.php';
admin_require();
header('Content-Type: application/json');
$uploadDir = __DIR__ . '/../assets/images/uploads/';
$publicBase = 'assets/images/uploads/';
if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0775, true); }
if (empty($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) { http_response_code(400); echo json_encode(['error'=>'No se recibió el archivo o hubo un error.']); exit; }
$tmp = $_FILES['file']['tmp_name'];
$name = $_FILES['file']['name'];
$size = (int) $_FILES['file']['size'];
$maxBytes = 3 * 1024 * 1024;
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($tmp);
$allowed = ['image/jpeg'=>'jpg','image/png'=>'png','image/gif'=>'gif','image/webp'=>'webp'];
if (!isset($allowed[$mime])) { http_response_code(400); echo json_encode(['error'=>'Formato no permitido']); exit; }
if ($size > $maxBytes) { http_response_code(400); echo json_encode(['error'=>'La imagen supera 3MB']); exit; }
$info = @getimagesize($tmp);
if (!$info) { http_response_code(400); echo json_encode(['error'=>'No se pudo leer la imagen']); exit; }
list($w,$h) = $info;
if ($w < 600 || $h < 400) { http_response_code(400); echo json_encode(['error'=>'Mínimo 600x400 px']); exit; }
if ($w > 4000 || $h > 4000) { http_response_code(400); echo json_encode(['error'=>'Máximo 4000x4000 px']); exit; }
$ext = $allowed[$mime];
$base = pathinfo($name, PATHINFO_FILENAME);
$base = preg_replace('~[^-a-zA-Z0-9_]+~', '-', $base);
$filename = strtolower($base) . '-' . time() . '.' . $ext;
$dest = $uploadDir . $filename;
if (!move_uploaded_file($tmp, $dest)) { http_response_code(500); echo json_encode(['error'=>'No se pudo guardar']); exit; }
function convert_to_webp($srcPath, $mime, $quality=82){
  if (!function_exists('imagewebp')) return null;
  switch ($mime) {
    case 'image/jpeg': $src = imagecreatefromjpeg($srcPath); break;
    case 'image/png': $src = imagecreatefrompng($srcPath); imagepalettetotruecolor($src); imagealphablending($src, true); imagesavealpha($src, true); break;
    case 'image/gif': $src = imagecreatefromgif($srcPath); break;
    case 'image/webp': return basename($srcPath);
    default: return null;
  }
  if (!$src) return null;
  $webpPath = preg_replace('/\.[a-zA-Z0-9]+$/', '.webp', $srcPath);
  if (imagewebp($src, $webpPath, $quality)) { imagedestroy($src); return basename($webpPath); }
  imagedestroy($src); return null;
}
$finalFile = basename($dest);
if ($mime != 'image/webp') {
  $webp = convert_to_webp($dest, $mime);
  if ($webp) $finalFile = $webp;
}
$url = $publicBase . $finalFile;
echo json_encode(['location'=>$url]);
