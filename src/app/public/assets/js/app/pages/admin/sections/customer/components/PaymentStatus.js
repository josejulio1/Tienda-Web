import {ajax} from "../../../../../api/ajax.js";
import {END_POINTS} from "../../../../../api/end-points.js";
import {HTTP_STATUS_CODES} from "../../../../../api/http-status-codes.js";
import {InfoWindow} from "../../../../../components/InfoWindow.js";
import {ESTADO_PAGO} from "../../../../../api/models.js";

export class PaymentStatus {
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

    static async initialize(selectedPaymentStatus) {
        return new PaymentStatus(selectedPaymentStatus, await PaymentStatus.getAllPaymentStatus()).getPaymentStatusSelect().outerHTML;
    }

    static async getAllPaymentStatus() {
        const response = await ajax(END_POINTS.ESTADO_PAGO.GET_ALL, 'GET');
        if (response.status !== HTTP_STATUS_CODES.OK) {
            InfoWindow.make(response.message);
            return;
        }
        return response.data.estadosPago;
    }

    getPaymentStatusSelect() {
        return this.paymentStatusSelect;
    }
}