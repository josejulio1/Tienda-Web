<?php
require_once __DIR__ . '/../../../utils/http-status-codes.php';
require_once __DIR__ . '/../../../utils/Rol.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !$_SESSION || $_SESSION['rol'] != Rol::USER) {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once '../../../../db/crud.php';
require_once '../../../../db/models/Usuario.php';
$email = $_POST[Usuario::CORREO];
$_POST[Usuario::CONTRASENIA] = password_hash($_POST[Usuario::CONTRASENIA], PASSWORD_DEFAULT); 
$path = '';
$fileNameFormatted = '';
if ($_FILES) {
    $fileName = $_FILES[Usuario::RUTA_IMAGEN_PERFIL]['name'];
    $fileNameFormatted = uniqid() . substr($fileName, strrpos($fileName, '.'));
    $path = '/assets/img/internal/users/' . $email . '/';
    $_POST[Usuario::RUTA_IMAGEN_PERFIL] = $path . $fileNameFormatted;
} else {
    $_POST[Usuario::RUTA_IMAGEN_PERFIL] = '/assets/img/internal/default/default-avatar.jpg';
}
$statusCode = insert(Usuario::class, $_POST);
if ($statusCode == OK && $_FILES) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . $path);
    move_uploaded_file($_FILES[Usuario::RUTA_IMAGEN_PERFIL]['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $path . $fileNameFormatted);
}
$userId = select(Usuario::class, [Usuario::ID], [
    Usuario::CORREO => $email
])[0][Usuario::ID];
echo json_encode([
    'status' => $statusCode,
    'usuario_id' => $userId,
    'ruta_imagen_perfil' => $_POST[Usuario::RUTA_IMAGEN_PERFIL]
]);
?>