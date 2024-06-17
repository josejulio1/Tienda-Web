import {ajax} from "../../../api/ajax.js";
import {END_POINTS} from "../../../api/end-points.js";
import {HTTP_STATUS_CODES} from "../../../api/http-status-codes.js";
import {InfoWindow} from "../../../components/InfoWindow.js";
import {V_CHAT_CLIENTE_INFO, CHAT} from "../../../api/models.js";
import {ChatMessage} from "../../../chat/components/ChatMessage.js";
import {scrollDown} from "../../../chat/scroll-down.js";

const $chatMensajes = $('#chat__mensajes');
const $enviarMensaje = $('#enviar-mensaje');
const $enviarMensajeButton = $('#enviar-mensaje-button');

window.addEventListener('load', async () => {
    listenMessages();
})

$enviarMensaje.on('keydown', e => {
    if (e.key !== 'Enter' || !$enviarMensaje.val()) {
        return;
    }
    sendMessage();
})
$enviarMensajeButton.on('click', sendMessage);

/**
 * Realiza una petición cada 5 segundos consultando los mensajes en la base de datos
 */
function listenMessages() {
    setInterval(async () => {
        const response = await ajax(END_POINTS.CHAT.GET_CUSTOMER_MESSAGES, 'GET');
        let { data: { mensajes } } = response;
        $chatMensajes.html('');
        const documentFragment = document.createDocumentFragment();
        for (const mensaje of mensajes) {
            // Decir que no es cliente para situar el mensaje a la izquierda
            mensaje[V_CHAT_CLIENTE_INFO.ES_CLIENTE] = !mensaje[V_CHAT_CLIENTE_INFO.ES_CLIENTE];
            documentFragment.appendChild(
                new ChatMessage(mensaje, !mensaje[V_CHAT_CLIENTE_INFO.ES_CLIENTE]).getChatMessage()
            );
        }
        $chatMensajes.append(documentFragment);
        scrollDown();
    }, 5000)
}

/**
 * Envía un mensaje a un administrador en el chat
 * @returns {Promise<void>} Promesa que no es necesario obtenerla
 */
async function sendMessage() {
    const mensaje = $enviarMensaje.val();
    if (!mensaje) {
        return;
    }
    const formData = new FormData();
    formData.append(CHAT.MENSAJE, mensaje);
    formData.append(CHAT.ES_CLIENTE, '1');
    const response = await ajax(END_POINTS.CHAT.SEND_MESSAGE, 'POST', formData);
    if (response.status !== HTTP_STATUS_CODES.OK) {
        InfoWindow.make(response.message);
        return;
    }
    const data = {
        [V_CHAT_CLIENTE_INFO.RUTA_IMAGEN_PERFIL]: $('#imagen-perfil-nav').attr('src'),
        [V_CHAT_CLIENTE_INFO.MENSAJE]: mensaje,
        [V_CHAT_CLIENTE_INFO.ES_CLIENTE]: false
    }
    $chatMensajes.append(
        new ChatMessage(data).getChatMessage()
    );
    scrollDown();
    $enviarMensaje.val('');
}
