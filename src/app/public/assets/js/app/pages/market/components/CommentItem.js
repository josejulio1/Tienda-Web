import {V_COMENTARIO_CLIENTE_PRODUCTO} from "../../../api/models.js";

export class CommentItem {
    constructor(data) {
        this.commentItem = document.createElement('div');
        const comentarioItemEsencial = document.createElement('div');
        const imagenPerfil = document.createElement('img');
        const nombreApellidosClienteH3 = document.createElement('h3');
        const contenedorEstrellas = document.createElement('div');
        const comentarioP = document.createElement('p');
        let imagenEstrella;

        this.commentItem.classList.add('comentario__item');
        comentarioItemEsencial.classList.add('comentario__item--esencial');
        imagenPerfil.src = data[V_COMENTARIO_CLIENTE_PRODUCTO.RUTA_IMAGEN_PERFIL];
        imagenPerfil.alt = 'Foto de perfil cliente';
        nombreApellidosClienteH3.textContent = `${data[V_COMENTARIO_CLIENTE_PRODUCTO.NOMBRE_CLIENTE]} ${data[V_COMENTARIO_CLIENTE_PRODUCTO.APELLIDOS_CLIENTE]}`;
        contenedorEstrellas.classList.add('comentario__item--estrellas');
        comentarioP.classList.add('comentario__item--comentario');
        comentarioP.textContent = data[V_COMENTARIO_CLIENTE_PRODUCTO.COMENTARIO];

        comentarioItemEsencial.appendChild(imagenPerfil);
        comentarioItemEsencial.appendChild(nombreApellidosClienteH3);
        let numValoracion = data[V_COMENTARIO_CLIENTE_PRODUCTO.NUM_ESTRELLAS];
        for (let i = 0; i < 5; i++) {
            imagenEstrella = document.createElement('img');
            imagenEstrella.alt = 'Estrella';
            imagenEstrella.loading = 'lazy';
            if (numValoracion-- > 0) {
                imagenEstrella.src = '/assets/img/web/svg/star-filled.svg';
            } else {
                imagenEstrella.classList.add('invert-color');
                imagenEstrella.src = '/assets/img/web/svg/star-no-filled.svg';
            }
            contenedorEstrellas.appendChild(imagenEstrella);
        }
        this.commentItem.appendChild(comentarioItemEsencial);
        this.commentItem.appendChild(contenedorEstrellas);
        this.commentItem.appendChild(comentarioP);
    }

    getItem() {
        return this.commentItem;
    }
}