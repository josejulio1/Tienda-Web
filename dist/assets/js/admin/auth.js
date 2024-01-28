import { HTTP_STATUS_CODES } from "../api/http-status-codes.js";
import { END_POINTS } from "../api/end-points.js";
import { LoadingButton } from "../components/LoadingButton.js";
import { USUARIO } from "./models.js";
/* import { error } from "./utils.js"; */

const $correo = $('#correo');
const $contrasenia = $('#contrasenia');
const $mantenerSesion = $('#mantener-sesion');

new LoadingButton('.btn-info', 'Iniciar Sesión', ($buttonP, $buttonLoading) => {
    if (!$correo.val()) {
        /* error('Introduzca una dirección de correo'); */
        return;
    }

    if (!$contrasenia.val()) {
        /* error('Introduzca una contraseña'); */
        return;
    }

    $buttonP.addClass('hide');
    $buttonLoading.removeClass('hide');
    const fd = new FormData();
    fd.append(USUARIO.CORREO, $correo.val());
    fd.append(USUARIO.CONTRASENIA, $contrasenia.val());
    fd.append('mantener-sesion', $mantenerSesion.prop('checked'));
    fetch(END_POINTS.USER.LOGIN, {
        method: 'POST',
        body: fd
    })
    .then(response => {
        $buttonP.removeClass('hide');
        $buttonLoading.addClass('hide');
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
});