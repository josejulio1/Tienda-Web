import {END_POINTS} from "../api/end-points.js";
import {HTTP_STATUS_CODES} from "../api/http-status-codes.js";
import {InfoWindow} from "../components/InfoWindow.js";
import {ajax} from "../api/ajax.js";

const $cerrarSesion = $('#cerrar-sesion');

$cerrarSesion.on('click', async () => {
    const response = await ajax(END_POINTS.CLOSE_SESSION, 'GET');
    if (response.status !== HTTP_STATUS_CODES.OK) {
        InfoWindow.make(response.message, false);
        return;
    }
    window.location.href = '/';
});