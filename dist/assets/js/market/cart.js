import { END_POINTS } from "../api/end-points.js";
import { HTTP_STATUS_CODES } from "../api/http-status-codes.js";
import { ErrorWindow } from "../components/ErrorWindow.js";
import { CARRITO_ITEM } from "../crud/models.js";

const $numArticulosCarrito = $('#num-articulos-carrito');
const $precioTotalSpan = $('.precio-total__span');
const $aniadirCarrito = $('#aniadir-carrito');

$('.carrito__item #eliminar-item').on('click', function() {
    const $carritoItem = $(this).closest('.carrito__item');
    const itemId = parseInt($carritoItem.attr('item-id'));
    if (typeof itemId != 'number') {
        return;
    }

    fetch(`${END_POINTS.MARKET.CART.DELETE}?${CARRITO_ITEM.PRODUCTO_ID}=${itemId}`, {
        method: 'DELETE',
    })
    .then(response => {
        if (response.status != HTTP_STATUS_CODES.OK) {
            ErrorWindow.make('No se pudo eliminar el producto del carrito');
            return;
        }
        $carritoItem.remove();
        actualizarCarrito();
    })
})

$aniadirCarrito.on('click', () => {
    // Comprobar si tiene iniciada sesión para añadir al carrito
    fetch(END_POINTS.HAS_SESSION, {
        method: 'GET'
    })
    .then(response => {
        if (response.status != HTTP_STATUS_CODES.OK) {
            ErrorWindow.make('Debes tener una cuenta para poder añadir un producto al carrito');
            return;
        }

    })
})

function actualizarCarrito() {
    const preciosProductos = [];
    $('.carrito__item').each(function() {
        preciosProductos.push(Math.round(parseFloat($(this).find('.precio__producto').html()) * $(this).find('.item__precio').html() * 100) / 100);
    })
    $precioTotalSpan.html(preciosProductos.reduce((a, b) => a + b, 0));
    // Contar elemento del carrito
    $numArticulosCarrito.html($('.carrito__item').length);
}