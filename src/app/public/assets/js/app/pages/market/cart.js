import {CartItem} from "./components/CartItem.js";
import {END_POINTS} from "../../api/end-points.js";
import {HTTP_STATUS_CODES} from "../../api/http-status-codes.js";
import {InfoWindow} from "../../components/InfoWindow.js";
import {Cart} from "./components/Cart.js";
import {ajax} from "../../api/ajax.js";
import {CARRITO_ITEM, V_CARRITO_CLIENTE} from "../../api/models.js";

const $aniadirCarrito = $('#aniadir-carrito');
let cart;

window.addEventListener('load', async () => {
    cart = await Cart.initialize(
        'img-carrito',
        'carrito__items',
        'detalles-carrito',
        'num-articulos-carrito',
        'precio-total__span',
        'no-cart'
    );
    aniadirCarrito();
})

/**
 * Añade al carrito un producto nuevo al hacer click sobre el botón de Añadir al carrito
 */
function aniadirCarrito() {
    $aniadirCarrito.on('click', async () => {
        if (!(await cart.tieneSesion())) {
            InfoWindow.make('Debes tener iniciada sesión para introducir artículos en el carrito');
            return;
        }

        const productoId = new URLSearchParams(window.location.search).get('id');
        const $carritoItem = $(`.carrito__item[item-id=${productoId}]`);
        let response;
        // Si existe el producto, añadir en cantidad +1
        if ($carritoItem.length) {
            const formData = new FormData();
            formData.append(V_CARRITO_CLIENTE.PRODUCTO_ID, productoId);
            response = await ajax(END_POINTS.CARRITO.INCREMENT_QUANTITY, 'POST', formData);
            if (response.status !== HTTP_STATUS_CODES.OK) {
                InfoWindow.make(response.message);
                return;
            }
            const { data: { cantidad } } = response;
            // Actualizar la cantidad de productos del CarritoItem en +1
            const $cantidadInput = $carritoItem.find('.cantidad');
            $cantidadInput.val(cantidad);
        } else {
            // Añadir producto al carrito en caso de que no exista
            const formData = new FormData();
            formData.append(CARRITO_ITEM.PRODUCTO_ID, productoId);
            response = await ajax(END_POINTS.CARRITO.ADD, 'POST', formData);
            if (response.status !== HTTP_STATUS_CODES.OK) {
                InfoWindow.make(response.message);
                return;
            }
            const { data: { carritoItem } } = response;
            cart.$carritoItems.append(
                new CartItem(cart, carritoItem).getItem()
            );
            cart.actualizarCarrito();
        }
        cart.$imgCarrito.addClass('shake-cart');
        cart.$imgCarrito.on('animationend', () => {
            cart.$imgCarrito.removeClass('shake-cart');
        })
        cart.$carritoItems.removeClass('hide');
        cart.$detallesCarrito.removeClass('hide');
        cart.$noCarritoItems.addClass('hide');
    })
}