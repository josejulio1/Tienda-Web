import {END_POINTS} from "../api/end-points.js";
import {HTTP_STATUS_CODES} from "../api/http-status-codes.js";
import {InfoWindow} from "../components/InfoWindow.js";
import {ERROR_MESSAGES} from "../api/error-messages.js";
import {V_CHAT_CLIENTE_IMAGEN} from "../crud/models.js";
import {ChatItem} from "./models/ChatItem.js";
import {select} from "../crud/crud.js";

const $chatAbierto = $('#chat-abierto');
const $chatCerrado = $('#chat-cerrado');
const $chat = $('.chat');
const $chatMensajes = $('#chat__mensajes');
const $enviarMensaje = $('#enviar-mensaje');
const $enviarMensajeButton = $('#enviar-mensaje-button');

window.addEventListener('load', () => {
    if (!$chat.length) {
        return;
    }
    setInterval(async () => {
        const json = await select(V_CHAT_CLIENTE_IMAGEN.TABLE_NAME, [
            V_CHAT_CLIENTE_IMAGEN.ID,
            V_CHAT_CLIENTE_IMAGEN.RUTA_IMAGEN_PERFIL,
            V_CHAT_CLIENTE_IMAGEN.MENSAJE,
            V_CHAT_CLIENTE_IMAGEN.ES_CLIENTE
        ]);
        $chatMensajes.html('');
        for (const chat of json) {
            $chatMensajes.append(
                new ChatItem(
                    chat[V_CHAT_CLIENTE_IMAGEN.RUTA_IMAGEN_PERFIL],
                    chat[V_CHAT_CLIENTE_IMAGEN.MENSAJE],
                    chat[V_CHAT_CLIENTE_IMAGEN.ES_CLIENTE]
                ).getItem()
            );
        }
        const $chatMensajesJs = document.getElementById('chat__mensajes');
        $chatMensajesJs.scrollTo(0, $chatMensajesJs.scrollHeight);
    }, 5000)
})

$chatAbierto.on('click', () => {
    $chat.addClass('open-chat');
    $chatAbierto.addClass('hide');
    $chatCerrado.removeClass('hide');
})

$chatCerrado.on('click', () => {
    $chat.removeClass('open-chat');
    $chatCerrado.addClass('hide');
    $chatAbierto.removeClass('hide');
})

$enviarMensaje.on('keydown', e => {
    if (e.key !== 'Enter') {
        return;
    }
    enviarMensaje();
})
$enviarMensajeButton.on('click', enviarMensaje);

function enviarMensaje() {
    if (!$enviarMensaje.val()) {
        return;
    }

    const fd = new FormData();
    fd.append(V_CHAT_CLIENTE_IMAGEN.MENSAJE, $enviarMensaje.val());

    fetch(END_POINTS.MARKET.CHAT.ADD, {
        method: 'POST',
        body: fd
    })
    .then(response => response.json())
    .then(data => {
        const { status } = data;

        if (status === HTTP_STATUS_CODES.SERVICE_UNAVAILABLE) {
            InfoWindow.make(ERROR_MESSAGES[status]);
            return;
        }
        $chatMensajes.append(
            new ChatItem(
                data[V_CHAT_CLIENTE_IMAGEN.RUTA_IMAGEN_PERFIL],
                $enviarMensaje.val(),
                data[V_CHAT_CLIENTE_IMAGEN.ES_CLIENTE]
            ).getItem()
        );
        const $chatMensajesJs = document.getElementById('chat__mensajes');
        $chatMensajesJs.scrollTo(0, $chatMensajesJs.scrollHeight);
        $enviarMensaje.val('');
    })
}