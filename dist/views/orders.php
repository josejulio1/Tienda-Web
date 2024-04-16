<?php
session_start();
require_once __DIR__ . '/../api/utils/RolAccess.php';
if (!$_SESSION || $_SESSION['rol'] != RolAccess::CUSTOMER) {
    header('Location: /');
}
require_once __DIR__ . '/../db/crud.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mi Perfil">
    <title>Mi Perfil</title>
    <link rel="stylesheet" href="/assets/css/globals.css">
    <link rel="stylesheet" href="/assets/css/market/market.css">
    <link rel="stylesheet" href="/assets/css/market/orders.css">
    <link rel="stylesheet" href="/assets/css/utils.css">
    <link rel="stylesheet" href="/assets/css/dark-mode.css">
    <script src="/assets/js/lib/jquery-3.7.1.min.js" defer></script>
    <script src="/assets/js/market/account-options.js" type="module" defer></script>
    <script src="/assets/js/market/search-bar.js" type="module" defer></script>
    <script src="/assets/js/market/cart.js" type="module" defer></script>
    <script src="/assets/js/dark-mode.js" defer></script>
</head>
<body>
    <header>
        <?php
        require_once __DIR__ . '/../templates/market/nav.php';
        ?>
    </header>
    <main class="pedidos-container">
        <?php
        require_once __DIR__ . '/../db/models/v_pedido_producto_item_detallado.php';
        require_once __DIR__ . '/../db/utils/utils.php';
        $pedidosCliente = select(v_pedido_producto_item_detallado::class, [
            v_pedido_producto_item_detallado::PEDIDO_ID,
            v_pedido_producto_item_detallado::CLIENTE_ID,
            v_pedido_producto_item_detallado::PRODUCTO_ID,
            v_pedido_producto_item_detallado::NOMBRE_PRODUCTO,
            v_pedido_producto_item_detallado::CANTIDAD_PRODUCTO,
            v_pedido_producto_item_detallado::PRECIO_PRODUCTO,
            v_pedido_producto_item_detallado::RUTA_IMAGEN
        ], [
                TypesFilters::EQUALS => [
                        v_pedido_producto_item_detallado::CLIENTE_ID => $_SESSION['id']
                ]
        ], [
                TypeOrders::ASC => v_pedido_producto_item_detallado::PEDIDO_ID
        ]);
        ?>
        <?php
        $numPedido = 0;
        $numPedidos = count($pedidosCliente);

        if ($numPedidos == 0) { ?>
            <h2 class="no-pedidos">No se han encontrado pedidos</h2>
            <?php
        } else {
            foreach ($pedidosCliente as $pedidoCliente) {
                // Si ya se ha terminado de listar los productos de un pedido, continuar con el siguiente ID de pedido
                if ($numPedido != $pedidoCliente[v_pedido_producto_item_detallado::PEDIDO_ID]) { ?>
                </fieldset>
                <fieldset class="pedido-container">
                <legend>Pedido Nº<?php echo $pedidoCliente[v_pedido_producto_item_detallado::PEDIDO_ID]; ?></legend>
                <?php
                }
                ?>
                <article class="pedido">
                    <img src="<?php echo $pedidoCliente[v_pedido_producto_item_detallado::RUTA_IMAGEN]; ?>" alt="Imagen del producto">
                    <div class="pedido__detalles">
                        <a href="/views/producto.php?id=<?php echo $pedidoCliente[v_pedido_producto_item_detallado::PRODUCTO_ID]; ?>" class="nombre__producto"><?php echo $pedidoCliente[v_pedido_producto_item_detallado::NOMBRE_PRODUCTO]; ?></a>
                        <h3 class="precio__producto"><?php echo $pedidoCliente[v_pedido_producto_item_detallado::PRECIO_PRODUCTO]; ?> €</h3>
                        <h3 class="cantidad__producto">Cantidad: <?php echo $pedidoCliente[v_pedido_producto_item_detallado::CANTIDAD_PRODUCTO]; ?></h3>
                        <h3 class="precio__total__producto">Total: <?php echo number_format($pedidoCliente[v_pedido_producto_item_detallado::PRECIO_PRODUCTO] * $pedidoCliente[v_pedido_producto_item_detallado::CANTIDAD_PRODUCTO], 2); ?> €</h3>
                    </div>
                </article>
                <?php
                $numPedido = $pedidoCliente[v_pedido_producto_item_detallado::PEDIDO_ID];
            }
        }
        ?>
    </main>
    <?php
    require_once __DIR__ . '/../templates/dark-mode.php';
    ?>
</body>
</html>