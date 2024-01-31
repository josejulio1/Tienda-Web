import { HTTP_STATUS_CODES } from "../api/http-status-codes.js";
import { END_POINTS } from "../api/end-points.js";
import { LoadingButton } from "../components/LoadingButton.js";
import { USUARIO } from "./models/models.js";
import { ErrorWindow } from "../components/ErrorWindow.js";
/* import { error } from "./utils.js"; */

const $correo = $('#correo');
const $contrasenia = $('#contrasenia');
const $mantenerSesion = $('#mantener-sesion');

new LoadingButton('.btn-info', 'Iniciar Sesión', ($buttonP, $buttonLoading) => {
    let hayErrores;
    if (!$correo.val()) {
        $correo.next().removeClass('hide');
        /* error('Introduzca una dirección de correo'); */
        hayErrores = true;
    }
    
    if (!$contrasenia.val()) {
        $contrasenia.next().removeClass('hide');
        /* error('Introduzca una contraseña'); */
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }

    $buttonP.addClass('hide');
    $buttonLoading.removeClass('hide');
    const fd = new FormData();
    fd.append(USUARIO.CORREO, $correo.val());
    fd.append(USUARIO.CONTRASENIA, $contrasenia.val());
    fd.append('mantener-sesion', $mantenerSesion.prop('checked'));
    fetch(`${END_POINTS.LOGIN}?table-name=${USUARIO.TABLE_NAME}`, {
        method: 'POST',
        body: fd
    })
    .then(response => {
        $buttonP.removeClass('hide');
        $buttonLoading.addClass('hide');
        const { status } = response;
        if (status == HTTP_STATUS_CODES.SERVICE_UNAVAILABLE) {
            ErrorWindow.make('No se pudo conectar con la base de datos. Inténtelo más tarde');
            return;
        }
        if (status != HTTP_STATUS_CODES.OK) {
            ErrorWindow.make('Usuario o contraseña incorrectos');
            return;
        }
        window.location.href = '/admin/user.php';
    })
});