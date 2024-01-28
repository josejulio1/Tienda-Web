<?php
session_start();
if ($_SESSION) {
    header('Location: /admin');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticación</title>
    <link rel="stylesheet" href="/assets/css/globals.css">
    <link rel="stylesheet" href="/assets/css/auth.css">
    <link rel="stylesheet" href="/assets/css/utils.css">
    <script src="/assets/js/admin/auth.js" type="module" defer></script>
</head>
<body>
    <main class="no-overflow">
        <form id="login-form">
            <section class="security">
                <img src="/assets/img/web/svg/lock.svg" alt="Candado">
            </section>
            <section class="form-row">
                <article class="form-column">
                    <label for="correo">Correo</label>
                    <input type="email" id="correo">
                </article>
            </section>
            <section class="form-row">
                <article class="form-column">
                    <label for="contrasenia">Contraseña</label>
                    <input type="password" id="contrasenia">
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
                <img id="button-loading" class="hide" src="/assets/img/web/svg/loading.svg" alt="Loading">
            </button>
        </form>
    </main>
</body>
</html>