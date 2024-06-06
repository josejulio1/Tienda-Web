import {CARRITO_ITEM, V_CARRITO_CLIENTE} from "../../../api/models.js";
import {ajax} from "../../../api/ajax.js";
import {HTTP_STATUS_CODES} from "../../../api/http-status-codes.js";
import {END_POINTS} from "../../../api/end-points.js";
import {InfoWindow} from "../../../components/InfoWindow.js";

export class CartItem {
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
        /*const unidadesProductoSpan = document.createElement('span');*/
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
        unidadesProductoCantidadRestarButtonImg.src = '/assets/img/web/svg/minus.svg';
        unidadesProductoCantidadRestarButtonImg.loading = 'lazy';
        unidadesProductoCantidadInput.classList.add('cantidad');
        unidadesProductoCantidadInput.type = 'text';
        unidadesProductoCantidadInput.value = data[V_CARRITO_CLIENTE.CANTIDAD];
        unidadesProductoCantidadInput.addEventListener('focus', e => {
            // Guardar la cantidad actual por si el usuario cuando establezca una cantidad incorrecta, se ponga la cantidad antigua
            this.ultimaCantidad = e.target.value;
        })
        unidadesProductoCantidadInput.addEventListener('change', async e => {
            const { target, target: { value: cantidad } } = e;
            if (parseInt(cantidad) < 1) {
                target.value = this.ultimaCantidad;
                return;
            }
            const Producto = {
                [V_CARRITO_CLIENTE.PRODUCTO_ID]: target.closest('article.carrito__item').getAttribute('item-id'),
                [V_CARRITO_CLIENTE.CANTIDAD]: cantidad
            }
            const response = await ajax(END_POINTS.CARRITO.SET_QUANTITY, 'POST', Producto);
            if (response.status !== HTTP_STATUS_CODES.OK) {
                InfoWindow.make(response.message);
                target.value = this.ultimaCantidad;
                return;
            }
            this.cart.actualizarCarrito();
            target.value = cantidad;
        })
        unidadesProductoCantidadSumarButton.addEventListener('click', e => this.operacionCantidad(e, true));
        unidadesProductoCantidadSumarButton.classList.add('sumar-cantidad');
        unidadesProductoCantidadSumarButtonImg.src = '/assets/img/web/svg/add.svg';
        unidadesProductoCantidadSumarButtonImg.loading = 'lazy';
        /*unidadesProductoSpan.classList.add('item__precio');
        unidadesProductoSpan.textContent = '1';*/
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

    async operacionCantidad(e, isIncrementar) {
        const { target } = e;
        // Coger input de la cantidad
        const $input = target.closest('.cantidad__contenedor').children[1];
        if (!isIncrementar && this.ultimaCantidad <= 1) {
            return;
        }

        const Producto = {
            [V_CARRITO_CLIENTE.PRODUCTO_ID]: target.closest('article.carrito__item').getAttribute('item-id')
        }
        // Ordenar al backend que decrement el ID del
        const response = await ajax(isIncrementar
            ? END_POINTS.CARRITO.INCREMENT_QUANTITY
            : END_POINTS.CARRITO.DECREMENT_QUANTITY, isIncrementar ? 'POST': 'DELETE', Producto);
        if (response.status !== HTTP_STATUS_CODES.OK) {
            InfoWindow.make(response.message);
            return;
        }
        $input.value = isIncrementar ? ++this.ultimaCantidad : --this.ultimaCantidad;
        this.cart.actualizarCarrito();
    }

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
        /*actualizarCarrito();*/
               /* if (response.status !== HTTP_STATUS_CODES.OK) {
                    InfoWindow.make('No se pudo eliminar el producto del carrito');
                    return;
                }
                $carritoItem.remove();
                // Si se ha eliminado el último producto que había en el carrito, ocultar carrito y mostrar mensaje de añadir producto
                if ($('.carrito__item').length === 0) {
                    $carritoItems.addClass('hide');
                    $detallesCarrito.addClass('hide');
                    $noCart.removeClass('hide');
                }
                actualizarCarrito();
            })*/
    }

    getItem() {
        return this.cartItem;
    }
}