import { select } from "../crud/crud.js";
import { END_POINTS } from "../api/end-points.js";
import { HTTP_STATUS_CODES } from "../api/http-status-codes.js";
import { InfoWindow } from "../components/InfoWindow.js";
import { CARRITO_ITEM, PRODUCTO } from "../crud/models.js";
import { TYPE_FILTERS } from "../crud/utils.js";
import { CartItem } from "./models/CartItem.js";

const $imgCarrito = $('#img-carrito');
const $carritoItems = $('.carrito__items');
const $detallesCarrito = $('#detalles-carrito');
const $numArticulosCarrito = $('#num-articulos-carrito');
const $precioTotalSpan = $('.precio-total__span');
const $noCart = $('.no-cart');
const $aniadirCarrito = $('#aniadir-carrito');

$('.carrito__item #eliminar-item').on('click', e => {
    eliminarItem(e);
})

$aniadirCarrito.on('click', async () => {
    // Comprobar si tiene iniciada sesión para añadir al carrito
    const hasSession = await fetch(END_POINTS.MARKET.HAS_CUSTOMER_SESSION, {
        method: 'GET'
    })
    .then(response => {
        if (response.status !== HTTP_STATUS_CODES.OK) {
            InfoWindow.make('Debes tener una cuenta para poder añadir un producto al carrito');
            return false;
        }
        return true;
    })

    if (!hasSession) {
        return;
    }

    const productoId = new URLSearchParams(window.location.search).get('id');
    // Si existe el producto, añadir en cantidad +1
    const $carritoItem = $(`.carrito__item[item-id=${productoId}]`);
    $imgCarrito.addClass('shake-cart');
    $imgCarrito.on('animationend', () => {
        $imgCarrito.removeClass('shake-cart');
    })
    if ($carritoItem.length) {
        const $itemPrecio = $carritoItem.find('.item__precio');
        const nuevoPrecio = parseInt($itemPrecio.html()) + 1;
        $itemPrecio.html(nuevoPrecio);
        const data = {
            tableName: CARRITO_ITEM.TABLE_NAME,
            fields: {
                [CARRITO_ITEM.CANTIDAD]: nuevoPrecio
            },
            filters: {
                [CARRITO_ITEM.PRODUCTO_ID]: productoId
            }
        }
        fetch(END_POINTS.UPDATE_ROW, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.status !== HTTP_STATUS_CODES.OK) {
                InfoWindow.make('No se pudo añadir el producto al carrito');
                return;
            }
            $carritoItems.removeClass('hide');
            $detallesCarrito.removeClass('hide');
            $noCart.addClass('hide');
            actualizarCarrito();
        })
        return;
    }
    
    // Añadir producto al carrito en caso de que no exista
    const fd = new FormData();
    fd.append(CARRITO_ITEM.PRODUCTO_ID, productoId);
    fd.append(CARRITO_ITEM.CANTIDAD, 1);
    fetch(END_POINTS.MARKET.CART.ADD, {
        method: 'POST',
        body: fd
    })
    .then(async response => {
        if (response.status !== HTTP_STATUS_CODES.OK) {
            InfoWindow.make('No se pudo añadir el producto al carrito');
            return;
        }
        const jsonProducto = await select(PRODUCTO.TABLE_NAME, [
            PRODUCTO.NOMBRE,
            PRODUCTO.PRECIO,
            PRODUCTO.RUTA_IMAGEN
        ], {
            [TYPE_FILTERS.EQUALS]: {
                [PRODUCTO.ID]: productoId
            }
        })
    
        const productoInfo = jsonProducto[0];
        $carritoItems.append(
            new CartItem(
                productoId,
                productoInfo[PRODUCTO.RUTA_IMAGEN],
                productoInfo[PRODUCTO.NOMBRE],
                productoInfo[PRODUCTO.PRECIO]
            ).getItem()
        )
        $carritoItems.removeClass('hide');
        $detallesCarrito.removeClass('hide');
        $noCart.addClass('hide');
        actualizarCarrito();
    })
})

function actualizarCarrito() {
    const preciosProductos = [];
    const $carritoItems = $('.carrito__item');
    $carritoItems.each(function() {
        preciosProductos.push(parseFloat($(this).find('.precio__producto').html()) * $(this).find('.item__precio').html());
    })
    $precioTotalSpan.html(Math.round((preciosProductos.reduce((a, b) => a + b, 0))  * 100) / 100);
    // Contar elemento del carrito
    $numArticulosCarrito.html($carritoItems.length);
}

export function eliminarItem(e) {
    const { target } = e;
    const $carritoItem = target.closest('.carrito__item');
    const itemId = parseInt($carritoItem.getAttribute('item-id'));
    if (typeof itemId != 'number') {
        return;
    }

    fetch(`${END_POINTS.MARKET.CART.DELETE}?${CARRITO_ITEM.PRODUCTO_ID}=${itemId}`, {
        method: 'DELETE',
    })
    .then(response => {
        if (response.status !== HTTP_STATUS_CODES.OK) {
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
    })
}