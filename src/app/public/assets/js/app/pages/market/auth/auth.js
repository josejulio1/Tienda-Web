import { PreviewImage } from "../../../components/PreviewImage.js";
import { InfoWindow } from "../../../components/InfoWindow.js";
import { LoadingButton } from "../../../components/LoadingButton.js";
import { END_POINTS } from "../../../api/end-points.js";
import { HTTP_STATUS_CODES } from "../../../api/http-status-codes.js";
import { CLIENTE } from "../../../api/models.js";
import {Validators} from "../../../services/Validators.js";
import {ajax} from "../../../api/ajax.js";

// Campos Login
const $correoLogin = $('#correo-login');
const $contraseniaLogin = $('#contrasenia-login');
const $mantenerSesion = $('#mantener-sesion');

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
new LoadingButton('#button-iniciar-sesion', 'Iniciar Sesión', async ($buttonP, $buttonLoading) => {
    let hayErrores = false;
    const correo = $correoLogin.val();
    if (!correo || !Validators.isEmail(correo) || !Validators.isNotXss(correo)) {
        $correoLogin.next().removeClass('hide');
        hayErrores = true;
    }

    const contrasenia = $contraseniaLogin.val();
    if (!contrasenia || !Validators.isNotXss(contrasenia)) {
        $contraseniaLogin.next().removeClass('hide');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }

    const formData = new FormData();
    formData.append(CLIENTE.CORREO, correo);
    formData.append(CLIENTE.CONTRASENIA, contrasenia);
    formData.append('mantener-sesion', $mantenerSesion.prop('checked'));
    $buttonP.addClass('hide');
    $buttonLoading.removeClass('hide');
    const response = await ajax(END_POINTS.CLIENTE.LOGIN, 'POST', formData);
    $buttonP.removeClass('hide');
    $buttonLoading.addClass('hide');
    if (response.status !== HTTP_STATUS_CODES.OK) {
        InfoWindow.make(response.message, false);
        return;
    }
    window.location.href = '/';
})

new LoadingButton('#button-registrarse', 'Registrarse',  async($buttonP, $buttonLoading) => {
    let hayErrores = false;
    const nombre = $nombreRegister.val();
    if (!nombre || !Validators.isNotXss(nombre)) {
        $nombreRegister.next().removeClass('hide');
        hayErrores = true;
    }
    
    const apellidos = $apellidosRegister.val();
    if (!apellidos || !Validators.isNotXss(apellidos)) {
        $apellidosRegister.next().removeClass('hide');
        hayErrores = true;
    }

    const telefono = $telefonoRegister.val();
    if (!telefono || !Validators.isPhone(telefono) || !Validators.isNotXss(telefono)) {
        $telefonoRegister.next().removeClass('hide');
        hayErrores = true;
    }

    const correo = $correoRegister.val();
    if (!correo || !Validators.isEmail(correo) || !Validators.isNotXss(correo)) {
        $correoRegister.next().removeClass('hide');
        hayErrores = true;
    }

    const contrasenia = $contraseniaRegister.val();
    if (!contrasenia || !Validators.isNotXss(contrasenia)) {
        $contraseniaRegister.next().removeClass('hide');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }

    const formData = new FormData();
    formData.append(CLIENTE.NOMBRE, nombre);
    formData.append(CLIENTE.APELLIDOS, apellidos);
    formData.append(CLIENTE.TELEFONO, telefono);
    formData.append(CLIENTE.CORREO, correo);
    formData.append(CLIENTE.CONTRASENIA, contrasenia);
    // Si se ha adjuntado una imagen, no usar la imagen por defecto
    const $imagenRegister = $('#imagen-register');
    if ($imagenRegister.prop('files')) {
        formData.append(CLIENTE.RUTA_IMAGEN_PERFIL, $imagenRegister.prop('files')[0]);
    }
    $buttonP.addClass('hide');
    $buttonLoading.removeClass('hide');
    const response = await ajax(END_POINTS.CLIENTE.REGISTER, 'POST', formData);
    if (response.status !== HTTP_STATUS_CODES.OK) {
        InfoWindow.make(response.message);
        return;
    }
    $buttonP.removeClass('hide');
    $buttonLoading.addClass('hide');
    window.location.href = '/';
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

