<?php
function imprimirProductos(array $productos): void {
    foreach ($productos as $producto) { ?>
        <a href="/product?id=<?php echo $producto -> id; ?>" item-id="<?php echo $producto -> id; ?>" class="producto__item">
            <img src="<?php echo $producto -> ruta_imagen; ?>" alt="Imagen Producto" loading="lazy">
            <div class="producto__item__descripcion">
                <h2><?php echo $producto -> nombre; ?></h2>
                <p class="precio"><?php echo $producto -> precio; ?> €</p>
                <div class="producto__item__estrellas">
                    <?php
                    $numEstrellas = $producto -> valoracion_promedio;
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
        </a>
        <?php
    }
}