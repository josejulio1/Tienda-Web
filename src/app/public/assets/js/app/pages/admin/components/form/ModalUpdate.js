import {ModalType} from "./enums/ModalType.js";
import {Modal} from "./Modal.js";

/**
 * Crea un Modal para actualizar filas
 * @author josejulio1
 * @version 1.0
 */
export class ModalUpdate extends Modal {
    /**
     * Constructor de ModalUpdate.
     * @param fields Array de objetos Field con la información necesaria para crear los campos del modal
     * @param afterAjaxSuccessCallback Callback que se desea realizar después de actualizar una entidad exitosamente
     */
    constructor(fields, afterAjaxSuccessCallback) {
        super(fields, 'actualizar', ModalType.UPDATE, afterAjaxSuccessCallback);
        super.modalType = ModalType.UPDATE;
        this.modal = $('#modal-actualizar');
    }

    /**
     * Al abrir una fila para actualizarla, coloca los campos de la fila en el modal de actualizar
     * @param e {MouseEvent} DOM que accionó el evento
     * @param openUpdateCallback {function} Callback que recibe dos parámetros, las filas introducidas en un modal, y las columnas de la tabla.
     * Se utiliza para definir cómo deben visualizarse en el modal de actualizar (ModalUpdate) los datos de la fila pulsada
     */
    openUpdateModal(e, openUpdateCallback) {
        const { target } = e;
        this.modal.modal('show');
        // Poner el atributo selected a la fila (tr) pulsada
        target.parentElement.setAttribute('selected', '');
        super.clearFields();
        const tableColumns = target.parentElement.children;
        openUpdateCallback(this.fields, tableColumns);
    }
}