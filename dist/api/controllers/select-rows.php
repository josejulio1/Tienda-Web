<?php
require_once __DIR__ . '/../utils/http-status-codes.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once __DIR__ . '/../../db/crud.php';
require_once __DIR__ . '/../../db/utils/utils.php';
require_once __DIR__ . '/../../db/models/v_usuario_rol.php';
require_once __DIR__ . '/../utils/permissions.php';
session_start();

$tableName = $_POST['table-name'];
$permisoBuscado = '';
if ($tableName == v_usuario_rol::class) {
    $permisoBuscado = v_usuario_rol::PERMISO_USUARIO;
}
$permiso = select($tableName, [$permisoBuscado], [
    TypesFilters::EQUALS => [
        'correo' => $_SESSION['correo']
    ]
])[0][v_usuario_rol::PERMISO_USUARIO];
echo json_encode([
    'data' => select($tableName),
    'has-update-permission' => $permiso & PERMISSIONS::UPDATE,
    'has-delete-permission' => $permiso & PERMISSIONS::DELETE
]);
?>