<?php
require_once __DIR__ . '/../../../utils/http-status-codes.php';
require_once __DIR__ . '/../../../utils/Rol.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !$_SESSION || $_SESSION['rol'] != Rol::USER) {
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once '../../../../db/crud.php';
require_once '../../../../db/models/Producto.php';
$nombre = $_POST[Producto::NOMBRE];
$fileName = $_FILES[Producto::RUTA_IMAGEN]['name'];
$fileNameFormatted = uniqid() . substr($fileName, strrpos($fileName, '.'));
$path = '/assets/img/internal/products/' . $nombre . '/';
$_POST[Producto::RUTA_IMAGEN] = $path . $fileNameFormatted;

$statusCode = insert(Producto::class, $_POST);
if ($statusCode != OK) {
    return http_response_code($statusCode);
}
mkdir($_SERVER['DOCUMENT_ROOT'] . $path);
move_uploaded_file($_FILES[Producto::RUTA_IMAGEN]['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $path . $fileNameFormatted);
$productId = select(Producto::class, [Producto::ID], [
    Producto::NOMBRE => $nombre
])[0][Producto::ID];
echo json_encode([
    'status' => $statusCode,
    'producto_id' => $productId,
    'ruta_imagen' => $_POST[Producto::RUTA_IMAGEN]
]);
?>