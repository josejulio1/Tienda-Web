import { waitResolveModalChoice } from "../admin/components/modal-choice.js";
import { $modalInfo, correctModal, incorrectModal } from "../admin/components/modal-info.js";
import { ERROR_MESSAGES } from "../api/error-messages.js";
import { END_POINTS } from "../api/end-points.js";
import { HTTP_STATUS_CODES } from "../api/http-status-codes.js";

export function insert(endPoint, formData, postOperationCb) {
    fetch(endPoint, {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        $modalInfo.modal('show');
        const { status } = data;
        if (status !== HTTP_STATUS_CODES.OK) {
            $('.modal.show').modal('hide');
            incorrectModal(ERROR_MESSAGES[status]);
            return;
        }
        postOperationCb(data);
        $('.modal.show').modal('hide');
        correctModal('Registro creado correctamente');
    })
}

/**
 *
 * @param {string} tableName Nombre de la tabla a la que consultar datos (usar constantes de /assets/js/admin/models)
 * @param fields
 * @param filters
 * @param {boolean} selectPermissions Si se desea consultar también los permisos de actualizar y eliminar
 * @returns
 */
export async function select(tableName, fields = null, filters = null, selectPermissions = false) {
    return new Promise((resolve, reject) => {
        const data = {
            'table-name': tableName,
            fields: fields,
            filters: filters,
            'select-permissions': selectPermissions
        }
        fetch(END_POINTS.SELECT_ROWS, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(async response => {
            const { status } = response;
            if (status !== HTTP_STATUS_CODES.OK) {
                reject(status);
            }
            resolve(await response.json())
        })
    })
}

export function updateRow(tableName, fields, filters, postOperationCb) { 
    const data = {
        tableName: tableName,
        fields: fields,
        filters: filters
    }
    fetch(END_POINTS.UPDATE_ROW, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        $modalInfo.modal('show');
        if (response.status != HTTP_STATUS_CODES.OK) {
            $('.modal.show').modal('hide');
            incorrectModal(ERROR_MESSAGES[response.status]);
            return;
        }
        postOperationCb();
        $('.modal.show').modal('hide');
        correctModal('El registro se actualizó correctamente');
    })
}

export async function deleteRow(e, $table) {
    e.stopPropagation();
    const selectedId = e.target.getAttribute('value');
    const modalChoiceResultOk = await waitResolveModalChoice();
    if (!modalChoiceResultOk) {
        return;
    }
    fetch(`${END_POINTS.DELETE_ROW}?table-name=${$table.tableName}&id=${selectedId}`, {
        method: 'DELETE'
    })
    .then(response => {
        $modalInfo.modal('show');
        const { status } = response;
        if (status != HTTP_STATUS_CODES.OK) {
            incorrectModal(ERROR_MESSAGES[status]);
            return;
        }
        $table.row(e.target.closest('tr')).remove().draw();
        correctModal('El registro se eliminó correctamente');
    })
}