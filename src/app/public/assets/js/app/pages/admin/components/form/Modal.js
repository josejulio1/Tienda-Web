import {TypeField} from "./enums/TypeField.js";
import {PreviewImage} from "../../../../components/PreviewImage.js";
import {DataTypeField} from "./enums/DataTypeField.js";
import {HTTP_STATUS_CODES} from "../../../../api/http-status-codes.js";
import {$modalInfo, correctModal, incorrectModal} from "../modals/modal-info.js";
import {END_POINTS} from "../../../../api/end-points.js";
import {ModalType} from "./enums/ModalType.js";
import {ajax} from "../../../../api/ajax.js";
import {Validators} from "../../../../services/Validators.js";
import {PermissionCheckboxes} from "../../sections/role/models/PermissionCheckboxes.js";
import {Table} from "./Table.js";

/**
 * Clase que otorga funcionamiento a un modal del panel de administración. Actualmente existen dos, un modal
 * para crear y otro para actualizar
 * @author josejulio1
 * @version 1.0
 */
export class Modal {
    /**
     * Constructor de Modal.
     * @param fields {Array<Field>} Array de objetos Field que deben contener la información de cada input que haya en el modal
     * @param actionButtonId {string} ID del botón en el modal que inicia la opción de crear o actualizar una entidad, según el tipo de modal
     * @param modalType {string} Tipo de Modal que se quiere crear
     * @param afterAjaxSuccessCallback {function} Operación que se desea realizar después de crear o actualizar una entidad exitosamente
     */
    constructor(fields, actionButtonId, modalType, afterAjaxSuccessCallback) {
        this.fields = fields;
        this.actionButton = $(`#${actionButtonId}`);
        this.modalType = modalType;
        this.initialize(afterAjaxSuccessCallback);
    }

    /**
     * Inicializa todos los eventos y acciones necesarias para que comience a funcionar el modal
     * @param afterAjaxSuccessCallback {function} Operación que se desea realizar después de crear o actualizar una entidad exitosamente
     */
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
            // Adjuntar campos a JSON para mandarlos al backend
            const formData = new FormData();
            for (const field of fields) {
                // Si se ha adjuntado una imagen, no usar la imagen por defecto
                if (field.dataTypeField === DataTypeField.IMAGE && field.field.prop('files').length) {
                    formData.append(field.nameField, field.field.prop('files')[0]);
                    continue;
                }
                // En caso de que sean CheckBoxes del formulario de Roles, adjuntar de otra forma
                if (field instanceof PermissionCheckboxes) {
                    formData.append(field.nameField, `${field.getPermissions()}`);
                    continue;
                }
                formData.append(field.nameField, field.field.val());
            }
            const { modalType } = this;
            const response = await ajax(
                END_POINTS[this.table.enumClass.TABLE_NAME.toUpperCase()][modalType],
                'POST',
                formData
            );
            $modalInfo.modal('show');
            const $modalShow = $('.modal.show');
            if (response.status !== HTTP_STATUS_CODES.OK) {
                $modalShow.modal('hide');
                incorrectModal(response.message);
                return;
            }
            const { table } = this;
            if (modalType === ModalType.CREATE) {
                // En caso de crear, añadir la fila al frontend
                const data = afterAjaxSuccessCallback(this.fields, response.data);
                table.dataTable.row.add(
                    new table.rowPrototype.constructor(data, table.hasDeletePermissions).getRow()
                ).draw();
                if (table.hasUpdatePermissions) {
                    table.dataTable.on('click', 'tbody tr:last', e => table.modalUpdate.openUpdateModal(e, table.openUpdateCallback))
                }
                this.clearFields();
            } else {
                // Si es un modal de actualizar, pasar únicamente la tabla y los campos para la actualización de estos
                const numRow = table.dataTable.row($('tr[selected]')).index();
                afterAjaxSuccessCallback(table.dataTable, this.fields, numRow);
            }
            $modalShow.modal('hide');
            correctModal(response.message);
        })
    }

    /**
     * Valida todos los campos del modal antes de realizar una llamada al backend, y en caso de que alguna validación
     * no pase, no avanzará.
     * @returns {boolean} True si hay errores y false si no los hay
     */
    validate() {
        let errors;
        let { fields } = this;
        for (const field of fields) {
            if (field instanceof PermissionCheckboxes && !field.validatePermissions()) {
                field.showError(field.nameField)
                return true;
            }
            // En caso de ser inválido una imagen, validar de otra forma
            if (!(field instanceof PermissionCheckboxes) && Validators.validateField(field) || (field.dataTypeField === DataTypeField.IMAGE && !this.validateImage(field))) {
                if (field.dataTypeField === DataTypeField.IMAGE) {
                    field.field.closest('.img-container').addClass('is-invalid');
                } else {
                    field.field.addClass('is-invalid');
                }
                errors = true;
            }
        }
        return errors;
    }

    /**
     * Valida si un campo de tipo imagen es correcto o no. Se ha creado este método ya que las imágenes
     * se validan de otra forma.
     * @param field {Field} Campo de tipo imagen (DataTypeField.IMAGE)
     * @returns {boolean} True si se validó correctamente y false si no
     */
    validateImage(field) {
        if (field.typeField === TypeField.OPTIONAL) {
            return true;
        }
        // Si es obligatorio y no contiene imagen, no es válido
        return !!field.field.prop('files').length;
    }

    /**
     * Limpia todos los campos al terminar de realizar una petición al backend y si la petición se realizó
     * correctamente
     */
    clearFields() {
        const { fields } = this;
        for (const field of fields) {
            // En caso de que el campo sea de tipo imagen, que utiliza el componente PreviewImage, crear de nuevo
            if (field.dataTypeField === DataTypeField.IMAGE) {
                new PreviewImage('.img-container', field.fieldId);
                // Volver a coger el DOM del campo, ya que se pierde al crear el componente
                field.field = $(`#${field.fieldId}`);
            } else if (field.dataTypeField === DataTypeField.SELECT) {
                field.field.val(1);
            } else if (field instanceof PermissionCheckboxes) {
                field.clearCheckboxes();
            } else {
                field.field.val('');
            }
        }
    }

    /**
     * Establece un objeto de tipo Table. Es necesario que primero se cree el Table y después
     * se adjunte la dependencia al modal, ya que el modal necesita comunicarse con la tabla para cuando
     * se cree o actualice alguna fila, se lo comunique a la tabla y este cambie la vista
     * @param table {Table} Objeto de tipo Table como dependencia
     */
    setTable(table) {
        this.table = table;
    }
}