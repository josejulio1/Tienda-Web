<?php
require_once __DIR__ . '/../../../utils/http-status-codes.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !$_SESSION) {
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once '../../../../db/crud.php';
require_once '../../../../db/models/producto.php';
$nombre = $_POST[producto::NOMBRE];
$fileName = $_FILES[producto::RUTA_IMAGEN]['name'];
$fileNameFormatted = uniqid() . substr($fileName, strrpos($fileName, '.'));
$path = '/assets/img/products/' . $nombre . '/';
$_POST[producto::RUTA_IMAGEN] = $path . $fileNameFormatted;

$statusCode = insert(producto::class, $_POST);
if ($statusCode != OK) {
    return http_response_code($statusCode);
}
mkdir($_SERVER['DOCUMENT_ROOT'] . $path);
move_uploaded_file($_FILES[producto::RUTA_IMAGEN]['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $path . $fileNameFormatted);
$productId = select(producto::class, [producto::ID], [
    producto::NOMBRE => $nombre
])[0][producto::ID];
echo json_encode([
    'status' => $statusCode,
    'producto_id' => $productId,
    'ruta_imagen' => $_POST[producto::RUTA_IMAGEN]
]);
?>