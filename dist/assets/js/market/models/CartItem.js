import { eliminarItem } from "../cart.js";

export class CartItem {
    constructor(itemId, imagenProducto, nombreProducto, precioProducto) {
        this.cartItem = document.createElement('article');
        const imagenProductoImg = document.createElement('img');
        const itemDescripcionContainer = document.createElement('div');
        const nombreProductoP = document.createElement('p');
        const precioProductoP = document.createElement('p');
        const precioProductoSpan = document.createElement('span');
        const precioProductoEuroSpan = document.createElement('span');
        const unidadesProductoP = document.createElement('p');
        const unidadesProductoTextoSpan = document.createElement('span');
        const unidadesProductoSpan = document.createElement('span');
        const eliminarItemImg = document.createElement('img');

        this.cartItem.classList.add('carrito__item');
        this.cartItem.setAttribute('item-id', itemId);
        imagenProductoImg.src = imagenProducto;
        imagenProductoImg.alt = 'Imagen Producto';
        itemDescripcionContainer.classList.add('item__descripcion');
        nombreProductoP.classList.add('item__nombre--producto');
        nombreProductoP.textContent = nombreProducto;
        precioProductoSpan.classList.add('precio__producto');
        precioProductoSpan.textContent = precioProducto;
        precioProductoEuroSpan.textContent = '€';
        unidadesProductoTextoSpan.textContent = 'Unidades: ';
        unidadesProductoSpan.classList.add('item__precio');
        unidadesProductoSpan.textContent = 1;
        eliminarItemImg.id = 'eliminar-item';
        eliminarItemImg.src = '/assets/img/web/svg/delete.svg';
        eliminarItemImg.alt = 'Eliminar';
        eliminarItemImg.addEventListener('click', eliminarItem);

        this.cartItem.appendChild(imagenProductoImg);
        itemDescripcionContainer.appendChild(nombreProductoP);
        precioProductoP.appendChild(precioProductoSpan);
        precioProductoP.appendChild(precioProductoEuroSpan);
        itemDescripcionContainer.appendChild(precioProductoP);
        unidadesProductoP.appendChild(unidadesProductoTextoSpan);
        unidadesProductoP.appendChild(unidadesProductoSpan);
        itemDescripcionContainer.appendChild(unidadesProductoP);
        this.cartItem.appendChild(itemDescripcionContainer);
        this.cartItem.appendChild(eliminarItemImg);
    }

    getItem() {
        return this.cartItem;
    }
}