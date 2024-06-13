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
        <h2>Tipo de Pago</h2>
        <article class="pagos__titles">
            <div class="pago__container pago__button pago__seleccionado" id="pagos__tarjeta" pago-id="1">
                <img src="/assets/img/web/market/payments/card.svg" id="pagos__paypal" alt="Pago con tarjeta">
            </div>
            <div class="pago__container pago__button" id="pagos__paypal" pago-id="2">
                <img src="/assets/img/web/market/payments/paypal.svg" alt="Pago con Bizum">
            </div>
        </article>
        <article class="tipo__pago pagos__tarjeta">
            <div class="columna container__num-tarjeta">
                <label for="num-tarjeta">Número de tarjeta</label>
                <input type="text" id="num-tarjeta" maxlength="16">
                <div class="invalid-feedback hide">Introduzca un número de tarjeta</div>
            </div>
            <div class="columna">
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
            </div>
            <div class="columna">
                <label for="codigo-seguridad">CVV</label>
                <input type="text" id="codigo-seguridad" placeholder="1234" maxlength="4">
                <div class="invalid-feedback hide">Introduzca el código de seguridad de la tarjeta</div>
            </div>
        </article>
        <article class="tipo__pago pagos__paypal hide">
            <div class="columna">
                <label for="correo">Correo</label>
                <input type="email" id="correo">
                <div class="invalid-feedback hide">Introduzca un correo electrónico</div>
            </div>
        </article>
    </section>
    <section class="facturacion">
        <h2>Facturación</h2>
        <div class="facturacion-container">
            <article class="columna">
                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" value="<?php echo $direccionCliente; ?>">
                <div class="invalid-feedback hide">Introduzca la dirección donde se desea recibir los productos</div>
            </article>
        </div>
    </section>
</main>
<aside class="pago">
    <button id="pagar">Pagar</button>
</aside>
<?php
require_once __DIR__ . '/../templates/chat.php';