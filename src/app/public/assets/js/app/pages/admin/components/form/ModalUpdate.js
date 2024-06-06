import {ModalType} from "./enums/ModalType.js";
import {Modal} from "./Modal.js";

export class ModalUpdate extends Modal {
    constructor(fields, afterAjaxSuccessCallback) {
        super(fields, 'actualizar', ModalType.UPDATE, afterAjaxSuccessCallback);
        super.modalType = ModalType.UPDATE;
        this.modal = $('#modal-actualizar');
    }

    /**
     * Al abrir una fila para actualizarla, coloca los campos de la fila en el modal de actualizar
     */
    openUpdateModal(e, openUpdateCallback) {
        const { target } = e;
        this.modal.modal('show');
        // Poner el atributo selected a la fila (tr) pulsada
        target.parentElement.setAttribute('selected', '');
        const tableColumns = target.parentElement.children;
        openUpdateCallback(this.fields, tableColumns);
    }
}