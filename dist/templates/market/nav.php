<nav>
            <a href="/">BYTEMARKET</a>
            <section class="search-bar">
                <input type="text" id="search-bar--input" placeholder="Buscar">
                <img src="/assets/img/web/svg/search.svg" alt="Buscar" id="search-bar--img">
                <article id="search-bar--items"></article>
            </section>
            <?php
            session_start();
            require_once __DIR__ . '/../../api/utils/Rol.php';
            if ($_SESSION && $_SESSION['rol'] == Rol::CUSTOMER) {
                require_once __DIR__ . '/../../db/models/Cliente.php';
                $imagenPerfil = select(Cliente::class, [Cliente::RUTA_IMAGEN_PERFIL], [
                    TypesFilters::EQUALS => [
                        Cliente::ID => $_SESSION['id']
                    ]
                ])[0][Cliente::RUTA_IMAGEN_PERFIL];
                ?>
                <a href="#" class="cuenta">
                    <img src="<?php echo $imagenPerfil; ?>" alt="Foto de perfil">
                    <p><?php echo $_SESSION['correo']; ?></p>
                    <div class="cuenta-opciones">
                        <ul>
                            <div class="option-separator"></div>
                            <li id="cerrar-sesion">
                                <img src="/assets/img/web/svg/market/account-options/close-session.svg" alt="Cerrar Sesión">
                                <p>Cerrar Sesión</p>
                            </li>
                        </ul>
                    </div>
                </a>
                <section class="carrito">
                    <?php
                    require_once __DIR__ . '/../../db/models/v_carrito_cliente.php';
                    $carritoItems = select(v_carrito_cliente::class, [
                        v_carrito_cliente::PRODUCTO_ID,
                        v_carrito_cliente::NOMBRE_PRODUCTO,
                        v_carrito_cliente::PRECIO_PRODUCTO,
                        v_carrito_cliente::RUTA_IMAGEN_PRODUCTO,
                        v_carrito_cliente::CANTIDAD
                    ], [
                        TypesFilters::EQUALS => [
                            v_carrito_cliente::CLIENTE_ID => $_SESSION['id']
                        ]
                    ]);
                    $numItems = count($carritoItems);
                    ?>
                    <span id="num-articulos-carrito"><?php echo $numItems; ?></span>
                    <img src="/assets/img/web/svg/cart.svg" alt="Carrito">
                    <p>Carrito</p>
                    <div class="carrito__items--container">
                        <section class="carrito__items">
                            <?php
                            if ($numItems > 0) {
                                $precioTotal = 0;
                                foreach ($carritoItems as $carritoItem) { ?>
                                    <article class="carrito__item" item-id="<?php echo $carritoItem[v_carrito_cliente::PRODUCTO_ID]; ?>">
                                        <img src="<?php echo $carritoItem[v_carrito_cliente::RUTA_IMAGEN_PRODUCTO]; ?>" alt="Imagen Producto">
                                        <div class="item__descripcion">
                                            <p class="item__nombre-producto"><?php echo $carritoItem[v_carrito_cliente::NOMBRE_PRODUCTO]; ?></p>
                                            <p><span class="precio__producto"><?php echo $carritoItem[v_carrito_cliente::PRECIO_PRODUCTO]; ?></span> €</p>
                                            <p>Unidades: <span class="item__precio"><?php echo $carritoItem[v_carrito_cliente::CANTIDAD]; ?></span></p>
                                        </div>
                                        <img id="eliminar-item" src="/assets/img/web/svg/delete.svg" alt="Eliminar">
                                    </article>
                                    <?php
                                    $precioTotal += $carritoItem[v_carrito_cliente::PRECIO_PRODUCTO] * $carritoItem[v_carrito_cliente::CANTIDAD];
                                } 
                                ?>
                            </section>
                            <div class="option-separator"></div>
                            <h2 class="precio-total">Precio total: <span class="precio-total__span"><?php echo $precioTotal; ?> </span> €</h2>
                            <button class="btn-info">Realizar pedido</button>
                            <?php
                            } else { ?>
                                <h2 class="no-cart">Agregue artículos al carrito</h2>
                                <?php
                            }
                            ?>
                    </div>
                </div>
                <?php
            } else { ?>
                <a href="/views/login.php" class="cuenta">
                    <img src="/assets/img/web/svg/user.svg" alt="Acceder cuenta">
                    <p>Acceder a una cuenta</p>
                </a>
                <?php
            }
            ?>
        </nav>