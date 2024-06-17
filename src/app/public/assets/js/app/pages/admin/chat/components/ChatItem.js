import {V_CHAT_CLIENTE_INFO} from "../../../../api/models.js";
import {ajax} from "../../../../api/ajax.js";
import {END_POINTS} from "../../../../api/end-points.js";
import {HTTP_STATUS_CODES} from "../../../../api/http-status-codes.js";
import {InfoWindow} from "../../../../components/InfoWindow.js";
import {ChatMessage} from "../../../../chat/components/ChatMessage.js";
import {scrollDown} from "../../../../chat/scroll-down.js";

/**
 * Crea un elemento DOM de un Cliente en la lista de clientes en el chat del panel de administración
 * @author josejulio1
 * @version 1.0
 */
export class ChatItem {
    /**
     * Constructor de ChatItem.
     * @param data {Array} Datos del backend
     */
    constructor(data) {
        this.chatItem = document.createElement('div');
        const imagenPerfil = document.createElement('img');
        const correoP = document.createElement('p');

        this.chatItem.classList.add('chat__item');
        this.chatItem.setAttribute('cliente-id', data[V_CHAT_CLIENTE_INFO.CLIENTE_ID]);
        this.chatItem.addEventListener('click', async function(){
            const $chatMensajes = $('#chat__mensajes');
            // Limpiar chat
            $chatMensajes.html('');
            $('.chat__item[selected-chat-item]').removeAttr('selected-chat-item');
            $(this).attr('selected-chat-item', true);
            // En caso de pulsar el cliente, abrir su chat
            const response = await ajax(`${END_POINTS.CHAT.GET_CUSTOMER_MESSAGES}?id=${$(this).attr('cliente-id')}`, 'GET');
            if (response.status !== HTTP_STATUS_CODES.OK) {
                InfoWindow.make(response.message);
                return;
            }
            const { data: { mensajes } } = response;
            // Cambiar usuario de la cabecera
            $('#imagen-perfil-cliente').attr('src', $(this).find('img').attr('src'));
            $('#info-cliente-chat').html($(this).find('.correo__chat__item').html());
            // Cargar mensajes
            const documentFragment = document.createDocumentFragment();
            for (const mensaje of mensajes) {
                documentFragment.appendChild(
                    new ChatMessage(mensaje).getChatMessage()
                );
            }
            $chatMensajes.append(documentFragment);
            scrollDown();
        })
        imagenPerfil.src = data[V_CHAT_CLIENTE_INFO.RUTA_IMAGEN_PERFIL];
        imagenPerfil.alt = 'Imagen de Perfil de Cliente'
        imagenPerfil.loading = 'lazy';
        correoP.textContent = data[V_CHAT_CLIENTE_INFO.CORREO];
        correoP.classList.add('correo__chat__item');

        this.chatItem.appendChild(imagenPerfil);
        this.chatItem.appendChild(correoP);
    }

    /**
     * Obtiene el DOM del elemento
     * @returns {HTMLDivElement} DOM del elemento
     */
    getChatItem() {
        return this.chatItem;
    }
}