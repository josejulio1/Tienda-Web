<?php
session_start();
require_once __DIR__ . '/../api/utils/RolAccess.php';
if (!$_SESSION || $_SESSION['rol'] == RolAccess::USER) {
    header('Location: /');
}
require_once __DIR__ . '/../db/crud.php';
require_once __DIR__ . '/../db/models/Carrito_Item.php';
// Si no tiene productos en el carrito, volver a la página principal
$hasCartItems = count(select(Carrito_Item::class, [Carrito_Item::PRODUCTO_ID], [
        TypesFilters::EQUALS => [
                Carrito_Item::CLIENTE_ID => $_SESSION['id']
        ]
    ])) > 0;
if (!$hasCartItems) {
    header('Location: /');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tienda principal">
    <title>Realizar pedido</title>
    <link rel="stylesheet" href="/assets/css/globals.css">
    <link rel="stylesheet" href="/assets/css/market/market.css">
    <link rel="stylesheet" href="/assets/css/utils.css">
    <script src="/assets/js/lib/jquery-3.7.1.min.js" defer></script>
</head>
<body>

</body>
</html>