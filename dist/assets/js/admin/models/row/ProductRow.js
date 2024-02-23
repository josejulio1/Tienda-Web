import { Row } from "./Row.js";

export class ProductRow extends Row {
    constructor(productoId, nombre, precio, marca, stock, imagenProducto, nombreCategoria, puedeBorrar) {
        const imagenProductoImg = document.createElement('img');

        imagenProductoImg.src = imagenProducto;
        imagenProductoImg.alt = 'Imagen del Producto';
        imagenProductoImg.loading = 'lazy';

        super(puedeBorrar, 'eliminar-producto', productoId, nombre, precio, marca, stock, imagenProductoImg.outerHTML, nombreCategoria);
    }
}