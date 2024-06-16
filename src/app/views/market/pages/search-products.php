<header>
    <?php
    require_once __DIR__ . '/../templates/nav.php';
    ?>
</header>
<main class="busqueda__productos">
    <section class="busqueda">
        <article class="busqueda__container">
            <h3>Precio</h3>
            <div class="busqueda__precio">
                <input type="number" id="precio-min" min="1" value="1">
                <span>-</span>
                <input type="number" id="precio-max" min="1">
            </div>
        </article>
        <hr>
        <article class="busqueda__container">
            <h3>Categorías</h3>
            <div class="busqueda__item">
                <?php
                foreach ($categorias as $categoria) {
                    ?>
                    <div class="busqueda__checkbox busqueda__categoria">
                        <input type="checkbox" value="<?php echo $categoria -> id; ?>" id="categoria-<?php echo $categoria -> id; ?>">
                        <label for="categoria-<?php echo $categoria -> id; ?>"><?php echo $categoria -> nombre; ?></label>
                    </div>
                    <?php
                }
                ?>
            </div>
        </article>
        <hr>
        <article class="busqueda__container">
            <h3>Marcas</h3>
            <div class="busqueda__item">
                <?php
                foreach ($marcas as $marca) {
                    ?>
                    <div class="busqueda__checkbox busqueda__marca">
                        <input type="checkbox" value="<?php echo $marca -> id; ?>" id="marca-<?php echo $marca -> id; ?>">
                        <label for="marca-<?php echo $marca -> id; ?>"><?php echo $marca -> marca; ?></label>
                    </div>
                    <?php
                }
                ?>
            </div>
        </article>
    </section>
    <section class="productos">
        <input type="text" placeholder="Busque por producto" id="buscar-producto">
        <article id="producto__items">
            <?php
            require_once __DIR__ . '/../templates/print-products.php';
            imprimirProductos($productos);
            ?>
        </article>
    </section>
</main>
<?php
require_once __DIR__ . '/../templates/chat.php';