<header>
    <?php
    require_once __DIR__ . '/../templates/nav.php';
    ?>
</header>
<main class="pedidos-container">
    <?php
    $numPedido = 0;
    $numPedidos = count($pedidosCliente);
    if ($numPedidos === 0) { ?>
        <h2 class="no-pedidos">No se han encontrado pedidos</h2>
        <?php
    } else {
        foreach ($pedidosCliente as $pedidoCliente) {
            // Si ya se ha terminado de listar los productos de un pedido, continuar con el siguiente ID de pedido
            if ($numPedido !== $pedidoCliente -> pedido_id) { ?>
                </fieldset>
                <fieldset class="pedido-container">
                <legend>Pedido Nº<?php echo $pedidoCliente -> pedido_id; ?></legend>
                <?php
            }
            ?>
            <article class="pedido">
                <img src="<?php echo $pedidoCliente -> ruta_imagen; ?>" alt="Imagen del producto">
                <div class="pedido__detalles">
                    <a href="/product?id=<?php echo $pedidoCliente -> producto_id; ?>" class="nombre__producto"><?php echo $pedidoCliente -> nombre_producto; ?></a>
                    <h3 class="precio__producto"><?php echo $pedidoCliente -> precio_producto; ?> €</h3>
                    <h3 class="cantidad__producto">Cantidad: <?php echo $pedidoCliente -> cantidad_producto; ?></h3>
                    <h3 class="precio__total__producto">Total: <?php echo number_format($pedidoCliente -> precio_producto * $pedidoCliente -> cantidad_producto, 2); ?> €</h3>
                </div>
            </article>
            <?php
            $numPedido = $pedidoCliente -> pedido_id;
        }
    }
    ?>
</main>
<?php
require_once __DIR__ . '/../templates/chat.php';