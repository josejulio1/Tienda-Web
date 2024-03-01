<?php
session_start();
require_once __DIR__ . '/../api/utils/RolAccess.php';
if ($_SESSION) {
    if ($_SESSION['rol'] == RolAccess::USER) {
        header('Location: /admin/user.php');
    } else if ($_SESSION['rol'] == RolAccess::CUSTOMER) {
        header('Location: /');
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticación</title>
    <link rel="stylesheet" href="/assets/css/globals.css">
    <link rel="stylesheet" href="/assets/css/admin/auth.css">
    <link rel="stylesheet" href="/assets/css/utils.css">
    <script src="/assets/js/lib/jquery-3.7.1.min.js" defer></script>
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
                    <div class="is-invalid hide">Introduzca un correo válido</div>
                </article>
            </section>
            <section class="form-row">
                <article class="form-column">
                    <label for="contrasenia">Contraseña</label>
                    <input type="password" id="contrasenia">
                    <div class="is-invalid hide">Introduzca una contraseña válida</div>
                </article>
            </section>
            <section class="form-row">
                <article class="form-column checkbox-column">
                    <input type="checkbox" id="mantener-sesion">
                    <label for="mantener-sesion">Mantener sesión iniciada</label>
                </article>
            </section>
            <!-- COMPONENTE: LoadingButton -->
            <button class="btn-info" type="submit">Iniciar Sesión</button>
        </form>
    </main>
</body>
</html>