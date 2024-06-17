import {Modal} from "./Modal.js";
import {ModalType} from "./enums/ModalType.js";

/**
 * Crea un Modal para crear filas
 * @author josejulio1
 * @version 1.0
 */
export class ModalCreate extends Modal {
    /**
     * Constructor de ModalCreate.
     * @param fields {Array<Field>} Array de objetos Field con la información necesaria para crear los campos del modal
     * @param afterAjaxSuccessCallback {function} Operación que se desea realizar después de crear una entidad exitosamente
     */
    constructor(fields, afterAjaxSuccessCallback) {
        super(fields, 'crear', ModalType.CREATE, afterAjaxSuccessCallback);
    }
}