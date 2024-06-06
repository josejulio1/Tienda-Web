<nav>
    <a href="/">BYTEMARKET</a>
    <section class="search-bar">
        <input type="text" id="search-bar--input" placeholder="Buscar">
        <img src="/assets/img/web/svg/search.svg" alt="Buscar" id="search-bar--img">
        <article id="search-bar--items"></article>
    </section>
    <?php
    if ($isAuthenticated) {
        ?>
        <section class="cuenta">
            <img src="<?php echo $infoClienteNav -> ruta_imagen_perfil; ?>" alt="Foto de perfil" id="imagen-perfil-nav">
            <p><span id="nombre-cliente-nav"><?php echo $infoClienteNav -> nombre; ?></span> <span id="apellidos-cliente-nav"><?php echo $infoClienteNav -> apellidos; ?></span></p>
            <div class="cuenta-opciones">
                <ul>
                    <li class="cuenta-perfil">
                        <a href="/profile">
                            <img src="/assets/img/web/svg/user.svg" alt="Mi Perfil">
                            <p>Mi Perfil</p>
                        </a>
                    </li>
                    <li class="cuenta-pedidos">
                        <a href="/orders">
                            <img src="/assets/img/web/svg/market/account-options/order.svg" alt="Pedidos">
                            <p>Pedidos</p>
                        </a>
                    </li>
                    <li class="option-separator"></li>
                    <li id="cerrar-sesion">
                        <img src="/assets/img/web/svg/market/account-options/close-session.svg" alt="Cerrar Sesión">
                        <p>Cerrar Sesión</p>
                    </li>
                </ul>
            </div>
        </section>
        <section class="carrito">
            <span id="num-articulos-carrito"><?php echo $numCarritoItems; ?></span>
            <img src="/assets/img/web/svg/cart.svg" alt="Carrito" id="img-carrito">
            <p>Carrito</p>
            <div class="carrito__items--container">
                <section id="carrito__items">
                    <?php
/*                    if ($numCarritoItems > 0) {
                        $precioTotal = 0;
                        foreach ($carritoItems as $carritoItem) { */?><!--
                            <article class="carrito__item" item-id="<?php /*echo $carritoItem -> productoId; */?>">
                                <img src="<?php /*echo $carritoItem -> rutaImagenProducto; */?>" alt="Imagen Producto">
                                <div class="item__descripcion">
                                    <p class="item__nombre--producto"><?php /*echo $carritoItem -> nombreProducto; */?></p>
                                    <p><span class="precio__producto"><?php /*echo $carritoItem -> precioProducto; */?></span><span> €</span></p>
                                    <p><span>Unidades:</span> <span class="item__precio"><?php /*echo $carritoItem -> cantidad; */?></span></p>
                                </div>
                                <img id="eliminar-item" src="/assets/img/web/svg/delete.svg" alt="Eliminar">
                            </article>
                            <?php
/*                            $precioTotal += $carritoItem -> precioProducto * $carritoItem -> cantidad;
                        }
                        */?>
                        --><?php
/*                    }
                    */?>
                </section>
                <section class="<?php echo $numCarritoItems == 0 ? 'hide' : ''; ?>" id="detalles-carrito">
                    <div class="option-separator"></div>
                    <h2 class="precio-total">Precio total: <span id="precio-total__span"><?php echo $precioTotal ?? 0; ?> </span><span> €</span></h2>
                    <a class="btn-info" href="/checkout">Realizar pedido</a>
                </section>
                <h2 id="no-cart" class="<?php echo $numCarritoItems > 0 ? 'hide' : ''; ?>">Agregue artículos al carrito</h2>
            </div>
        </section>
        <?php
    } else { ?>
        <a href="/login" class="cuenta">
            <img src="/assets/img/web/svg/user.svg" alt="Acceder cuenta">
            <p>Acceder a una cuenta</p>
        </a>
        <?php
    }
    ?>
</nav>