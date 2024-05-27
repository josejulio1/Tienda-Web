import {Modal} from "./Modal.js";
import {ModalType} from "./enums/ModalType.js";

export class ModalCreate extends Modal {
    constructor(fields, afterAjaxSuccessCallback) {
        super(fields, 'crear', ModalType.CREATE, afterAjaxSuccessCallback);
    }
}