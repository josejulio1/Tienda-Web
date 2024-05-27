export class ChatItem {
    constructor(rutaImagen, mensaje, esCliente) {
        this.div = document.createElement('div');
        const imagen = document.createElement('img');
        const mensajeP = document.createElement('p');

        this.div.classList.add('mensaje', esCliente ? 'mensaje-cliente' : 'mensaje-usuario');
        imagen.src = rutaImagen;
        imagen.alt = 'Imagen';
        mensajeP.textContent = mensaje;

        this.div.appendChild(imagen);
        this.div.appendChild(mensajeP);
    }

    getItem() {
        return this.div;
    }
}