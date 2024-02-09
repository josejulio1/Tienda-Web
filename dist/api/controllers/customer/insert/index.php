<?php
require_once __DIR__ . '/../../../utils/http-status-codes.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !$_SESSION) {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once __DIR__ . '/../../../../db/crud.php';
require_once __DIR__ . '/../../../../db/models/cliente.php';
require_once __DIR__ . '/../../../utils/utils.php';
$email = $_POST[cliente::CORREO];
$_POST[cliente::CONTRASENIA] = password_hash($_POST[cliente::CONTRASENIA], PASSWORD_DEFAULT);
$path = '';
$fileNameFormatted = '';
if ($_FILES) {
    $fileName = $_FILES[cliente::RUTA_IMAGEN_PERFIL]['name'];
    $fileNameFormatted = uniqid() . substr($fileName, strrpos($fileName, '.'));
    $path = '/assets/img/internal/customers/' . $email . '/';
    $_POST[cliente::RUTA_IMAGEN_PERFIL] = $path . $fileNameFormatted;
} else {
    $_POST[cliente::RUTA_IMAGEN_PERFIL] = USER_DEFAULT_IMAGE_PATH;
}
$statusCode = insert(cliente::class, $_POST);
if ($statusCode == OK && $_FILES) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . $path);
    move_uploaded_file($_FILES[cliente::RUTA_IMAGEN_PERFIL]['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $path . $fileNameFormatted);
}
$customerId = select(cliente::class, [cliente::ID], [
    cliente::CORREO => $email
])[0][cliente::ID];
echo json_encode([
    'status' => $statusCode,
    'cliente_id' => $customerId,
    'ruta_imagen_perfil' => $_POST[cliente::RUTA_IMAGEN_PERFIL]
]);
?>