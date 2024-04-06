<?php
require_once __DIR__ . '/../../../../utils/http-status-codes.php';
require_once __DIR__ . '/../../../../utils/RolAccess.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !$_SESSION || $_SESSION['rol'] != RolAccess::CUSTOMER) {
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once __DIR__ . '/../../../../../db/crud.php';
require_once __DIR__ . '/../../../../../db/models/Pedido.php';
$statusCode = insert(Pedido::class, [
    Pedido::CLIENTE_ID => $_SESSION['id'],
    Pedido::METODO_PAGO_ID => 1,
    Pedido::ESTADO_PAGO_ID => 1,
    Pedido::DIRECCION_ENVIO => $_POST[Pedido::DIRECCION_ENVIO]
]);
if ($statusCode == NOT_FOUND) {
    return http_response_code($statusCode);
}
require_once __DIR__ . '/../../../../../db/models/v_carrito_cliente.php';
require_once __DIR__ . '/../../../../../db/utils/utils.php';
// En caso de que se haya creado correctamente un pedido, copiar los productos del carrito a la tabla Pedido_Producto_Item
// para asociar los productos a dicho pedido
$carrito = select(v_carrito_cliente::class, [
    v_carrito_cliente::PRODUCTO_ID,
    v_carrito_cliente::CLIENTE_ID,
    v_carrito_cliente::PRECIO_PRODUCTO,
    v_carrito_cliente::CANTIDAD
], [
    TypesFilters::EQUALS => [
        v_carrito_cliente::CLIENTE_ID => $_SESSION['id']
    ]
]);
// Coger ID del pedido recién creado
$pedidoId = select(Pedido::class, [Pedido::ID], null, [
    TypeOrders::DESC => Pedido::ID
], 1)[0][Pedido::ID];

require_once __DIR__ . '/../../../../../db/models/Pedido_Producto_Item.php';
$statusCodeInsert = 0;
foreach ($carrito as $producto) {
    $statusCodeInsert = insert(Pedido_Producto_Item::class, [
        Pedido_Producto_Item::PEDIDO_ID => $pedidoId,
        Pedido_Producto_Item::PRODUCTO_ID => $producto[v_carrito_cliente::PRODUCTO_ID],
        Pedido_Producto_Item::CANTIDAD_PRODUCTO => $producto[v_carrito_cliente::CANTIDAD],
        Pedido_Producto_Item::PRECIO_PRODUCTO => $producto[v_carrito_cliente::PRECIO_PRODUCTO]
    ]);
    if ($statusCodeInsert != OK) {
        return http_response_code($statusCodeInsert);
    }
}

require_once __DIR__ . '/../../../../../db/models/Carrito_Item.php';
// Si se guardó el pedido correctamente, vaciar el carrito del cliente
return deleteRow(Carrito_Item::class, [
    Carrito_Item::CLIENTE_ID => $_SESSION['id']
]);