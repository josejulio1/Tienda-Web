<?php
require_once __DIR__ . '/../../../utils/http-status-codes.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once '../../../../db/crud.php';
require_once '../../../../db/models/usuario.php';

echo json_encode([
    'status' => $statusCode,
    'usuario_id' => $userId,
    'ruta_imagen_perfil' => $data[usuario::RUTA_IMAGEN_PERFIL]
]);
?>