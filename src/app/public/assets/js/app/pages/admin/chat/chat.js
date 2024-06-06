import {WEBSOCKET_CONNECTION} from "../../../config/config.js";
import {ajax} from "../../../api/ajax.js";
import {END_POINTS} from "../../../api/end-points.js";
import {HTTP_STATUS_CODES} from "../../../api/http-status-codes.js";
import {InfoWindow} from "../../../components/InfoWindow.js";
import {ChatMessage} from "./components/ChatMessage.js";
import {ChatItem} from "./components/ChatItem.js";

const webSocket = new WebSocket(WEBSOCKET_CONNECTION);
const $notifications = $('#notifications');
const $notificationSound = document.getElementById('audio-notification');
const $chats = $('#chats');
const $chatMensajes= $('#chat__mensajes');
const $enviarMensaje = $('#enviar-mensaje');
const $enviarMensajeButton = $('#enviar-mensaje-button');
let sessionId, numMessages = 0;

window.addEventListener('load', async () => {
    const response = await ajax(END_POINTS.GET_SESSION_ID, 'GET');
    if (response.status !== HTTP_STATUS_CODES.OK) {
        InfoWindow.make(response.message);
        return;
    }
    sessionId = response.data.sessionId;
})

webSocket.addEventListener('message', message => {
    $notifications.html(++numMessages);
    // Si el chat está cerrado, notificar con un sonido
    if (!$('#chat-container.open-chat').length) {
        $notificationSound.play();
    }
    let { data } = message;
    data = JSON.parse(data);
    // Si el cliente no existe en la lista de clientes, añadirlo
    console.log(data)
    if (!$(`.chat__item[cliente-id=${data['id']}]`).length) {
        $chats.append(
            new ChatItem(data).getChatItem()
        );
    }

    $chatMensajes.append(
        new ChatMessage(data).getChatMessage()
    );
})

$enviarMensaje.on('keydown', e => {
    if (e.key !== 'Enter' || !$enviarMensaje.val()) {
        return;
    }
    sendMessage();
})
$enviarMensajeButton.on('click', sendMessage);

function sendMessage() {
    webSocket.send(JSON.stringify({
        'sessionId': sessionId,
        'sessionType': 1,
        'message': $enviarMensaje.val()
    }));
    const data = {
        'ruta-imagen-perfil': $('#imagen-perfil-usuario').attr('src'),
        'message': $enviarMensaje.val(),
        'es-admin': true
    }
    $chatMensajes.append(
        new ChatMessage(data).getChatMessage()
    );
    const $chatMensajesJs = document.getElementById('chat__mensajes');
    $chatMensajesJs.scrollTo(0, $chatMensajesJs.scrollHeight);
    $enviarMensaje.val('');
}