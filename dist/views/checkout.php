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
    <link rel="stylesheet" href="/assets/css/market/checkout.css">
    <script src="/assets/js/lib/jquery-3.7.1.min.js" defer></script>
    <script src="/assets/js/market/cart.js" type="module" defer></script>
    <script src="/assets/js/market/checkout.js" defer type="module"></script>
    <script src="/assets/js/market/account-options.js" type="module" defer></script>
</head>
<body>
    <header>
        <?php
        require_once __DIR__ . '/../templates/market/nav.php';
        ?>
    </header>
    <main class="detalles-pago">
        <section class="detalles">
            <h2>Productos</h2>
            <div class="productos-container">
                <?php
                require_once __DIR__ . '/../db/models/v_carrito_cliente.php';
                $cartItems = select(v_carrito_cliente::class, [
                        v_carrito_cliente::NOMBRE_PRODUCTO,
                        v_carrito_cliente::PRECIO_PRODUCTO,
                        v_carrito_cliente::CANTIDAD,
                        v_carrito_cliente::RUTA_IMAGEN_PRODUCTO
                ], [
                        TypesFilters::EQUALS => [
                                v_carrito_cliente::CLIENTE_ID => $_SESSION['id']
                        ]
                ]);
                $total = 0;
                foreach ($cartItems as $cartItem) { ?>
                    <article class="producto-container">
                        <div class="producto">
                            <img src="<?php echo $cartItem[v_carrito_cliente::RUTA_IMAGEN_PRODUCTO]; ?>" alt="Imagen Producto">
                            <div class="producto__detalles">
                                <p class="producto__nombre"><?php echo $cartItem[v_carrito_cliente::NOMBRE_PRODUCTO]; ?></p>
                                <p class="producto__precio">Precio: <span><?php echo $cartItem[v_carrito_cliente::PRECIO_PRODUCTO]; ?></span> €</p>
                                <p class="producto__cantidad">Cantidad: <span><?php echo $cartItem[v_carrito_cliente::CANTIDAD]; ?></span></p>
                            </div>
                        </div>
                        <?php
                        $total += $cartItem[v_carrito_cliente::PRECIO_PRODUCTO] * $cartItem[v_carrito_cliente::CANTIDAD];
                        ?>
                        <p class="producto__total">Total: <span><?php echo $cartItem[v_carrito_cliente::PRECIO_PRODUCTO] * $cartItem[v_carrito_cliente::CANTIDAD]; ?></span> €</p>
                    </article>
                    <?php
                }
                ?>
                <h3 class="precio-pagar">Total a pagar: <span><?php echo $total; ?></span> €</h3>
            </div>
        </section>
        <section class="pagos">
            <h2>Pago con tarjeta</h2>
            <article class="columna container__num-tarjeta">
                <label for="num-tarjeta">Número de tarjeta</label>
                <input type="text" id="num-tarjeta" maxlength="16">
                <div class="invalid-feedback hide">Introduzca un número de tarjeta</div>
            </article>
            <article class="columna">
                <label for="fecha-caducidad">Fecha Caducidad</label>
                <div class="fila">
                    <div class="columna">
                        <input type="text" id="fecha-caducidad-mes" placeholder="02" maxlength="2">
                        <div class="invalid-feedback hide">Introduzca un número de mes (1-12)</div>
                    </div>
                    <p>/</p>
                    <div class="columna">
                        <input type="text" id="fecha-caducidad-anio" placeholder="30" maxlength="2">
                        <div class="invalid-feedback hide">Introduzca un número de año</div>
                    </div>
                </div>
            </article>
            <article class="columna">
                <label for="codigo-seguridad">CVV</label>
                <input type="text" id="codigo-seguridad" placeholder="1234" maxlength="4">
                <div class="invalid-feedback hide">Introduzca el código de seguridad de la tarjeta</div>
            </article>
        </section>
        <section class="facturacion">
            <h2>Facturación</h2>
            <div class="facturacion-container">
                <article class="columna">
                    <label for="direccion">Dirección</label>
                    <input type="text" id="direccion">
                    <div class="invalid-feedback hide">Introduzca la dirección donde se desea recibir los productos</div>
                </article>
            </div>
        </section>
    </main>
    <aside class="pago">
        <button id="pagar">Pagar</button>
    </aside>
</body>
</html>