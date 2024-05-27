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
        target.parentElement.setAttribute('selected', '');
        const tableColumns = target.parentElement.children;
        openUpdateCallback(this.fields, tableColumns);
        /*const fields = super.getFields().filter(field => field.getNumColumn() >= 0);
        for (const field of fields) {
            if (field.getDataTypeField() === DataTypeField.OPTION_TAG) {
                // Si el campo es una etiqueta option, buscar el texto de la tabla en los option del select
                field.getField().each(function() {
                    if ($(this).text() === children[field.getNumColumn()].textContent) {
                        $(this).attr('selected', '');
                        return;
                    }
                })
            } else {
                field.getField().val(children[field.getNumColumn()].textContent);
            }
        }*/
    }
}