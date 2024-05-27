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
    <p>Todos los derechos reservados</p>
</footer>
<?php
/*if ($_SESSION && $_SESSION['role'] == RolAccess::CUSTOMER) { */?><!--
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
    --><?php
/*}
*/?>