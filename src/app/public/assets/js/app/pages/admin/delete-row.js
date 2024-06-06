import {waitResolveModalChoice} from "./components/modals/modal-choice.js";
import {ajax} from "../../api/ajax.js";
import {$modalInfo, correctModal, incorrectModal} from "./components/modals/modal-info.js";
import {HTTP_STATUS_CODES} from "../../api/http-status-codes.js";

export async function deleteRow(e, dataTable, endPoint) {
    e.stopPropagation();
    const selectedId = e.target.getAttribute('value');
    const modalChoiceResultOk = await waitResolveModalChoice();
    if (!modalChoiceResultOk) {
        return;
    }
    const response = await ajax(`${endPoint}?id=${selectedId}`, 'DELETE');
    $modalInfo.modal('show');
    if (response.status !== HTTP_STATUS_CODES.OK) {
        $('.modal.show').modal('hide');
        incorrectModal(response.message);
        return;
    }
    $('.modal.show').modal('hide');
    dataTable.row(e.target.closest('tr')).remove().draw();
    correctModal(response.message);
}