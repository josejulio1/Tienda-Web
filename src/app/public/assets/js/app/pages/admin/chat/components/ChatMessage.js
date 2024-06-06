export class ChatMessage {
    constructor(data) {
        this.chatMessage = document.createElement('div');
        const profileImg = document.createElement('img');
        const messageP = document.createElement('p');

        this.chatMessage.classList.add('mensaje__container');
        if (data['es-admin']) {
            this.chatMessage.classList.add('admin');
        }
        profileImg.src = data['ruta-imagen-perfil'];
        profileImg.loading = 'lazy';
        messageP.classList.add('mensaje');
        messageP.textContent = data['message'];

        this.chatMessage.appendChild(profileImg);
        this.chatMessage.appendChild(messageP);
    }

    getChatMessage() {
        return this.chatMessage;
    }
}