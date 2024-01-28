<?php
require_once __DIR__ . '/../../../utils/http-status-codes.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once '../../../../db/crud.php';
require_once '../../../../db/models/categoria.php';
$statusCode = insert(categoria::class, $_POST);
$categoryId = select(categoria::class, [categoria::ID], [
    categoria::NOMBRE => $_POST[categoria::NOMBRE]
])[0][categoria::ID];
echo json_encode([
    'status' => $statusCode,
    'categoria_id' => $categoryId
]);
?>