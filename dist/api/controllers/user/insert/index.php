<?php
require_once __DIR__ . '/../../../utils/http-status-codes.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once '../../../../db/crud.php';
require_once '../../../../db/models/usuario.php';
$reflect = new ReflectionClass(usuario::class);
$userKeys = array_values($reflect -> getConstants());
$userKeys = array_slice($userKeys, 1, count($userKeys) - 2); // Eliminar el campo ID y la imagen de ruta de perfil, ya que se añade después si existe
$postValues = array_values($_POST);
$data = [];
$numFields = count($userKeys);
for ($i = 0; $i < $numFields; $i++) {
    $data[$userKeys[$i]] = $postValues[$i];
}
$email = $data[usuario::CORREO];
$data[usuario::CONTRASENIA] = password_hash($data[usuario::CONTRASENIA], PASSWORD_DEFAULT); 
$path = '';
$fileNameFormatted = '';
if ($_FILES) {
    $fileName = $_FILES['imagen-usuario-crear']['name'];
    $fileNameFormatted = uniqid() . substr($fileName, strrpos($fileName, '.'));
    $path = '/assets/img/users/customers/' . $email . '/';
    $data[usuario::RUTA_IMAGEN_PERFIL] = $path . $fileNameFormatted;
} else {
    $data[usuario::RUTA_IMAGEN_PERFIL] = '/assets/img/users/default/default-avatar.jpg';
}
$statusCode = insert('usuario', $data);
if ($statusCode == OK && $_FILES) {
    mkdir($_SERVER['DOCUMENT_ROOT'] . $path);
    move_uploaded_file($_FILES['imagen-usuario-crear']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $path . $fileNameFormatted);
}
$userId = select(usuario::class, [usuario::ID], [
    usuario::CORREO => $email
])[0]['id'];
echo json_encode([
    'status' => $statusCode,
    'usuario_id' => $userId,
    'ruta_imagen_perfil' => $data[usuario::RUTA_IMAGEN_PERFIL]
]);
?>