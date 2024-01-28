<?php
// Redirigir el usuario a la página de inicio si ya tiene una sesión
session_start();
if ($_SESSION && $_SESSION['logged']) {
    header('Location: /');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticación</title>
    <link rel="stylesheet" href="../css/globals.css">
    <link rel="stylesheet" href="../css/auth.css">
    <link rel="stylesheet" href="../css/utils.css">
    <link rel="stylesheet" href="../css/dark-mode.css">
    <script src="../js/auth-customer.js" type="module" defer></script>
    <script src="../js/dark-mode.js" defer></script>
</head>
<body>
    <main>
        <section class="options">
            <article class="back">
                <a href="..">Volver</a>
            </article>
            <article class="register-login">
                <button id="register" class="register-login-selected">Registrarse</button>
                <button id="login">Iniciar Sesión</button>
            </article>
        </section>
        <section class="form-register-login">
            <form id="register-form">
                <section class="form-row">
                    <article class="form-column">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" required>
                    </article>
                    <article class="form-column">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" id="apellidos" required>
                    </article>
                    <article class="form-column">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" placeholder="+123 123456789"
                        required>
                    </article>
                </section>
                <section class="form-row">
                    <article class="form-column">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion"
                        required>
                    </article>
                </section>
                <section class="form-row">
                    <article class="form-column">
                        <label for="correo-register">Correo</label>
                        <input type="email" id="correo-register"
                        required>
                    </article>
                    <article class="form-column">
                        <label for="contrasenia-register">Contraseña</label>
                        <input type="password" id="contrasenia-register"
                        required>
                    </article>
                </section>
                <section class="form-row">
                    <article class="form-column">
                        <label>Foto de perfil (Opcional)</label>
                        <label class="img-container" id="imagen">
                            <input type="file" id="imagen" hidden>
                            <img id="plus-img" src="../img/web/svg/add.svg" alt="Plus">
                            <img class="hide" id="profile-photo" alt="Profile Photo">
                        </label>
                    </article>
                </section>
                <button class="btn-info" type="submit">
                    <p id="button-p">Registrarse</p>
                    <img id="button-loading" class="hide" src="../img/web/svg/loading.svg" alt="Loading">
                </button>
            </form>
            <form class="hide" id="login-form">
                <section class="form-row">
                    <article class="form-column">
                        <label for="correo-login">Correo</label>
                        <input type="email" id="correo-login">
                    </article>
                </section>
                <section class="form-row">
                    <article class="form-column">
                        <label for="contrasenia-login">Contraseña</label>
                        <input type="password" id="contrasenia-login">
                    </article>
                </section>
                <section class="form-row">
                    <article class="form-column checkbox-column">
                        <input type="checkbox" id="mantener-sesion">
                        <label for="mantener-sesion">Mantener sesión iniciada</label>
                    </article>
                </section>
                <button class="btn-info" type="submit">
                    <p id="button-p">Iniciar Sesión</p>
                    <img id="button-loading" class="hide" src="../img/web/svg/loading.svg" alt="Loading">
                </button>
            </form>
        </section>
    </main>
    <?php include __DIR__ . '/../templates/dark-mode.php'; ?>
</body>
</html>