export class ChatItem {
    constructor(data) {
        this.chatItem = document.createElement('div');
        const imagenPerfil = document.createElement('img');
        const correoP = document.createElement('p');

        this.chatItem.classList.add('chat__item');
        this.chatItem.setAttribute('cliente-id', data['id']);
        imagenPerfil.src = data['ruta-imagen-perfil'];
        imagenPerfil.alt = 'Imagen de Perfil de Cliente'
        imagenPerfil.loading = 'lazy';
        correoP.textContent = data['correo'];
        correoP.classList.add('correo__chat__item');

        this.chatItem.appendChild(imagenPerfil);
        this.chatItem.appendChild(correoP);
    }

    getChatItem() {
        return this.chatItem;
    }
}