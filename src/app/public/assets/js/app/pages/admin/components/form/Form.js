import {ajax} from "../../../../api/ajax.js";
import {PERMISSIONS} from "../../permissions/permissions.js";
import {waitResolveModalChoice} from "../modals/modal-choice.js";
import {END_POINTS} from "../../../../api/end-points.js";
import {$modalInfo, correctModal, incorrectModal} from "../modals/modal-info.js";
import {HTTP_STATUS_CODES} from "../../../../api/http-status-codes.js";

export class Form {
    constructor(enumClass, rowPrototype, hasUpdatePermissions, hasDeletePermissions, modalCreate, modalUpdate, openUpdateCallback) {
        this.dataTable = $('#tabla').DataTable();
        this.enumClass = enumClass;
        this.rowPrototype = rowPrototype;
        this.modalCreate = modalCreate;
        this.modalUpdate = modalUpdate;
        this.openUpdateCallback = openUpdateCallback;
        this.hasUpdatePermissions = hasUpdatePermissions;
        this.hasDeletePermissions = hasDeletePermissions;
        if (hasUpdatePermissions) {
            this.dataTable.on('click', 'tbody tr', e => this.modalUpdate.openUpdateModal(e, openUpdateCallback));
        }
        this.dataTable.on('click', '.eliminar', e => this.deleteRow(e))
    }

    static async initialize(getAllEndPoint, enumClass, rowPrototype, modalCreate, modalUpdate, openUpdateCallback) {
        const response = await ajax(getAllEndPoint, 'GET');
        let { data: { entidades, hasUpdatePermissions, hasDeletePermissions } } = response;
        hasUpdatePermissions = hasUpdatePermissions !== PERMISSIONS.NO_PERMISSIONS;
        hasDeletePermissions = hasDeletePermissions !== PERMISSIONS.NO_PERMISSIONS;
        const form = new Form(enumClass, rowPrototype, hasUpdatePermissions, hasDeletePermissions, modalCreate, modalUpdate, openUpdateCallback);
        for (const entidad of entidades) {
            form.dataTable.row.add(
                new rowPrototype.constructor(entidad, hasDeletePermissions).getRow()
            );
        }
        form.dataTable.draw();
        return form;
    }

    async deleteRow(e) {
        e.stopPropagation();
        const selectedId = e.target.getAttribute('value');
        const modalChoiceResultOk = await waitResolveModalChoice();
        if (!modalChoiceResultOk) {
            return;
        }
        const response = await ajax(`${END_POINTS[this.enumClass.TABLE_NAME.toUpperCase()].DELETE}?id=${selectedId}`, 'DELETE');
        $modalInfo.modal('show');
        if (response.status !== HTTP_STATUS_CODES.OK) {
            $('.modal.show').modal('hide');
            incorrectModal(response.message);
            return;
        }
        $('.modal.show').modal('hide');
        this.dataTable.row(e.target.closest('tr')).remove().draw();
        correctModal(response.message);
    }
}