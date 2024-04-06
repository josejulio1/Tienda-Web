<?php
require_once __DIR__ . '/../../../utils/http-status-codes.php';
require_once __DIR__ . '/../../../utils/RolAccess.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !$_SESSION || $_SESSION['rol'] != RolAccess::USER) {
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once __DIR__ . '/../../../../db/crud.php';
require_once __DIR__ . '/../../../../db/models/Producto.php';
$nombre = $_POST[Producto::NOMBRE];
$fileName = $_FILES[Producto::RUTA_IMAGEN]['name'];
$fileNameFormatted = uniqid() . substr($fileName, strrpos($fileName, '.'));
$path = '/assets/img/internal/products/' . $nombre . '/';
$_POST[Producto::RUTA_IMAGEN] = $path . $fileNameFormatted;

$statusCode = insert(Producto::class, $_POST);
if ($statusCode != OK) {
    echo json_encode(['status' => $statusCode]);
    return;
}
// Crear carpeta con el nombre del producto
mkdir($_SERVER['DOCUMENT_ROOT'] . $path);
// Guardar imagen del producto en la carpeta
move_uploaded_file($_FILES[Producto::RUTA_IMAGEN]['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $path . $fileNameFormatted);
$productId = select(Producto::class, [Producto::ID], [
    Producto::NOMBRE => $nombre
])[0][Producto::ID];
echo json_encode([
    'status' => $statusCode,
    Producto::ID => $productId,
    Producto::RUTA_IMAGEN => $_POST[Producto::RUTA_IMAGEN]
]);