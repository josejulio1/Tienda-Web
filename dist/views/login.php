<?php
session_start();
if ($_SESSION) {
    header('Location: /');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceder a una cuenta</title>
    <link rel="stylesheet" href="/assets/css/globals.css">
    <link rel="stylesheet" href="/assets/css/market/auth.css">
    <link rel="stylesheet" href="/assets/css/utils.css">
    <script src="/assets/js/lib/jquery-3.7.1.min.js" defer></script>
    <script src="/assets/js/market/auth.js" defer></script>
</head>
<body>
    <section class="imagen"></section>
    <main>
        <a href="/">BYTEMARKET</a>
        <section class="acceso-contenedor">
            <nav>
                <button id="login-cambio" class="opcion opcion-seleccionada">Iniciar Sesión</button>
                <button id="register-cambio" class="opcion">Registrarse</button>
            </nav>
            <article class="forms-contenedor">
                <form class="login">
                    <div class="box-form">
                        <label for="correo-login">Correo</label>
                        <input type="email" id="correo-login">
                    </div>
                    <div class="box-form">
                        <label for="contrasenia-login">Contraseña</label>
                        <input type="password" id="contrasenia-login">
                    </div>
                    <button type="submit" class="iniciar-sesion">Iniciar Sesión</button>
                </form>
                <form class="register hide">
                    <div class="box-form">
                        <label for="nombre-register">Nombre</label>
                        <input type="text" id="nombre-register">
                    </div>
                    <div class="box-form">
                        <label for="apellidos-register">Apellidos</label>
                        <input type="text" id="apellidos-register">
                    </div>
                    <button type="submit" class="registrarse">Registrarse</button>
                </form>
            </article>
        </section>
    </main>
</body>
</html>