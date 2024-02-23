<?php
require_once __DIR__ . '/db/crud.php';
require_once __DIR__ . '/db/utils/utils.php';
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
    <link rel="stylesheet" href="/assets/css/utils.css">
    <script src="/assets/js/lib/jquery-3.7.1.min.js" defer></script>
    <script src="/assets/js/market/search-bar.js" type="module" defer></script>
    <script src="/assets/js/market/account-options.js" type="module" defer></script>
    <script src="/assets/js/market/market.js" defer></script>
    <script src="/assets/js/market/cart.js" type="module" defer></script>
</head>
<body>
    <header>
        <?php
        require_once __DIR__ . '/templates/market/nav.php';
        ?>
    </header>
    <main>
        <section class="descubrir-productos">
            <h2 class="descubrir-productos__titulo">Descubra nuestros productos</h2>
            <div id="descubrir-productos__items">
                <?php
                require_once __DIR__ . '/db/models/v_producto_valoracion_promedio.php';
                $productos = select(v_producto_valoracion_promedio::class, [
                    v_producto_valoracion_promedio::ID,
                    v_producto_valoracion_promedio::NOMBRE,
                    v_producto_valoracion_promedio::PRECIO,
                    v_producto_valoracion_promedio::RUTA_IMAGEN,
                    v_producto_valoracion_promedio::VALORACION_PROMEDIO
                ], null, 10);

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
                ?>
            </div>
        </section>
    </main>
    <footer>
        <p>Todos los derechos reservados</p>
    </footer>
</body>
</html>