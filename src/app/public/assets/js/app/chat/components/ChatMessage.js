import {V_CHAT_CLIENTE_INFO} from "../../api/models.js";

/**
 * Crea un componente DOM para crear un mensaje en el Chat entre Cliente y Usuario
 */
export class ChatMessage {
    /**
     * Constructor de ChatMessage.
     * @param data Datos del backend
     * @param mostrarImagenPerfil {boolean} True si se quiere mostrar la foto de perfil y false si no
     */
    constructor(data, mostrarImagenPerfil = true) {
        this.chatMessage = document.createElement('div');
        const messageP = document.createElement('p');

        if (mostrarImagenPerfil) {
            const profileImg = document.createElement('img');
            profileImg.src = data[V_CHAT_CLIENTE_INFO.RUTA_IMAGEN_PERFIL];
            profileImg.loading = 'lazy';
            this.chatMessage.appendChild(profileImg);
        }

        this.chatMessage.classList.add('mensaje__container');
        if (!data[V_CHAT_CLIENTE_INFO.ES_CLIENTE]) {
            this.chatMessage.classList.add('admin');
        }
        messageP.classList.add('mensaje-principal');
        messageP.textContent = data[V_CHAT_CLIENTE_INFO.MENSAJE];

        this.chatMessage.appendChild(messageP);
    }

    getChatMessage() {
        return this.chatMessage;
    }
}