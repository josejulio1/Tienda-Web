<?php
require_once __DIR__ . '/../../../utils/http-status-codes.php';
require_once __DIR__ . '/../../../utils/Rol.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !$_SESSION || $_SESSION['rol'] != Rol::USER) {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once __DIR__ . '/../../../../db/crud.php';
require_once __DIR__ . '/../../../../db/models/Cliente.php';
require_once __DIR__ . '/../../../utils/utils.php';
$email = $_POST[Cliente::CORREO];
$_POST[Cliente::CONTRASENIA] = password_hash($_POST[Cliente::CONTRASENIA], PASSWORD_DEFAULT);
$path = '';
$fileNameFormatted = '';
if ($_FILES) {
    $fileName = $_FILES[Cliente::RUTA_IMAGEN_PERFIL]['name'];
    $fileNameFormatted = uniqid() . substr($fileName, strrpos($fileName, '.'));
    $path = '/assets/img/internal/customers/' . $email . '/';
    $_POST[Cliente::RUTA_IMAGEN_PERFIL] = $path . $fileNameFormatted;
} else {
    $_POST[Cliente::RUTA_IMAGEN_PERFIL] = USER_DEFAULT_IMAGE_PATH;
}
$statusCode = insert(Cliente::class, $_POST);
if ($statusCode == OK && $_FILES) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . $path);
    move_uploaded_file($_FILES[Cliente::RUTA_IMAGEN_PERFIL]['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $path . $fileNameFormatted);
}
$customerId = select(Cliente::class, [Cliente::ID], [
    Cliente::CORREO => $email
])[0][Cliente::ID];
echo json_encode([
    'status' => $statusCode,
    'cliente_id' => $customerId,
    'ruta_imagen_perfil' => $_POST[Cliente::RUTA_IMAGEN_PERFIL]
]);
?>