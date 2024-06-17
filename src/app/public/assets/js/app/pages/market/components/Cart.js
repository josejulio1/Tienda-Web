import {ajax} from "../../../api/ajax.js";
import {END_POINTS} from "../../../api/end-points.js";
import {HTTP_STATUS_CODES} from "../../../api/http-status-codes.js";
import {InfoWindow} from "../../../components/InfoWindow.js";
import {CartItem} from "./CartItem.js";

/**
 * Clase que crea el comportamiento del carrito de un cliente
 * @author josejulio1
 * @version 1.0
 */
export class Cart {
    /**
     * Constructor de Cart. Utilice el método estático initialize para crear el carrito.
     * @param imgCarritoId {string} ID donde se encuentra el DOM del carrito en la página
     * @param carritoItemsId {string} ID del DOM donde se almacenarán los artículos del carrito
     * @param detallesCarritoId {string} ID del DOM donde se guardarán los detalles del carrito como el precio o el botón para pagar
     * @param numArticulosCarritoId {string} ID del DOM donde se guardará el número de artículos en el carrito
     * @param precioTotalSpanId {string} ID del DOM donde se guardará el precio total de los artículos del carrito
     * @param noCarritoItemsId {string} ID del DOM del contenedor que en caso de que no existan artículos en el carrito, se mostrará este contenedor
     */
    constructor(imgCarritoId, carritoItemsId, detallesCarritoId, numArticulosCarritoId, precioTotalSpanId, noCarritoItemsId) {
        this.$imgCarrito = $(`#${imgCarritoId}`);
        this.$carritoItems = $(`#${carritoItemsId}`);
        this.$detallesCarrito = $(`#${detallesCarritoId}`);
        this.$numArticulosCarrito = $(`#${numArticulosCarritoId}`);
        this.$precioTotalSpan = $(`#${precioTotalSpanId}`);
        this.$noCarritoItems = $(`#${noCarritoItemsId}`);
    }

    /**
     * Inicializa el carrito de manera asíncrona.
     * @param imgCarritoId {string} ID donde se encuentra el DOM del carrito en la página
     * @param carritoItemsId {string} ID del DOM donde se almacenarán los artículos del carrito
     * @param detallesCarritoId {string} ID del DOM donde se guardarán los detalles del carrito como el precio o el botón para pagar
     * @param numArticulosCarritoId {string} ID del DOM donde se guardará el número de artículos en el carrito
     * @param precioTotalSpanId {string} ID del DOM donde se guardará el precio total de los artículos del carrito
     * @param noCarritoItemsId {string} ID del DOM del contenedor que en caso de que no existan artículos en el carrito, se mostrará este contenedor
     * @returns {Promise<Cart>} Devuelve una promesa con el objeto del carrito, que debe añadirse un await de manera asíncrona para que
     * carguen todos los artículos que tiene el carrito realizando una llamada al backend
     */
    static async initialize(imgCarritoId, carritoItemsId, detallesCarritoId, numArticulosCarritoId, precioTotalSpanId, noCarritoItemsId) {
        const cart = new Cart(imgCarritoId, carritoItemsId, detallesCarritoId, numArticulosCarritoId, precioTotalSpanId, noCarritoItemsId);
        await cart.cargarCarrito();
        return cart;
    }

    /**
     * Carga la funcionalidad del carrito.
     * @returns {Promise<void>} Devuelve una promesa que no es necesario recogerla
     */
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

    /**
     * Actualiza la información del carrito. Si el carrito no tiene productos, se mostrará el contenedor de noCarritoItems
     */
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

    /**
     * Actualiza el precio total del carrito, recalculando el precio y la cantidad de cada producto
     */
    actualizarPrecioTotal() {
        const preciosProductos = [];
        const carritoItems = this.$carritoItems.children();
        carritoItems.each(function() {
            preciosProductos.push(parseFloat($(this).find('.precio__producto').html()) * $(this).find('.cantidad').val());
        })
        this.$precioTotalSpan.html(Math.round((preciosProductos.reduce((a, b) => a + b, 0))  * 100) / 100);
    }

    /**
     * Comprueba que un cliente tenga sesión iniciada, para que en caso de que añada un producto al carrito,
     * si no tiene sesión, que le aparezca un mensaje de error.
     * @returns {Promise<unknown>} Devuelve una promesa que no es necesario recogerla
     */
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