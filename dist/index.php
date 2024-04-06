<?php
require_once __DIR__ . '/db/crud.php';
require_once __DIR__ . '/db/utils/utils.php';
require_once __DIR__ . '/api/utils/RolAccess.php';
function imprimirProductos(array $productos): void {
    foreach ($productos as $producto) { ?>
        <article item-id="<?php echo $producto[v_producto_valoracion_promedio::ID]; ?>" class="producto__item">
            <img src="<?php echo $producto[v_producto_valoracion_promedio::RUTA_IMAGEN]; ?>" alt="Imagen Producto" loading="lazy">
            <div class="producto__item__descripcion">
                <h2><?php echo $producto[v_producto_valoracion_promedio::NOMBRE]; ?></h2>
                <p class="precio"><?php echo $producto[v_producto_valoracion_promedio::PRECIO]; ?> €</p>
                <div class="producto__item__estrellas">
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
            </div>
        </article>
        <?php
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tienda principal">
    <title>BYTEMARKET - Inicio</title>
    <link rel="stylesheet" href="/assets/css/globals.css">
    <link rel="stylesheet" href="/assets/css/market/market.css">
    <link rel="stylesheet" href="/assets/css/chat.css">
    <link rel="stylesheet" href="/assets/css/utils.css">
    <script src="/assets/js/lib/jquery-3.7.1.min.js" defer></script>
    <script src="/assets/js/market/search-bar.js" type="module" defer></script>
    <script src="/assets/js/market/account-options.js" type="module" defer></script>
    <script src="/assets/js/market/market.js" defer></script>
    <script src="/assets/js/market/cart.js" type="module" defer></script>
    <script src="/assets/js/market/chat.js" type="module" defer></script>
</head>
<body>
    <header>
        <?php
        require_once __DIR__ . '/templates/market/nav.php';
        ?>
    </header>
    <main>
        <video class="hero" loop autoplay muted>
            <source src="/assets/video/hero.mp4" type="video/mp4">
        </video>
        <div class="main-container">
            <section class="productos">
                <h2 class="productos__titulo">Descubra nuestros productos</h2>
                <div id="productos__items">
                    <?php
                    require_once __DIR__ . '/db/models/v_producto_valoracion_promedio.php';
                    $productos = select(v_producto_valoracion_promedio::class, [
                        v_producto_valoracion_promedio::ID,
                        v_producto_valoracion_promedio::NOMBRE,
                        v_producto_valoracion_promedio::PRECIO,
                        v_producto_valoracion_promedio::RUTA_IMAGEN,
                        v_producto_valoracion_promedio::VALORACION_PROMEDIO
                    ], null, null, 10);
                    imprimirProductos($productos);
                    ?>
                </div>
            </section>
            <section class="productos">
                <h2 class="productos__titulo">Los más baratos</h2>
                <div id="productos__items">
                    <?php
                    $productos = select(v_producto_valoracion_promedio::class, [
                        v_producto_valoracion_promedio::ID,
                        v_producto_valoracion_promedio::NOMBRE,
                        v_producto_valoracion_promedio::PRECIO,
                        v_producto_valoracion_promedio::RUTA_IMAGEN,
                        v_producto_valoracion_promedio::VALORACION_PROMEDIO
                    ], null, [
                            TypeOrders::ASC => v_producto_valoracion_promedio::PRECIO
                    ], 10);
                    imprimirProductos($productos);
                    ?>
                </div>
            </section>
            <section class="productos">
                <h2 class="productos__titulo">Mejor valorados</h2>
                <div id="productos__items">
                    <?php
                    $productos = select(v_producto_valoracion_promedio::class, [
                        v_producto_valoracion_promedio::ID,
                        v_producto_valoracion_promedio::NOMBRE,
                        v_producto_valoracion_promedio::PRECIO,
                        v_producto_valoracion_promedio::RUTA_IMAGEN,
                        v_producto_valoracion_promedio::VALORACION_PROMEDIO
                    ], null, [
                            TypeOrders::DESC => v_producto_valoracion_promedio::VALORACION_PROMEDIO
                    ], 10);
                    imprimirProductos($productos);
                    ?>
                </div>
            </section>
        </div>
    </main>
    <footer>
        <p>Todos los derechos reservados</p>
    </footer>
    <?php
    if ($_SESSION && $_SESSION['rol'] == RolAccess::CUSTOMER) { ?>
        <aside class="chat-container">
            <section class="chat">
                <h2>Chat BYTEMARKET</h2>
                <section class="chat__detalles">
                    <article id="chat__mensajes">
                        <div class="mensaje mensaje-usuario">
                            <img src="/assets/img/internal/default/default-avatar.jpg" alt="Imagen">
                            <p>¡Buenas! ¿En qué podemos ayudarte?</p>
                        </div>
                    </article>
                    <article class="enviar-mensaje">
                        <input type="text" id="enviar-mensaje" placeholder="Introduzca su mensaje...">
                        <img src="/assets/img/web/svg/market/send.svg" alt="Enviar Mensaje" id="enviar-mensaje-button">
                    </article>
                </section>
            </section>
            <section class="chat-container__open-close">
                <img src="/assets/img/web/svg/market/chat.svg" alt="Chat" id="chat-abierto">
                <img class="hide" src="/assets/img/web/svg/market/send.svg" alt="Chat" id="chat-cerrado">
            </section>
        </aside>
        <?php
    }
    ?>
</body>
</html>