<?php
require_once __DIR__ . '/../../../utils/http-status-codes.php';
require_once __DIR__ . '/../../../utils/Rol.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !$_SESSION || $_SESSION['rol'] != Rol::CUSTOMER) {
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once __DIR__ . '/../../../../../db/crud.php';
require_once __DIR__ . '/../../../../../db/models/Carrito_Item.php';

$statusCode = insert(Carrito_Item::class, [$_POST[Carrito_Item::PRODUCTO_ID], $_SESSION['id'], $_POST[Carrito_Item::CANTIDAD]]);
?>