import {CARRITO_ITEM, V_CARRITO_CLIENTE} from "../../../api/models.js";
import {ajax} from "../../../api/ajax.js";
import {HTTP_STATUS_CODES} from "../../../api/http-status-codes.js";
import {END_POINTS} from "../../../api/end-points.js";
import {InfoWindow} from "../../../components/InfoWindow.js";
import {Cart} from "./Cart.js";

/**
 * Crea un elemento DOM de un artículo individual del carrito de un cliente
 * @author josejulio1
 * @version 1.0
 */
export class CartItem {
    /**
     * Constructor de CartItem
     * @param cart {Cart} Clase del carrito donde se desea insertar el artículo
     * @param data {JSON} Datos necesarios para crear el artículo. Estos datos se recogen en el backend
     */
    constructor(cart, data) {
        this.cart = cart;
        this.cartItem = document.createElement('article');
        this.ultimaCantidad = data[V_CARRITO_CLIENTE.CANTIDAD];

        const imagenProductoImg = document.createElement('img');
        const itemDescripcionContainer = document.createElement('div');
        const nombreProductoP = document.createElement('p');
        const precioProductoP = document.createElement('p');
        const precioProductoSpan = document.createElement('span');
        const precioProductoEuroSpan = document.createElement('span');
        const unidadesProductoP = document.createElement('p');
        const unidadesProductoTextoSpan = document.createElement('span');
        const unidadesProductoContenedorCantidad = document.createElement('div');
        const unidadesProductoCantidadRestarButton = document.createElement('button');
        const unidadesProductoCantidadRestarButtonImg = document.createElement('img');
        const unidadesProductoCantidadInput = document.createElement('input');
        const unidadesProductoCantidadSumarButton = document.createElement('button');
        const unidadesProductoCantidadSumarButtonImg = document.createElement('img');
        const eliminarItemImg = document.createElement('img');

        this.cartItem.classList.add('carrito__item');
        this.cartItem.setAttribute('item-id', data[V_CARRITO_CLIENTE.PRODUCTO_ID]);
        imagenProductoImg.src = data[V_CARRITO_CLIENTE.RUTA_IMAGEN_PRODUCTO];
        imagenProductoImg.alt = 'Imagen Producto';
        itemDescripcionContainer.classList.add('item__descripcion');
        nombreProductoP.classList.add('item__nombre--producto');
        nombreProductoP.textContent = data[V_CARRITO_CLIENTE.NOMBRE_PRODUCTO];
        precioProductoSpan.classList.add('precio__producto');
        precioProductoSpan.textContent = data[V_CARRITO_CLIENTE.PRECIO_PRODUCTO];
        precioProductoEuroSpan.textContent = '€';
        unidadesProductoP.classList.add('unidades__contenedor');
        unidadesProductoTextoSpan.textContent = 'Unidades: ';
        unidadesProductoContenedorCantidad.classList.add('cantidad__contenedor');
        unidadesProductoCantidadRestarButton.classList.add('restar-cantidad');
        unidadesProductoCantidadRestarButton.addEventListener('click', e => this.operacionCantidad(e, false));
        unidadesProductoCantidadRestarButtonImg.src = '/assets/img/web/market/cart/minus.svg';
        unidadesProductoCantidadRestarButtonImg.loading = 'lazy';
        unidadesProductoCantidadInput.classList.add('cantidad');
        unidadesProductoCantidadInput.type = 'text';
        unidadesProductoCantidadInput.value = data[V_CARRITO_CLIENTE.CANTIDAD];
        unidadesProductoCantidadInput.addEventListener('focus', e => {
            // Guardar la cantidad actual por si el usuario cuando establezca una cantidad incorrecta, se ponga la cantidad antigua
            this.ultimaCantidad = e.target.value;
        })
        unidadesProductoCantidadInput.addEventListener('change', e => this.cambiarCantidad(e));
        unidadesProductoCantidadSumarButton.addEventListener('click', e => this.operacionCantidad(e, true));
        unidadesProductoCantidadSumarButton.classList.add('sumar-cantidad');
        unidadesProductoCantidadSumarButtonImg.src = '/assets/img/web/components/preview-image/add.svg';
        unidadesProductoCantidadSumarButtonImg.loading = 'lazy';
        eliminarItemImg.id = 'eliminar-item';
        eliminarItemImg.src = '/assets/img/web/svg/delete.svg';
        eliminarItemImg.alt = 'Eliminar';
        eliminarItemImg.addEventListener('click', e => this.eliminarItem(e, this.cart));

        this.cartItem.appendChild(imagenProductoImg);
        itemDescripcionContainer.appendChild(nombreProductoP);
        precioProductoP.appendChild(precioProductoSpan);
        precioProductoP.appendChild(precioProductoEuroSpan);
        itemDescripcionContainer.appendChild(precioProductoP);
        unidadesProductoP.appendChild(unidadesProductoTextoSpan);
        unidadesProductoCantidadRestarButton.appendChild(unidadesProductoCantidadRestarButtonImg);
        unidadesProductoCantidadSumarButton.appendChild(unidadesProductoCantidadSumarButtonImg);
        unidadesProductoContenedorCantidad.appendChild(unidadesProductoCantidadRestarButton);
        unidadesProductoContenedorCantidad.appendChild(unidadesProductoCantidadInput);
        unidadesProductoContenedorCantidad.appendChild(unidadesProductoCantidadSumarButton);
        unidadesProductoP.appendChild(unidadesProductoContenedorCantidad);
        itemDescripcionContainer.appendChild(unidadesProductoP);
        this.cartItem.appendChild(itemDescripcionContainer);
        this.cartItem.appendChild(eliminarItemImg);
    }

