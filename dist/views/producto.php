<?php
$id = $_GET['id'];
if (!filter_var($id, FILTER_VALIDATE_INT) || $id < 1) {
    header('Location: /');
}
require_once __DIR__ . '/../db/crud.php';
require_once __DIR__ . '/../db/utils/utils.php';
require_once __DIR__ . '/../db/models/v_producto_valoracion_promedio.php';
$producto = select(v_producto_valoracion_promedio::class, [
    v_producto_valoracion_promedio::NOMBRE,
    v_producto_valoracion_promedio::DESCRIPCION,
    v_producto_valoracion_promedio::RUTA_IMAGEN,
    v_producto_valoracion_promedio::PRECIO,
    v_producto_valoracion_promedio::MARCA,
    v_producto_valoracion_promedio::VALORACION_PROMEDIO
], [
    TypesFilters::EQUALS => [
        v_producto_valoracion_promedio::ID => $id
    ]
])[0];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $producto[v_producto_valoracion_promedio::NOMBRE]; ?></title>
    <link rel="stylesheet" href="/assets/css/globals.css">
    <link rel="stylesheet" href="/assets/css/utils.css">
    <link rel="stylesheet" href="/assets/css/market/market.css">
    <link rel="stylesheet" href="/assets/css/market/producto.css">
    <script src="/assets/js/lib/jquery-3.7.1.min.js" defer></script>
    <script src="/assets/js/market/search-bar.js" type="module" defer></script>
    <script src="/assets/js/market/account-options.js" type="module" defer></script>
    <script src="/assets/js/market/cart.js" type="module" defer></script>
    <script src="/assets/js/market/product.js" type="module" defer></script>
</head>
<body>
    <header>
        <?php
        require_once __DIR__ . '/../templates/market/nav.php';
        ?>
    </header>
    <main>
        <section class="producto">
            <img src="<?php echo $producto[v_producto_valoracion_promedio::RUTA_IMAGEN]; ?>" alt="Foto Producto" loading="lazy">
            <article class="producto__detalles">
                <h2><?php echo $producto[v_producto_valoracion_promedio::NOMBRE]; ?></h2>
                <p>Marca: <?php echo $producto[v_producto_valoracion_promedio::MARCA]; ?></p>
                <div class="producto__detalles__valoracion">
                <?php
                $numEstrellas = $producto[v_producto_valoracion_promedio::VALORACION_PROMEDIO];
                for ($i = 1; $i <= 5; $i++) {
                    if ($numEstrellas-- > 0) {
                        echo '<img src="/assets/img/web/svg/star-filled.svg" alt="Estrella" loading="lazy">';
                    } else {
                        echo '<img src="/assets/img/web/svg/star-no-filled.svg" alt="Estrella" class="invert-color" loading="lazy">';
                    }
                }
                ?>
                </div>
            </article>
            <article class="compra">
                <h2><?php echo $producto[v_producto_valoracion_promedio::PRECIO]; ?> €</h2>
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
                    <p id="descripcion-producto"></p>
                </div>
                <div class="switcher-item comentarios__container hide" id="comentarios__container">
                    <h2 id="no-comentarios">No se encontraron comentarios</h2>
                    <div class="hide" id="comentarios">
                        <!-- <div class="comentario__item">
                            <div class="comentario__item--esencial">
                                <img src="/assets/img/internal/default/default-avatar.jpg" alt="Foto de perfil cliente">
                                <h3 class="comentario__item--cliente">Pedro</h3>
                            </div>
                            <div class="comentario__item--estrellas">
                                <img class="comentario__item--estrella" src="/assets/img/web/svg/star-filled.svg" alt="Estrella">
                                <img class="comentario__item--estrella" src="/assets/img/web/svg/star-filled.svg" alt="Estrella">
                                <img class="comentario__item--estrella" src="/assets/img/web/svg/star-filled.svg" alt="Estrella">
                                <img class="comentario__item--estrella" src="/assets/img/web/svg/star-filled.svg" alt="Estrella">
                                <img class="comentario__item--estrella" src="/assets/img/web/svg/star-filled.svg" alt="Estrella">
                            </div>
                            <p class="comentario__item--comentario">Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur veniam quidem fugiat, modi eveniet laboriosam alias sit atque. Ad alias totam cum dolorum maiores molestias, minima facilis odit laudantium placeat inventore et voluptate modi quis amet accusamus necessitatibus? Tempora veritatis illum aperiam quas dolores, voluptatem consequatur voluptas totam neque? Impedit debitis quidem dolor! Tempora temporibus, itaque hic nulla ratione corrupti ad. Laboriosam harum dignissimos molestiae quibusdam in fugit error expedita iste esse suscipit, dicta modi sed temporibus nisi quis sit aut eius quo maxime consequatur aliquam doloribus! Quos dolorum, a beatae illo odio quae. Architecto illum deserunt ipsum error. Beatae.</p>
                        </div>
                        <div class="comentario__item">
                            <div class="comentario__item--esencial">
                                <img src="/assets/img/internal/default/default-avatar.jpg" alt="Foto de perfil cliente">
                                <h3 class="comentario__item--cliente">Pedro</h3>
                            </div>
                            <div class="comentario__item--estrellas">
                                <img class="comentario__item--estrella" src="/assets/img/web/svg/star-filled.svg" alt="Estrella">
                                <img class="comentario__item--estrella" src="/assets/img/web/svg/star-filled.svg" alt="Estrella">
                                <img class="comentario__item--estrella" src="/assets/img/web/svg/star-filled.svg" alt="Estrella">
                                <img class="comentario__item--estrella" src="/assets/img/web/svg/star-filled.svg" alt="Estrella">
                                <img class="comentario__item--estrella" src="/assets/img/web/svg/star-filled.svg" alt="Estrella">
                            </div>
                            <p class="comentario__item--comentario">Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur veniam quidem fugiat, modi eveniet laboriosam alias sit atque. Ad alias totam cum dolorum maiores molestias, minima facilis odit laudantium placeat inventore et voluptate modi quis amet accusamus necessitatibus? Tempora veritatis illum aperiam quas dolores, voluptatem consequatur voluptas totam neque? Impedit debitis quidem dolor! Tempora temporibus, itaque hic nulla ratione corrupti ad. Laboriosam harum dignissimos molestiae quibusdam in fugit error expedita iste esse suscipit, dicta modi sed temporibus nisi quis sit aut eius quo maxime consequatur aliquam doloribus! Quos dolorum, a beatae illo odio quae. Architecto illum deserunt ipsum error. Beatae.</p>
                        </div> -->
                    </div>
                </div>
            </article>
        </section>
    </main>
</body>
</html>