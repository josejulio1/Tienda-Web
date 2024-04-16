<?php
session_start();
require_once __DIR__ . '/../api/utils/RolAccess.php';
if (!$_SESSION || $_SESSION['rol'] != RolAccess::CUSTOMER) {
    header('Location: /');
}
require_once __DIR__ . '/../db/crud.php';
require_once __DIR__ . '/../db/models/Cliente.php';
require_once __DIR__ . '/../db/utils/utils.php';
$infoCliente = select(Cliente::class, [
    Cliente::NOMBRE,
    Cliente::APELLIDOS,
    Cliente::TELEFONO,
    Cliente::RUTA_IMAGEN_PERFIL
], [
    TypesFilters::EQUALS => [
        Cliente::ID => $_SESSION['id']
    ]
])[0];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mi Perfil">
    <title>Mi Perfil</title>
    <link rel="stylesheet" href="/assets/css/globals.css">
    <link rel="stylesheet" href="/assets/css/market/market.css">
    <link rel="stylesheet" href="/assets/css/utils.css">
    <link rel="stylesheet" href="/assets/css/market/profile.css">
    <link rel="stylesheet" href="/assets/css/dark-mode.css">
    <script src="/assets/js/lib/jquery-3.7.1.min.js" defer></script>
    <script src="/assets/js/market/account-options.js" type="module" defer></script>
    <script src="/assets/js/market/cart.js" type="module" defer></script>
    <script src="/assets/js/market/search-bar.js" type="module" defer></script>
    <script src="/assets/js/market/profile.js" type="module" defer></script>
    <script src="/assets/js/dark-mode.js" defer></script>
</head>
<body>
    <header>
        <?php
        require_once __DIR__ . '/../templates/market/nav.php';
        ?>
    </header>
    <main class="perfil">
        <section class="info-perfil">
            <article id="no-guardado" class="hide">
                <img src="/assets/img/web/svg/market/no-saved.svg" alt="Sin Guardar" >
                <p>Sin Guardar</p>
            </article>
            <article class="imagen-perfil">
                <img src="<?php echo $infoCliente[Cliente::RUTA_IMAGEN_PERFIL]; ?>" alt="Imagen Perfil" id="imagen-perfil">
                <label for="imagen" class="editar-imagen-perfil">
                    <img src="/assets/img/web/svg/market/square-add.svg" alt="Cambiar Imagen Perfil" class="hide">
                    <input type="file" id="imagen" class="hide">
                </label>
            </article>
            <h3><?php echo $_SESSION['correo']; ?></h3>
        </section>
        <section class="campos-perfil">
            <h2>Mis datos</h2>
            <article class="datos">
                <div class="columna">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" placeholder="<?php echo $infoCliente[Cliente::NOMBRE]; ?>">
                    <div class="invalid-feedback hide">Introduzca un nombre correcto</div>
                </div>
                <div class="columna">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" placeholder="<?php echo $infoCliente[Cliente::APELLIDOS]; ?>">
                    <div class="invalid-feedback hide">Introduzca unos apellidos correctos</div>
                </div>
                <div class="columna">
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" placeholder="<?php echo $infoCliente[Cliente::TELEFONO]; ?>">
                    <div class="invalid-feedback hide">Introduzca un número de teléfono correcto</div>
                </div>
                <div class="columna">
                    <label for="contrasenia">Nueva Contraseña</label>
                    <input type="password" id="contrasenia">
                    <div class="invalid-feedback hide">Introduzca una contraseña correcta</div>
                </div>
            </article>
        </section>
    </main>
    <aside class="guardar">
        <button id="guardar-cambios">Guardar Cambios</button>
    </aside>
    <?php
    require_once __DIR__ . '/../templates/dark-mode.php';
    ?>
</body>
</html>