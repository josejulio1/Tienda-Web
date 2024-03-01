import { END_POINTS } from "../api/end-points.js";
import { HTTP_STATUS_CODES } from "../api/http-status-codes.js";
import { ErrorWindow } from "../components/ErrorWindow.js";

const $cerrarSesion = $('#cerrar-sesion');

$cerrarSesion.on('click', () => {
    fetch(END_POINTS.CLOSE_SESSION, {
        method: 'POST'
    })
    .then(response => {
        if (response.status !== HTTP_STATUS_CODES.OK) {
            ErrorWindow.make('No se pudo cerrar sesión. Inténtelo más tarde');
            return;
        }
        window.location.href = '/';
    })
})