    /**
     * Cambia la cantidad que escriba un usuario en el campo input y la almacena en la base de datos
     * @param e {Event} DOM que accionó el evento. En este caso se acciona al realizar focus
     * @returns {Promise<void>} Devuelve una promesa que no es necesario recogerla
     */
    async cambiarCantidad(e) {
        const { target, target: { value: cantidad } } = e;
        if (parseInt(cantidad) < 1) {
            target.value = this.ultimaCantidad;
            return;
        }
        const formData = new FormData();
        formData.append(V_CARRITO_CLIENTE.PRODUCTO_ID, target.closest('article.carrito__item').getAttribute('item-id'));
        formData.append(V_CARRITO_CLIENTE.CANTIDAD, cantidad);
        const response = await ajax(END_POINTS.CARRITO.SET_QUANTITY, 'POST', formData);
        if (response.status !== HTTP_STATUS_CODES.OK) {
            InfoWindow.make(response.message);
            target.value = this.ultimaCantidad;
            return;
        }
        this.cart.actualizarCarrito();
        target.value = cantidad;
        this.ultimaCantidad = cantidad;
    }

    /**
     * Realiza una operación con la cantidad de un artículo en el carrito.
     * Este método puede decrementar o incrementar en 1 la cantidad de un artículo
     * @param e {MouseEvent} DOM que accionó el evento
     * @param isIncrementar {boolean} Si se quiere incrementar, usar true, si se quiere decrementar, usar false
     * @returns {Promise<void>} Devuelve una promesa que no es necesario recogerla
     */
    async operacionCantidad(e, isIncrementar) {
        const { target } = e;
        // Coger input de la cantidad
        const $input = target.closest('.cantidad__contenedor').children[1];
        if (!isIncrementar && this.ultimaCantidad <= 1) {
            return;
        }

        const formData = new FormData();
        formData.append(V_CARRITO_CLIENTE.PRODUCTO_ID, target.closest('article.carrito__item').getAttribute('item-id'));
        // Ordenar al backend que decrement el ID del
        const response = await ajax(isIncrementar
            ? END_POINTS.CARRITO.INCREMENT_QUANTITY
            : END_POINTS.CARRITO.DECREMENT_QUANTITY, 'POST', formData);
        if (response.status !== HTTP_STATUS_CODES.OK) {
            InfoWindow.make(response.message);
            return;
        }
        const { data: { cantidad } } = response;
        $input.value = cantidad;
        this.ultimaCantidad = cantidad;
        this.cart.actualizarCarrito();
    }

    /**
     * Elimina un artículo del carrito al pulsar la imagen de eliminar
     * @param e {MouseEvent} DOM donde se accionó el evento
     * @param cart {Cart} Clase carrito donde eliminar el artículo
     * @returns {Promise<void>} Devuelve una promesa que no es necesario recogerla
     */
    async eliminarItem(e, cart) {
        const { target } = e;
        const $carritoItem = target.closest('.carrito__item');
        const itemId = parseInt($carritoItem.getAttribute('item-id'));
        const response = await ajax(`${END_POINTS.CARRITO.DELETE}?${CARRITO_ITEM.PRODUCTO_ID}=${itemId}`, 'DELETE');
        if (response.status !== HTTP_STATUS_CODES.OK) {
            InfoWindow.make(response.message);
            return;
        }
        $carritoItem.remove();
        cart.actualizarCarrito();
    }

    /**
     * Devuelve el DOM del artículo del carrito
     * @returns {HTMLElement} DOM del artículo del carrito
     */
    getItem() {
        return this.cartItem;
    }
}