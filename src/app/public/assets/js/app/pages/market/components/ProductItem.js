import {V_PRODUCTO_VALORACION_PROMEDIO} from "../../../api/models.js";

export class ProductItem {
    constructor(data) {
        this.productItem = document.createElement('a');
        const productoImg = document.createElement('img');
        const productoItemDescripcionContainer = document.createElement('div');
        const productoTitleH2 = document.createElement('h2');
        const precioP = document.createElement('p');
        const productoItemEstrellasContainer = document.createElement('div');

        this.productItem.href = `/product?id=${data[V_PRODUCTO_VALORACION_PROMEDIO.ID]}`;
        this.productItem.setAttribute('item-id', data[V_PRODUCTO_VALORACION_PROMEDIO.ID]);
        this.productItem.classList.add('producto__item');
        productoImg.src = data[V_PRODUCTO_VALORACION_PROMEDIO.RUTA_IMAGEN];
        productoImg.alt = 'Imagen Producto';
        productoImg.loading = 'lazy';
        productoItemDescripcionContainer.classList.add('producto__item__descripcion');
        productoTitleH2.textContent = data[V_PRODUCTO_VALORACION_PROMEDIO.NOMBRE];
        precioP.classList.add('precio');
        precioP.textContent = `${data[V_PRODUCTO_VALORACION_PROMEDIO.PRECIO]} €`;
        productoItemEstrellasContainer.classList.add('producto__item__estrellas');
        let imagenEstrella;
        let numValoracion = data[V_PRODUCTO_VALORACION_PROMEDIO.VALORACION_PROMEDIO];
        for (let i = 0; i < 5; i++) {
            imagenEstrella = document.createElement('img');
            imagenEstrella.alt = 'Estrella';
            imagenEstrella.loading = 'lazy';
            if (numValoracion-- > 0) {
                imagenEstrella.src = '/assets/img/web/market/comment/star-filled.svg';
            } else {
                imagenEstrella.classList.add('invert-color');
                imagenEstrella.src = '/assets/img/web/market/comment/star-no-filled.svg';
            }
            productoItemEstrellasContainer.appendChild(imagenEstrella);
        }

        this.productItem.appendChild(productoImg);
        productoItemDescripcionContainer.appendChild(productoTitleH2);
        productoItemDescripcionContainer.appendChild(precioP);
        productoItemDescripcionContainer.appendChild(productoItemEstrellasContainer);
        this.productItem.appendChild(productoItemDescripcionContainer);
    }

    getProductItem() {
        return this.productItem;
    }
}