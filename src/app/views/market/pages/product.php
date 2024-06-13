<header>
    <?php
    require_once __DIR__ . '/../templates/nav.php';
    ?>
</header>
<main>
    <section class="producto">
        <img src="<?php echo $producto -> ruta_imagen; ?>" alt="Foto Producto" loading="lazy">
        <article class="producto__detalles">
            <h2><?php echo $producto -> nombre; ?></h2>
            <p>Marca: <?php echo $producto -> marca; ?></p>
            <div class="producto__detalles__valoracion"><?php $numEstrellas = $producto -> valoracion_promedio;
            for ($i = 1; $i <= 5; $i++) {
                if ($numEstrellas-- > 0) {
                    echo '<img src="/assets/img/web/market/comment/star-filled.svg" alt="Estrella" loading="lazy">';
                } else {
                    echo '<img src="/assets/img/web/market/comment/star-no-filled.svg" alt="Estrella" class="invert-color" loading="lazy">';
                }
            }
            ?>
            </div>
        </article>
        <article class="compra">
            <h2><?php echo $producto -> precio; ?> €</h2>
            <button class="btn-info" id="aniadir-carrito">Añadir al carrito</button>
        </article>
    </section>
    <section class="descripcion-comentarios--container">
        <article class="descripcion-comentarios--switcher">
            <button switcher-item-id="descripcion__container" class="switcher selected">Descripción</button>
            <button switcher-item-id="comentarios__container" class="switcher">Comentarios</button>
        </article>
        <article class="descripcion-comentarios">
            <div class="switcher-item" id="descripcion__container">
                <p id="descripcion-producto"><?php echo $producto -> descripcion; ?></p>
            </div>
            <div class="switcher-item comentarios__container hide" id="comentarios__container">
                <?php
                if ($puedeComentar) { ?>
                    <div class="aniadir-comentario__container">
                        <div class="comentario__item">
                            <div class="comentario__item--esencial">
                                <img src="<?php echo $cliente -> ruta_imagen_perfil; ?>" alt="Foto de perfil de cliente" loading="lazy">
                                <h3 class="comentario__item--cliente"><?php echo $cliente -> nombre . ' ' . $cliente -> apellidos; ?></h3>
                            </div>
                            <div class="comentario__item--estrellas">
                                <img class="comentario__item--estrella" src="/assets/img/web/market/comment/star-no-filled.svg" alt="Estrella" loading="lazy">
                                <img class="comentario__item--estrella" src="/assets/img/web/market/comment/star-no-filled.svg" alt="Estrella" loading="lazy">
                                <img class="comentario__item--estrella" src="/assets/img/web/market/comment/star-no-filled.svg" alt="Estrella" loading="lazy">
                                <img class="comentario__item--estrella" src="/assets/img/web/market/comment/star-no-filled.svg" alt="Estrella" loading="lazy">
                                <img class="comentario__item--estrella" src="/assets/img/web/market/comment/star-no-filled.svg" alt="Estrella" loading="lazy">
                            </div>
                            <textarea id="comentario" cols="30" rows="10"></textarea>
                            <button class="btn-info" id="comentar">Comenta</button>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ($puedeComentar) {
                    echo '<hr class="separador-comentario">';
                }
                ?>
                <div id="comentarios">
                    <?php
                    if ($comentarios) {
                        foreach ($comentarios as $comentario) { ?>
                            <div class="comentario__item">
                                <div class="comentario__item--esencial">
                                    <img src="<?php echo $comentario -> ruta_imagen_perfil; ?>" alt="Foto de perfil de cliente" loading="lazy">
                                    <h3 class="comentario__item--cliente"><?php echo $comentario -> nombre_cliente . ' ' . $comentario -> apellidos_cliente; ?></h3>
                                </div>
                                <div class="comentario__item--estrellas">
                                    <?php
                                    $numEstrellas = $comentario -> num_estrellas;
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($numEstrellas-- > 0) {
                                            echo '<img class="comentario__item--estrella" src="/assets/img/web/market/comment/star-filled.svg" alt="Estrella" loading="lazy">';
                                        } else {
                                            echo '<img class="comentario__item--estrella" src="/assets/img/web/market/comment/star-no-filled.svg" alt="Estrella" loading="lazy">';
                                        }
                                    }
                                    ?>
                                </div>
                                <p class="comentario__item--comentario"><?php echo $comentario -> comentario; ?></p>
                            </div>
                            <?php
                        }
                    } else { ?>
                        <h2 id="no-comentarios">No se encontraron comentarios</h2>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </article>
    </section>
</main>
<?php
require_once __DIR__ . '/../templates/chat.php';