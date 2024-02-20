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
</head>
<body>
    <header>
        <nav>
            <a href="#">BYTEMARKET</a>
            <section class="search-bar">
                <input type="text" id="search-bar--input" placeholder="Buscar">
                <img src="/assets/img/web/svg/search.svg" alt="Buscar" id="search-bar--img">
                <article id="search-bar--items"></article>
            </section>
            <?php
            session_start();
            require_once __DIR__ . '/api/utils/Rol.php';
            if ($_SESSION && $_SESSION['rol'] == Rol::CUSTOMER) { ?>
                <a href="#" class="cuenta">
                    <img src="/assets/img/internal/default/default-avatar.jpg" alt="Foto de perfil">
                    <p>Cuenta</p>
                </a>
                <section class="carrito">
                    <span id="num-articulos-carrito">0</span>
                    <img src="/assets/img/web/svg/cart.svg" alt="Carrito">
                    <p>Carrito</p>
                </section>
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
    </header>
    <main>
        
    </main>
    <footer>
        <p>Todos los derechos reservados</p>
    </footer>
</body>
</html>