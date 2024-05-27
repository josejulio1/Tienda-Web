<header>
    <?php
    require_once __DIR__ . '/../templates/nav.php';
    ?>
</header>
<main class="pedidos-container">
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