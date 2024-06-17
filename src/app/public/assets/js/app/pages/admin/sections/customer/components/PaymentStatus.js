import {ajax} from "../../../../../api/ajax.js";
import {END_POINTS} from "../../../../../api/end-points.js";
import {HTTP_STATUS_CODES} from "../../../../../api/http-status-codes.js";
import {InfoWindow} from "../../../../../components/InfoWindow.js";
import {ESTADO_PAGO} from "../../../../../api/models.js";

/**
 * Crea un elemento DOM (select) que almacena el conjunto de métodos de pagos existentes en la base de datos
 * relacionándolos con un pedido
 * @author josejulio1
 * @version 1.0
 */
export class PaymentStatus {
    /**
     * Constructor de PaymentStatus. Utilizar el método estático initialize de manera asíncrona con await para utilizar
     * @param selectedPaymentStatus {string} Estado del pago seleccionado en el pedido realizado
     * @param paymentsStatus Estados de pago existentes en la base de datos
     */
    constructor(selectedPaymentStatus, paymentsStatus) {
        this.paymentStatusSelect = document.createElement('select');
        this.paymentStatusSelect.classList.add('estado-pago-select');

        const documentFragment = document.createDocumentFragment();
        let optionPaymentStatus;
        for (const paymentStatus of paymentsStatus) {
            optionPaymentStatus = document.createElement('option');
            optionPaymentStatus.value = paymentStatus[ESTADO_PAGO.ID];
            optionPaymentStatus.textContent = paymentStatus[ESTADO_PAGO.NOMBRE];
            if (paymentStatus[ESTADO_PAGO.NOMBRE] === selectedPaymentStatus) {
                optionPaymentStatus.setAttribute('selected', '');
            }
            documentFragment.appendChild(optionPaymentStatus);
        }
        this.paymentStatusSelect.appendChild(documentFragment);
    }

    /**
     * Inicializa un objeto de PaymentStatus. Realiza una operación asíncrona consultando los estados de pago existentes
     * en la base de datos.
     * @param selectedPaymentStatus {string} Estado de pago seleccionado en el pedido
     * @returns {Promise<string>} Devuelve una promesa con el DOM del select con los estados de pago disponibles
     */
    static async initialize(selectedPaymentStatus) {
        return new PaymentStatus(selectedPaymentStatus, await PaymentStatus.getAllPaymentStatus()).getPaymentStatusSelect().outerHTML;
    }

    /**
     * Obtiene todos los estados de pago existentes en la base de datos
     * @returns {Promise<*>} Devuelve una promesa que no es necesario recogerla
     */
    static async getAllPaymentStatus() {
        const response = await ajax(END_POINTS.ESTADO_PAGO.GET_ALL, 'GET');
        if (response.status !== HTTP_STATUS_CODES.OK) {
            InfoWindow.make(response.message);
            return;
        }
        return response.data.estadosPago;
    }

    /**
     * Devuelve el DOM del select con los estados de pago
     * @returns {HTMLSelectElement} DOM del select con estados de pago
     */
    getPaymentStatusSelect() {
        return this.paymentStatusSelect;
    }
}