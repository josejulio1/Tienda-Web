<?php
require_once __DIR__ . '/../../../utils/http-status-codes.php';
require_once __DIR__ . '/../../../utils/Rol.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !$_SESSION || $_SESSION['rol'] != Rol::USER) {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once '../../../../db/crud.php';
require_once '../../../../db/models/Categoria.php';
$statusCode = insert(Categoria::class, $_POST);
$categoryId = select(Categoria::class, [Categoria::ID], [
    Categoria::NOMBRE => $_POST[Categoria::NOMBRE]
])[0][Categoria::ID];
echo json_encode([
    'status' => $statusCode,
    'categoria_id' => $categoryId
]);
?>