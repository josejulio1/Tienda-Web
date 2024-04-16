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
    <link rel="stylesheet" href="/assets/css/dark-mode.css">
    <script src="/assets/js/lib/jquery-3.7.1.min.js" defer></script>
    <script src="/assets/js/market/auth.js" defer type="module"></script>
    <script src="/assets/js/dark-mode.js" defer></script>
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
                <form class="login selected">
                    <div class="box-form">
                        <label for="correo-login">Correo</label>
                        <input type="email" id="correo-login" required placeholder="Ej: mi.correo@gmail.com">
                        <p class="is-invalid hide">Introduzca su correo electrónico</p>
                    </div>
                    <div class="box-form">
                        <label for="contrasenia-login">Contraseña</label>
                        <input type="password" id="contrasenia-login" required>
                        <p class="is-invalid hide">Introduzca su contraseña</p>
                    </div>
                    <!-- Componente: LoadingButton -->
                    <button class="btn-info" type="submit" id="button-iniciar-sesion">Iniciar Sesión</button>
                </form>
                <form class="register">
                    <div class="box-form">
                        <label for="nombre-register">Nombre</label>
                        <input type="text" id="nombre-register" required placeholder="Ej: Darío">
                        <p class="is-invalid hide">Introduzca su nombre</p>
                    </div>
                    <div class="box-form">
                        <label for="apellidos-register">Apellidos</label>
                        <input type="text" id="apellidos-register" required placeholder="Ej: Gómez">
                        <p class="is-invalid hide">Introduzca sus apellidos</p>
                    </div>
                    <div class="box-form">
                        <label for="telefono-register">Teléfono</label>
                        <input type="tel" id="telefono-register" required placeholder="Ej: +34 123456789">
                        <p class="is-invalid hide">Introduzca su teléfono</p>
                    </div>
                    <div class="box-form">
                        <label for="correo-register">Correo</label>
                        <input type="email" id="correo-register" required placeholder="Ej: dario.gomez@gmail.com">
                        <p class="is-invalid hide">Introduzca un correo electrónico</p>
                    </div>
                    <div class="box-form">
                        <label for="contrasenia-register">Contraseña</label>
                        <input type="password" id="contrasenia-register" required>
                        <p class="is-invalid hide">Introduzca una contraseña</p>
                    </div>
                    <div class="box-form">
                        <label>Foto de perfil (Opcional)</label>
                        <!-- COMPONENTE: PreviewImage -->
                        <label class="img-container" for="imagen-register"></label>
                    </div>
                    <!-- Componente: LoadingButton -->
                    <button class="btn-info" type="submit" id="button-registrarse">Registrarse</button>
                </form>
            </article>
        </section>
    </main>
    <?php
    require_once __DIR__ . '/../templates/dark-mode.php';
    ?>
</body>
</html>