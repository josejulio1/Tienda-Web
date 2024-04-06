<?php
require_once __DIR__ . '/../../../../utils/http-status-codes.php';
require_once __DIR__ . '/../../../../utils/RolAccess.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !$_SESSION) {
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once __DIR__ . '/../../../../../db/crud.php';
require_once __DIR__ . '/../../../../../db/models/Chat.php';
require_once __DIR__ . '/../../../../../db/models/Usuario.php';
require_once __DIR__ . '/../../../../../db/models/Cliente.php';
require_once __DIR__ . '/../../../../../db/utils/utils.php';
$customerIds = [];
if ($_SESSION['rol'] == RolAccess::USER) {
    $customerIds = select(Chat::class, [Chat::CLIENTE_ID]);
}
$esCliente = $_SESSION['rol'] == RolAccess::CUSTOMER;
$statusCode = insert(Chat::class, [
    // Si el cliente con este ID nunca ha hecho un comentario, usar su ID de sesión, sino, coger de la BBDD
    Chat::CLIENTE_ID => count($customerIds) == 0 ? $_SESSION['id'] : $customerIds[0][Chat::CLIENTE_ID],
    Chat::MENSAJE => $_POST[Chat::MENSAJE],
    Chat::FECHA => date('Y-m-d H:i:s'),
    Chat::ES_CLIENTE => $esCliente
]);
if ($statusCode != OK) {
    echo json_encode(['status' => $statusCode]);
    return;
}
$profilePhoto = '';
if ($esCliente) {
    $profilePhoto = select(Cliente::class, [Cliente::RUTA_IMAGEN_PERFIL], [
        TypesFilters::EQUALS => [
            Cliente::ID => $_SESSION['id']
        ]
    ])[0][Cliente::RUTA_IMAGEN_PERFIL];
} else {
    $profilePhoto = select(Usuario::class, [Usuario::RUTA_IMAGEN_PERFIL], [
        TypesFilters::EQUALS => [
            Usuario::ID => $_SESSION['id']
        ]
    ])[0][Usuario::RUTA_IMAGEN_PERFIL];
}
echo json_encode([
    'status' => $statusCode,
    'ruta_imagen_perfil' => $profilePhoto,
    Chat::ES_CLIENTE => $esCliente
]);