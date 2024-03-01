<?php
require_once __DIR__ . '/../../../../utils/http-status-codes.php';
require_once __DIR__ . '/../../../../utils/RolAccess.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'DELETE' || !$_SESSION || $_SESSION['rol'] != RolAccess::CUSTOMER) {
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once __DIR__ . '/../../../../../db/crud.php';
require_once __DIR__ . '/../../../../../db/models/Carrito_Item.php';

$statusCode = deleteRow(Carrito_Item::class, [
    Carrito_Item::PRODUCTO_ID => $_GET[Carrito_Item::PRODUCTO_ID],
    Carrito_Item::CLIENTE_ID => $_SESSION['id']
]);
return $statusCode;