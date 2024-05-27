import { Row } from "../Row.js";
import {V_PRODUCTO_CATEGORIA} from "../../../../../api/models.js";

export class ProductRow extends Row {
    constructor(data, puedeBorrar) {
        const imagenProductoImg = document.createElement('img');

        imagenProductoImg.src = data[V_PRODUCTO_CATEGORIA.RUTA_IMAGEN];
        imagenProductoImg.alt = 'Imagen del Producto';
        imagenProductoImg.classList.add('img-perfil');
        imagenProductoImg.loading = 'lazy';

        data[V_PRODUCTO_CATEGORIA.RUTA_IMAGEN] = imagenProductoImg.outerHTML;
        super(puedeBorrar, data);
    }
}