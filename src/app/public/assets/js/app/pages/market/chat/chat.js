import {ajax} from "../../../api/ajax.js";
import {END_POINTS} from "../../../api/end-points.js";
import {HTTP_STATUS_CODES} from "../../../api/http-status-codes.js";
import {InfoWindow} from "../../../components/InfoWindow.js";

const $chatMensajes = $('#chat__mensajes');
const $enviarMensaje = $('#enviar-mensaje');
const $enviarMensajeButton = $('#enviar-mensaje-button');
let sessionId;

window.addEventListener('load', async () => {
    const response = await ajax(END_POINTS.GET_SESSION_ID, 'GET');
    if (response.status !== HTTP_STATUS_CODES.OK) {
        InfoWindow.make(response.message);
        return;
    }
    sessionId = response.data.sessionId;
})

/*webSocket.addEventListener('message', message => {
    const { data } = message;
    const div = document.createElement('div');
    const profileImg = document.createElement('img');
    const messageP = document.createElement('p');

    div.classList.add('mensaje__container');
    profileImg.src = data['ruta-imagen-perfil'];
    profileImg.loading = 'lazy';
    messageP.textContent = data['message'];

    console.log(message)
})*/

$enviarMensaje.on('keydown', e => {
    if (e.key !== 'Enter' || !$enviarMensaje.val()) {
        return;
    }
    sendMessage();
})
$enviarMensajeButton.on('click', sendMessage);

function sendMessage() {
    /*webSocket.send(JSON.stringify({
        'sessionId': sessionId,
        'sessionType': 2,
        'message': $enviarMensaje.val()
    }));*/
    /*ajax(END_POINTS.);*/
    $enviarMensaje.val('');
}
