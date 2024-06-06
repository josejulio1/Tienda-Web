import {ajax} from "../../../api/ajax.js";
import {END_POINTS} from "../../../api/end-points.js";
import {HTTP_STATUS_CODES} from "../../../api/http-status-codes.js";
import {InfoWindow} from "../../../components/InfoWindow.js";
import {CartItem} from "./CartItem.js";

export class Cart {
    constructor(imgCarritoId, carritoItemsId, detallesCarritoId, numArticulosCarritoId, precioTotalSpanId, noCarritoItemsId) {
        this.$imgCarrito = $(`#${imgCarritoId}`);
        this.$carritoItems = $(`#${carritoItemsId}`);
        this.$detallesCarrito = $(`#${detallesCarritoId}`);
        this.$numArticulosCarrito = $(`#${numArticulosCarritoId}`);
        this.$precioTotalSpan = $(`#${precioTotalSpanId}`);
        this.$noCarritoItems = $(`#${noCarritoItemsId}`);
        this.cargarCarrito();
    }

    async cargarCarrito() {
        if (!(await this.tieneSesion())) {
            return;
        }

        const response = await ajax(END_POINTS.CARRITO.GET_ALL, 'GET');
        if (response.status !== HTTP_STATUS_CODES.OK) {
            InfoWindow.make(response.message);
            return;
        }
        let { data: { carritoItems } } = response;
        if (!carritoItems.length) {
            this.$noCarritoItems.removeClass('hide');
        }

        for (const carritoItem of carritoItems) {
            this.$carritoItems.append(
                new CartItem(this, carritoItem).getItem()
            );
        }
        this.$numArticulosCarrito.html(this.$carritoItems.children().length);
        this.actualizarPrecioTotal();
    }

    actualizarCarrito() {
        this.actualizarPrecioTotal();
        const children = this.$carritoItems.children();
        // Contar elemento del carrito
        this.$numArticulosCarrito.html(children.length);
        // Si se ha eliminado el último producto que había en el carrito, ocultar carrito y mostrar mensaje de añadir producto
        if (children.length === 0) {
            this.$carritoItems.addClass('hide');
            this.$detallesCarrito.addClass('hide');
            this.$noCarritoItems.removeClass('hide');
        }
    }

    actualizarPrecioTotal() {
        const preciosProductos = [];
        const carritoItems = this.$carritoItems.children();
        carritoItems.each(function() {
            preciosProductos.push(parseFloat($(this).find('.precio__producto').html()) * $(this).find('.cantidad').val());
        })
        this.$precioTotalSpan.html(Math.round((preciosProductos.reduce((a, b) => a + b, 0))  * 100) / 100);
    }

    async tieneSesion() {
        return new Promise(async resolve => {
            let response = await ajax(END_POINTS.HAS_CUSTOMER_SESSION, 'GET');
            if (response.status !== HTTP_STATUS_CODES.OK) {
                resolve(false);
            }
            const { data: { hasSession } } = response;
            resolve(hasSession);
        })
    }
}