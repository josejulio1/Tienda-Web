import {TypeField} from "./enums/TypeField.js";
import {PreviewImage} from "../../../../components/PreviewImage.js";
import {DataTypeField} from "./enums/DataTypeField.js";
import {HTTP_STATUS_CODES} from "../../../../api/http-status-codes.js";
import {$modalInfo, correctModal, incorrectModal} from "../modals/modal-info.js";
import {END_POINTS} from "../../../../api/end-points.js";
import {ModalType} from "./enums/ModalType.js";
import {ajax} from "../../../../api/ajax.js";
import {Validators} from "../../../../controllers/services/Validators.js";

export class Modal {
    constructor(fields, actionButtonId, modalType, afterAjaxSuccessCallback) {
        this.fields = fields;
        this.actionButton = $(`#${actionButtonId}`);
        this.modalType = modalType;
        this.initialize(afterAjaxSuccessCallback);
    }

    initialize(afterAjaxSuccessCallback) {
        // Si el campo es de tipo imagen, crear un componente PreviewImage
        const fields = this.fields;
        for (const field of fields) {
            if (field.dataTypeField === DataTypeField.IMAGE) {
                new PreviewImage('.img-container', field.fieldId);
                // Volver a coger el DOM del campo, ya que se pierde al crear el componente
                field.field = $(`#${field.fieldId}`);
            }
        }

        this.actionButton.on('click', async e => {
            e.preventDefault();
            // En caso de que existan errores, no continuar
            if (this.validate()) {
                return;
            }
            const Entity = {};
            for (const field of fields) {
                // Si se ha adjuntado una imagen, no usar la imagen por defecto
                if (field.dataTypeField === DataTypeField.IMAGE && field.typeField === TypeField.OPTIONAL && field.field.prop('files')[0]) {
                    Entity[field.nameField] = field.field.prop('files')[0];
                }
                Entity[field.nameField] = field.field.val();
            }
            const { modalType } = this;
            const response = await ajax(
                END_POINTS[this.form.enumClass.TABLE_NAME.toUpperCase()][modalType],
                modalType === ModalType.CREATE ? 'POST' : 'PUT',
                Entity
            );
            $modalInfo.modal('show');
            if (response.status !== HTTP_STATUS_CODES.OK) {
                $('.modal.show').modal('hide');
                incorrectModal(response.message);
                return;
            }
            const { form } = this;
            if (modalType === ModalType.CREATE) {
                // En caso de crear, añadir la fila al frontend
                const data = afterAjaxSuccessCallback(fields, response.data);
                form.dataTable.row.add(
                    new form.rowPrototype.constructor(data, form.hasDeletePermissions).getRow()
                ).draw();
                if (form.hasUpdatePermissions) {
                    form.dataTable.on('click', 'tbody tr:last', e => form.modalUpdate.openUpdateModal(e, form.openUpdateCallback))
                }
                this.clearFields();
            } else {
                // Si es un modal de actualizar, pasar únicamente la tabla y los campos para la actualización de estos
                afterAjaxSuccessCallback(form.dataTable, this.fields);
            }
            $('.modal.show').modal('hide');
            correctModal(response.message);
        })
    }

    validate() {
        let errors;
        const fields = this.fields;
        for (const field of fields) {
            if (Validators.validateField(field) || (field.dataTypeField === DataTypeField.IMAGE && !this.validateImage(field))) {
                // En caso de ser inválido una imagen, validar de otra forma
                if (field.dataTypeField === DataTypeField.IMAGE) {
                    $(`label[for=${field.fieldId}]`).addClass('is-invalid');
                } else {
                    field.field.addClass('is-invalid');
                }
                errors = true;
            }
        }
        return errors;
    }

    validateImage(field) {
        if (field.typeField === TypeField.OPTIONAL) {
            return true;
        }
        // Si es obligatorio y no contiene imagen, no es válido
        return field.field.prop('files')[0];
    }

    clearFields() {
        const { fields } = this;
        for (const field of fields) {
            // En caso de que el campo sea de tipo imagen, que utiliza el componente PreviewImage, crear de nuevo
            if (field.dataTypeField === DataTypeField.IMAGE) {
                new PreviewImage('.img-container', field.fieldId);
            } else {
                field.field.val('');
            }
        }
    }

    setForm(form) {
        this.form = form;
    }
}