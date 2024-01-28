import { HTTP_STATUS_CODES } from "../api/http-status-codes.js";
/* import { error } from "./utils.js"; */

// Button Register-Login Form
const $buttonP = document.getElementById('button-p');
const $buttonLoading = document.getElementById('button-loading');

const $loginForm = document.getElementById('login-form');
const $correo = document.getElementById('correo');
const $contrasenia = document.getElementById('contrasenia');
const $mantenerSesion = document.getElementById('mantener-sesion');

$loginForm.addEventListener('submit', e => {
    e.preventDefault();
    
    if (!$correo.value) {
        /* error('Introduzca una dirección de correo'); */
        return;
    }

    if (!$contrasenia.value) {
        /* error('Introduzca una contraseña'); */
        return;
    }

    $buttonP.classList.add('hide');
    $buttonLoading.classList.remove('hide');
    const fd = new FormData();
    fd.append('correo', $correo.value);
    fd.append('contrasenia', $contrasenia.value);
    fd.append('mantener-sesion', $mantenerSesion.checked);
    fetch('/api/controllers/user/login/index.php', {
        method: 'POST',
        body: fd
    })
    .then(response => {
        $buttonP.classList.remove('hide');
        $buttonLoading.classList.add('hide');
        const { status } = response;
        if (status == HTTP_STATUS_CODES.SERVICE_UNAVAILABLE) {
            // TODO: Agregar mensajes de error
            /* error('No se pudo conectar con la base de datos. Inténtelo más tarde'); */
            return;
        }
        if (status != HTTP_STATUS_CODES.OK) {
            /* error('Usuario o contraseña incorrectos'); */
            return;
        }
        window.location.href = '/admin';
    })
})