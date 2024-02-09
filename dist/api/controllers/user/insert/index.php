<?php
require_once __DIR__ . '/../../../utils/http-status-codes.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !$_SESSION) {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once '../../../../db/crud.php';
require_once '../../../../db/models/usuario.php';
$email = $_POST[usuario::CORREO];
$_POST[usuario::CONTRASENIA] = password_hash($_POST[usuario::CONTRASENIA], PASSWORD_DEFAULT); 
$path = '';
$fileNameFormatted = '';
if ($_FILES) {
    $fileName = $_FILES[usuario::RUTA_IMAGEN_PERFIL]['name'];
    $fileNameFormatted = uniqid() . substr($fileName, strrpos($fileName, '.'));
    $path = '/assets/img/internal/users/' . $email . '/';
    $_POST[usuario::RUTA_IMAGEN_PERFIL] = $path . $fileNameFormatted;
} else {
    $_POST[usuario::RUTA_IMAGEN_PERFIL] = '/assets/img/internal/default/default-avatar.jpg';
}
$statusCode = insert(usuario::class, $_POST);
if ($statusCode == OK && $_FILES) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . $path);
    move_uploaded_file($_FILES[usuario::RUTA_IMAGEN_PERFIL]['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $path . $fileNameFormatted);
}
$userId = select(usuario::class, [usuario::ID], [
    usuario::CORREO => $email
])[0][usuario::ID];
echo json_encode([
    'status' => $statusCode,
    'usuario_id' => $userId,
    'ruta_imagen_perfil' => $_POST[usuario::RUTA_IMAGEN_PERFIL]
]);
?>