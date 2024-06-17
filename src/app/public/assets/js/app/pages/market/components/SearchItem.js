import {V_PRODUCTO_VALORACION_PROMEDIO} from "../../../api/models.js";

/**
 * Crea un elemento DOM de un producto buscado desde la barra de búsqueda del nav
 * @author josejulio1
 * @version 1.0
 */
export class SearchItem {
    /**
     * Constructor de SearchItem.
     * @param data {JSON} Datos necesarios para crear el producto. Estos datos se recogen en el backend
     */
    constructor(data) {
        this.searchItem = document.createElement('div');
        const imagen = document.createElement('img');
        const descripcionContenedor = document.createElement('div');
        const nombreH2 = document.createElement('h2');
        const precioP = document.createElement('p');
        const contenedorEstrellas = document.createElement('div');
        let imagenEstrella;

        this.searchItem.setAttribute('item-id', data[V_PRODUCTO_VALORACION_PROMEDIO.ID]);
        this.searchItem.classList.add('search-bar--item');
        imagen.src = data[V_PRODUCTO_VALORACION_PROMEDIO.RUTA_IMAGEN];
        imagen.alt = 'Imagen Item';
        descripcionContenedor.classList.add('search-bar--item__description');
        nombreH2.textContent = data[V_PRODUCTO_VALORACION_PROMEDIO.NOMBRE];
        precioP.classList.add('precio');
        precioP.textContent = `${data[V_PRODUCTO_VALORACION_PROMEDIO.PRECIO]} €`;
        contenedorEstrellas.classList.add('search-bar--item__valoracion');

        this.searchItem.appendChild(imagen);
        descripcionContenedor.appendChild(nombreH2);
        descripcionContenedor.appendChild(precioP);
        descripcionContenedor.appendChild(precioP);
        let numValoracion = data[V_PRODUCTO_VALORACION_PROMEDIO.VALORACION_PROMEDIO];
        for (let i = 0; i < 5; i++) {
            imagenEstrella = document.createElement('img');
            imagenEstrella.alt = 'Estrella';
            imagenEstrella.loading = 'lazy';
            if (numValoracion-- > 0) {
                imagenEstrella.src = '/assets/img/web/market/comment/star-filled.svg';
            } else {
                imagenEstrella.src = '/assets/img/web/market/comment/star-no-filled.svg';
            }
            contenedorEstrellas.appendChild(imagenEstrella);
        }
        descripcionContenedor.appendChild(contenedorEstrellas);
        this.searchItem.appendChild(descripcionContenedor);
        this.searchItem.addEventListener('click', e => {
            window.location.href = `/product?id=${e.target.getAttribute('item-id')}`;
        })
    }

    /**
     * Devuelve el DOM del producto
     * @returns {HTMLDivElement} DOM del producto
     */
    getItem() {
        return this.searchItem;
    }
}