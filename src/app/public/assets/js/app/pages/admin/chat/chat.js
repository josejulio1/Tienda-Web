import {ajax} from "../../../api/ajax.js";
import {END_POINTS} from "../../../api/end-points.js";
import {HTTP_STATUS_CODES} from "../../../api/http-status-codes.js";
import {InfoWindow} from "../../../components/InfoWindow.js";
import {ChatMessage} from "../../../chat/components/ChatMessage.js";
import {CHAT, V_CHAT_CLIENTE_INFO} from "../../../api/models.js";
import {ChatItem} from "./components/ChatItem.js";
import {scrollDown} from "../../../chat/scroll-down.js";

const $notificationSound = document.getElementById('audio-notification');
const $chats = $('#chats');
const $chatMensajes= $('#chat__mensajes');
const $enviarMensaje = $('#enviar-mensaje');
const $enviarMensajeButton = $('#enviar-mensaje-button');
let clientesRegistrados = [];

window.addEventListener('load', () => {
    listenCustomers();
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
 * Realiza una petición al backend cada 5 segundos consultando si existe algún mensaje nuevo de algún cliente,
 * y en caso de que lo haya, crea un DOM de ChatItem para adjuntar el cliente a la lista de clientes
 */
function listenCustomers() {
    // Cargar chat cada 5 segundos
    setInterval(async () => {
        const response = await ajax(END_POINTS.CHAT.GET_CUSTOMERS, 'GET');
        let { data: { clientes } } = response;
        // Eliminar clientes que ya estén en la parte izquierda del chat
        for (const cliente of clientes) {
            if (!clientesRegistrados.includes(cliente[V_CHAT_CLIENTE_INFO.CLIENTE_ID])) {
                $notificationSound.play();
                $chats.append(
                    new ChatItem(cliente).getChatItem()
                );
                clientesRegistrados.push(cliente[V_CHAT_CLIENTE_INFO.CLIENTE_ID]);
            }
        }
    }, 5000)
}

/**
 * Realiza una petición cada 5 segundos consultando los mensajes con el cliente que se está hablando. En
 * caso de que el administrador no esté hablando con ningún cliente, no hará nada
 */
function listenMessages() {
    setInterval(async () => {
        const $chatSelectedItem = $('.chat__item[selected-chat-item]');
        if (!$chatSelectedItem.length) {
            return;
        }
        const response = await ajax(`${END_POINTS.CHAT.GET_CUSTOMER_MESSAGES}?id=${$chatSelectedItem.attr('cliente-id')}`, 'GET');
        let { data: { mensajes } } = response;
        $chatMensajes.html('');
        const documentFragment = document.createDocumentFragment();
        for (const mensaje of mensajes) {
            documentFragment.appendChild(
                new ChatMessage(mensaje).getChatMessage()
            );
        }
        $chatMensajes.append(documentFragment);
        scrollDown();
    }, 5000)
}

/**
 * Envía un mensaje a un cliente en el chat
 * @returns {Promise<void>} Promesa que no es necesario obtenerla
 */
async function sendMessage() {
    const mensaje = $enviarMensaje.val();
    if (!mensaje) {
        return;
    }
    // Si no hay ningún cliente seleccionado, enviar mensaje de error
    const $chatSelectedItem = $('.chat__item[selected-chat-item]');
    if (!$chatSelectedItem.length) {
        InfoWindow.make('Debes de tener seleccionado un cliente');
        return;
    }

    const formData = new FormData();
    formData.append(CHAT.CLIENTE_ID, $chatSelectedItem.attr('cliente-id'));
    formData.append(CHAT.MENSAJE, mensaje);
    formData.append(CHAT.ES_CLIENTE, '0');
    const response = await ajax(END_POINTS.CHAT.SEND_MESSAGE, 'POST', formData);
    if (response.status !== HTTP_STATUS_CODES.OK) {
        InfoWindow.make(response.message);
        return;
    }
    // Adjuntar mensaje escrito
    const data = {
        [V_CHAT_CLIENTE_INFO.RUTA_IMAGEN_PERFIL]: $('#imagen-perfil-usuario').attr('src'),
        [V_CHAT_CLIENTE_INFO.MENSAJE]: mensaje,
        [V_CHAT_CLIENTE_INFO.ES_CLIENTE]: false
    }
    $chatMensajes.append(
        new ChatMessage(data).getChatMessage()
    );
    scrollDown();
    $enviarMensaje.val('');
}