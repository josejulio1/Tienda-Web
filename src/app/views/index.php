<header>
    <?php
    require_once __DIR__ . '/market/templates/nav.php';
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
                require_once __DIR__ . '/market/templates/print-products.php';
                imprimirProductos($productos);
                ?>
            </div>
        </section>
        <section class="productos">
            <h2 class="productos__titulo">Los más baratos</h2>
            <div id="productos__items">
                <?php
                imprimirProductos($productosPorPrecio);
                ?>
            </div>
        </section>
        <section class="productos">
            <h2 class="productos__titulo">Mejor valorados</h2>
            <div id="productos__items">
                <?php
                imprimirProductos($productosPorValoracion);
                ?>
            </div>
        </section>
    </div>
</main>
<footer>
    <p>Todos los derechos reservados © <?php echo date('Y'); ?></p>
</footer>
<?php
require_once __DIR__ . '/market/templates/chat.php';