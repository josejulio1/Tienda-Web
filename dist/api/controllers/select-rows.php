<?php
require_once __DIR__ . '/../utils/http-status-codes.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once __DIR__ . '/../../db/crud.php';
session_start();
$json = json_decode(file_get_contents('php://input'), true);
$tableName = $json['table-name'];
$fields = $json['fields'];
$filters = $json['filters'];
$selectPermissions = $json['select-permissions'];
$permiso = '';
// Si se quieren consultar los permisos de actualización y eliminación
if ($selectPermissions == 'true') {
    require_once __DIR__ . '/../../db/utils/utils.php';
    require_once __DIR__ . '/../../db/models/v_usuario_rol.php';
    require_once __DIR__ . '/../../db/models/v_producto_categoria.php';
    require_once __DIR__ . '/../../db/models/categoria.php';
    require_once __DIR__ . '/../../db/models/rol.php';
    require_once __DIR__ . '/../../db/models/cliente.php';
    $permisoBuscado = '';
    if ($tableName == v_usuario_rol::class) {
        $permisoBuscado = v_usuario_rol::PERMISO_USUARIO;
    } else if ($tableName == v_producto_categoria::class) {
        $permisoBuscado = v_usuario_rol::PERMISO_PRODUCTO;
    } else if ($tableName == categoria::class) {
        $permisoBuscado = v_usuario_rol::PERMISO_CATEGORIA;
    } else if ($tableName == rol::class) {
        $permisoBuscado = v_usuario_rol::PERMISO_ROL;
    } else if ($tableName == cliente::class) {
        $permisoBuscado = v_usuario_rol::PERMISO_CLIENTE;
    }
    
    $permiso = intval(select(v_usuario_rol::class, [$permisoBuscado], [
        TypesFilters::EQUALS => [
            'correo' => $_SESSION['correo']
        ]
    ])[0][$permisoBuscado]);
}

if ($selectPermissions == 'true') {
    require_once __DIR__ . '/../utils/permissions.php';
    echo json_encode([
        'data' => select($tableName, $fields, $filters),
        'has-update-permission' => $permiso & PERMISSIONS::UPDATE,
        'has-delete-permission' => $permiso & PERMISSIONS::DELETE
    ]);
} else {
    echo json_encode(select($tableName, $fields, $filters));
}
?>