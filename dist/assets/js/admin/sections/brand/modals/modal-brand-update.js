import { updateRow } from "../../../../crud/crud.js";
import {MARCA} from "../../../../crud/models.js";
import { $tablaMarcas } from "../brand.js";
import { XSS_REGEX } from "../../../../helpers/regex.js";

export const $modalMarcaActualizar = $('#modal-marca-actualizar');

export const $campoMarcaActualizar = $('#nombre-marca-actualizar');
const $buttonActualizar = $('#actualizar-marca');

$buttonActualizar.on('click', e => {
    e.preventDefault();

    if (!$campoMarcaActualizar.val() || XSS_REGEX.test($campoMarcaActualizar.val())) {
        $campoMarcaActualizar.addClass('is-invalid');
        return
    }

    const fields = {
        [MARCA.MARCA]: $campoMarcaActualizar.val()
    };
    const filters = {
        [MARCA.ID]: $('tr[selected]').children()[0].textContent
    }

    updateRow(MARCA.TABLE_NAME, fields, filters, () => {
        const id = $tablaMarcas.row($('tr[selected]')).index();
        $tablaMarcas.cell({row: id, column: 1}).data($campoMarcaActualizar.val()).draw();
    });
})