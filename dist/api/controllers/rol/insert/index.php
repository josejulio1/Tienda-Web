<?php
require_once __DIR__ . '/../../../utils/http-status-codes.php';
require_once __DIR__ . '/../../../utils/Rol.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !$_SESSION || $_SESSION['rol'] != Rol::USER) {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once '../../../../db/crud.php';
require_once '../../../../db/models/Rol.php';
$statusCode = insert(rol::class, $_POST);
$rolId = select(Rol::class, [Rol::ID], [
    Rol::NOMBRE => $_POST[Rol::NOMBRE]
])[0][Rol::ID];
echo json_encode([
    'status' => $statusCode,
    'rol_id' => $rolId
]);
?>