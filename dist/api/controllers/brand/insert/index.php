<?php
require_once __DIR__ . '/../../../utils/http-status-codes.php';
require_once __DIR__ . '/../../../utils/RolAccess.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !$_SESSION || $_SESSION['rol'] != RolAccess::USER) {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once '../../../../db/crud.php';
require_once '../../../../db/models/Marca.php';
$statusCode = insert(Marca::class, $_POST);
$categoryId = select(Marca::class, [Marca::ID], [
    Marca::MARCA => $_POST[Marca::MARCA]
])[0][Marca::ID];
echo json_encode([
    'status' => $statusCode,
    Marca::ID => $categoryId
]);