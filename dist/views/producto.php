<?php
$id = $_GET['id'];
if (!filter_var($id, FILTER_VALIDATE_INT) || $id < 1) {
    header('Location: /');
}
require_once __DIR__ . '/../db/crud.php';
require_once __DIR__ . '/../db/utils/utils.php';
require_once __DIR__ . '/../db/models/Producto.php';
// Comprobar que no se introduzca un ID de producto inexistente
$lastIdProduct = select(Producto::class, [Producto::ID], null, [
        TypeOrders::DESC => Producto::ID
], 1)[0][Producto::ID];
if ($id > $lastIdProduct) {
    header('Location: /');
}

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
    <link rel="stylesheet" href="/assets/css/dark-mode.css">
    <script src="/assets/js/lib/jquery-3.7.1.min.js" defer></script>
    <script src="/assets/js/market/search-bar.js" type="module" defer></script>
    <script src="/assets/js/market/account-options.js" type="module" defer></script>
    <script src="/assets/js/market/cart.js" type="module" defer></script>
    <script src="/assets/js/market/product.js" type="module" defer></script>
    <script src="/assets/js/dark-mode.js" defer></script>
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
                    <div class="hide" id="comentarios"></div>
                    <div class="nuevo-comentario">
                        <button id="nuevo-comentario">Comentar</button>
                        <img src="" alt="">
                    </div>
                </div>
            </article>
        </section>
    </main>
    <?php
    require_once __DIR__ . '/../templates/dark-mode.php';
    ?>
</body>
</html>