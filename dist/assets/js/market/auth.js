import { PreviewImage } from "../components/PreviewImage.js";
import { InfoWindow } from "../components/InfoWindow.js";
import { END_POINTS } from "../api/end-points.js";
import { HTTP_STATUS_CODES } from "../api/http-status-codes.js";
import { LoadingButton } from "../components/LoadingButton.js";
import { CLIENTE } from "../crud/models.js";
import { EMAIL_REGEX, PHONE_REGEX, XSS_REGEX } from "../helpers/regex.js";
import { ERROR_MESSAGES } from "../api/error-messages.js";

// Campos Login
const $correoLogin = $('#correo-login');
const $contraseniaLogin = $('#contrasenia-login');

// Campos Register
const $nombreRegister = $('#nombre-register');
const $apellidosRegister = $('#apellidos-register');
const $telefonoRegister = $('#telefono-register');
const $correoRegister = $('#correo-register');
const $contraseniaRegister = $('#contrasenia-register');

window.addEventListener('load', () => {
    new PreviewImage('.img-container', 'imagen-register');
})

// Botón Login
new LoadingButton('#button-iniciar-sesion', 'Iniciar Sesión', ($buttonP, $buttonLoading) => {
    let hayErrores = false;
    const correo = $correoLogin.val();
    if (!correo || !EMAIL_REGEX.test(correo) || XSS_REGEX.test(correo)) {
        $correoLogin.next().removeClass('hide');
        hayErrores = true;
    }

    const contrasenia = $contraseniaLogin.val();
    if (!contrasenia || XSS_REGEX.test(contrasenia)) {
        $contraseniaLogin.next().removeClass('hide');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }
    
    const fd = new FormData();
    fd.append(CLIENTE.CORREO, correo);
    fd.append(CLIENTE.CONTRASENIA, contrasenia);
    $buttonP.addClass('hide');
    $buttonLoading.removeClass('hide');
    fetch(`${END_POINTS.LOGIN}?table-name=${CLIENTE.TABLE_NAME}`, {
        method: 'POST',
        body: fd
    })
    .then(response => {
        $buttonP.removeClass('hide');
        $buttonLoading.addClass('hide');
        const { status } = response;
        if (status === HTTP_STATUS_CODES.SERVICE_UNAVAILABLE) {
            InfoWindow.make(ERROR_MESSAGES[status]);
            return;
        }
        if (status !== HTTP_STATUS_CODES.OK) {
            InfoWindow.make('Correo o contraseña incorrectos');
            return;
        }
        window.location.href = '/';
    })
})

new LoadingButton('#button-registrarse', 'Registrarse', ($buttonP, $buttonLoading) => {
    let hayErrores = false;
    const nombre = $nombreRegister.val();
    if (!nombre || XSS_REGEX.test(nombre)) {
        $nombreRegister.next().removeClass('hide');
        hayErrores = true;
    }
    
    const apellidos = $apellidosRegister.val();
    if (!apellidos || XSS_REGEX.test(apellidos)) {
        $apellidosRegister.next().removeClass('hide');
        hayErrores = true;
    }

    const telefono = $telefonoRegister.val();
    if (!telefono || !PHONE_REGEX.test(telefono) || XSS_REGEX.test(telefono)) {
        $telefonoRegister.next().removeClass('hide');
        hayErrores = true;
    }

    const correo = $correoRegister.val();
    if (!correo || !EMAIL_REGEX.test(correo) || XSS_REGEX.test(correo)) {
        $correoRegister.next().removeClass('hide');
        hayErrores = true;
    }

    const contrasenia = $contraseniaRegister.val();
    if (!contrasenia || XSS_REGEX.test(contrasenia)) {
        $contraseniaRegister.next().removeClass('hide');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }

    const fd = new FormData();
    fd.append(CLIENTE.NOMBRE, nombre);
    fd.append(CLIENTE.APELLIDOS, apellidos);
    fd.append(CLIENTE.TELEFONO, telefono);
    fd.append(CLIENTE.CORREO, correo);
    fd.append(CLIENTE.CONTRASENIA, contrasenia);
    // Si se ha adjuntado una imagen, no usar la imagen por defecto
    const $imagenRegister = $('#imagen-register');
    if ($imagenRegister.prop('files')) {
        fd.append(CLIENTE.RUTA_IMAGEN_PERFIL, $imagenRegister.prop('files')[0]);
    }
    $buttonP.addClass('hide');
    $buttonLoading.removeClass('hide');
    fetch(`${END_POINTS.CUSTOMER.REGISTER}`, {
        method: 'POST',
        body: fd
    })
    .then(response => {
        $buttonP.removeClass('hide');
        $buttonLoading.addClass('hide');
        const { status } = response;
        if (status === HTTP_STATUS_CODES.SERVICE_UNAVAILABLE) {
            InfoWindow.make(ERROR_MESSAGES[status]);
            return;
        }
        if (status !== HTTP_STATUS_CODES.OK) {
            InfoWindow.make('No se pudo registrar correctamente');
            return;
        }
        window.location.href = '/';
    })
})

// Cambiar de formulario
$('.opcion').on('click', e => {
    const { target } = e;
    if (target.classList.contains('opcion-seleccionada')) {
        return;
    }
    // Campos de opción
    const $opcionActual = $('.opcion-seleccionada');
    const $opcionPulsada = $('.opcion:not(.opcion-seleccionada)');
    $opcionActual.removeClass('opcion-seleccionada');
    $opcionPulsada.addClass('opcion-seleccionada');
    // Formularios
    const $formActual = $(`.${$opcionActual.attr('id').split('-')[0]}`);
    const $formCambio = $('form:not(.selected)');
    $formActual.removeClass('selected');
    $formCambio.addClass('selected');
    // Si la opción pulsada es Iniciar Sesión, animación de mover a la izquierda, sino, volver a la derecha
    if ($opcionActual.attr('id').includes('login')) {
        $formActual.addClass('move-to-left');
        $formCambio.addClass('move-to-left');
    } else {
        $formActual.removeClass('move-to-left');
        $formCambio.removeClass('move-to-left');
    }
})

