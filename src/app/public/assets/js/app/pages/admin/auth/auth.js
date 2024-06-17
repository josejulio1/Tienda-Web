import {ajax} from "../../../api/ajax.js";
import {LoadingButton} from "../../../components/LoadingButton.js";
import {USUARIO} from "../../../api/models.js";
import {END_POINTS} from "../../../api/end-points.js";
import {InfoWindow} from "../../../components/InfoWindow.js";
import {Validators} from "../../../services/Validators.js";
import {HTTP_STATUS_CODES} from "../../../api/http-status-codes.js";

const $correo = $('#correo');
const $contrasenia = $('#contrasenia');
const $mantenerSesion = $('#mantener-sesion');

new LoadingButton('.btn-info', 'Iniciar Sesión', async ($buttonP, $buttonLoading) => {
    let hayErrores;
    const correo = $correo.val();
    if (!correo || !Validators.isEmail(correo) || !Validators.isNotXss(correo)) {
        $correo.next().removeClass('hide');
        hayErrores = true;
    }

    const contrasenia = $contrasenia.val();
    if (!contrasenia || !Validators.isNotXss(contrasenia)) {
        $contrasenia.next().removeClass('hide');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }

    const formData = new FormData();
    formData.append(USUARIO.CORREO, correo);
    formData.append(USUARIO.CONTRASENIA, contrasenia);
    formData.append('mantener-sesion', $mantenerSesion.prop('checked'));

    $buttonP.addClass('hide');
    $buttonLoading.removeClass('hide');
    const response = await ajax(END_POINTS.USUARIO.LOGIN, 'POST', formData);
    $buttonP.removeClass('hide');
    $buttonLoading.addClass('hide');
    if (response.status !== HTTP_STATUS_CODES.OK) {
        InfoWindow.make(response.message, false);
        return;
    }
    window.location.href = '/admin/user';
});