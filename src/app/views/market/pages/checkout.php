<header>
    <?php
    require_once __DIR__ . '/../templates/nav.php';
    ?>
</header>
<main class="detalles-pago">
    <section class="detalles">
        <h2>Productos</h2>
        <div class="productos-container">
            <div class="productos">
                <?php
                $total = 0;
                foreach ($cartItems as $cartItem) { ?>
                    <article class="producto-container">
                        <div class="producto">
                            <img src="<?php echo $cartItem -> ruta_imagen_producto; ?>" alt="Imagen Producto">
                            <div class="producto__detalles">
                                <p class="producto__nombre"><?php echo $cartItem -> nombre_producto; ?></p>
                                <p class="producto__precio">Precio: <span><?php echo $cartItem -> precio_producto; ?></span> €</p>
                                <p class="producto__cantidad">Cantidad: <span><?php echo $cartItem -> cantidad; ?></span></p>
                            </div>
                        </div>
                        <?php
                        $total += $cartItem -> precio_producto * $cartItem -> cantidad;
                        ?>
                        <p class="producto__total">Total: <span><?php echo $cartItem -> precio_producto * $cartItem -> cantidad; ?></span> €</p>
                    </article>
                    <?php
                }
                ?>
            </div>
            <h3 class="precio-pagar">Total a pagar: <span><?php echo $total; ?></span> €</h3>
        </div>
    </section>
    <section class="pagos">
        <!--<article class="pagos__titles">
            <button class="pago__button seleccionado">Tarjeta</button>
            <button class="pago__button seleccionado">Tarjeta</button>
        </article>-->
        <article class="pagos__tarjeta">
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
        </article>
        <h2>Pago con tarjeta</h2>
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