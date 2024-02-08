<?php
require_once __DIR__ . '/../../../utils/http-status-codes.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !$_SESSION) {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once '../../../../db/crud.php';
require_once '../../../../db/models/rol.php';
$statusCode = insert(rol::class, $_POST);
$rolId = select(rol::class, [rol::ID], [
    rol::NOMBRE => $_POST[rol::NOMBRE]
])[0][rol::ID];
echo json_encode([
    'status' => $statusCode,
    'rol_id' => $rolId
]);
?>