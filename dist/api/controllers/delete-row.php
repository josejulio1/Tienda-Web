<?php
require_once __DIR__ . '/../utils/http-status-codes.php';
if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once __DIR__ . '/../../api/utils/utils.php';
require_once __DIR__ . '/../../db/crud.php';
require_once __DIR__ . '/../../db/utils/utils.php';
require_once __DIR__ . '/../../db/models/Usuario.php';
require_once __DIR__ . '/../../db/models/Producto.php';
require_once __DIR__ . '/../../db/models/Rol.php';
require_once __DIR__ . '/../../db/models/Cliente.php';
$tableName = $_GET['table-name'];
// Coger ruta de la imagen antes de borrar los datos, por si se va a borrar un usuario,
// si se borra correctamente, borrar su foto de perfil del servidor
$imgPath = USER_DEFAULT_IMAGE_PATH;
$id = $_GET['id'];
session_start();
// Evitar que un usuario se pueda eliminar así mismo o el asociado que tiene el usuario logueado
if ($tableName == Usuario::class && $_SESSION['id'] == $id) {
    return http_response_code(UNAUTHORIZED);
} else if ($tableName == RolAccess::class) {
    require_once __DIR__ . '/../../db/models/v_usuario_rol.php';
    $rolId = select(v_usuario_rol::class, [v_usuario_rol::ID_ROL], [
        TypesFilters::EQUALS => [
            v_usuario_rol::USUARIO_ID => $_SESSION['id']
        ]
    ])[0][v_usuario_rol::ID_ROL];
    if ($rolId == $id) {
        return http_response_code(UNAUTHORIZED);
    }
}

if ($tableName == Usuario::class) {
    $imgPath = select(Usuario::class, [Usuario::RUTA_IMAGEN_PERFIL], [
        TypesFilters::EQUALS => [
            Usuario::ID => $id
        ]
    ])[0][Usuario::RUTA_IMAGEN_PERFIL];
} else if ($tableName == Producto::class) {
    $imgPath = select(Producto::class, [Producto::RUTA_IMAGEN], [
        TypesFilters::EQUALS => [
            Producto::ID => $id
        ]
    ])[0][Producto::RUTA_IMAGEN];
} else if ($tableName == Cliente::class) {
    $imgPath = select(Cliente::class, [Cliente::RUTA_IMAGEN_PERFIL], [
        TypesFilters::EQUALS => [
            Cliente::ID => $id
        ]
    ])[0][Cliente::RUTA_IMAGEN_PERFIL];
}
$statusCode = deleteRow($_GET['table-name'], [
    'id' => $id
]);
// Si se ha borrado un campo de la tabla usuario, borrar la imagen asociada al usuario
if ($statusCode == OK && $imgPath != USER_DEFAULT_IMAGE_PATH) {
    // Eliminar fichero de dentro para poder eliminar la carpeta
    unlink($_SERVER['DOCUMENT_ROOT'] . $imgPath);
    $arrayPath = explode('/', $imgPath);
    // Coger ruta de la carpeta del usuario
    $userImgFolderPath = join('/', array_slice($arrayPath, 0, count($arrayPath) - 1));
    rmdir($_SERVER['DOCUMENT_ROOT'] . $userImgFolderPath);
}
return $statusCode;