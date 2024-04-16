import { $campoMarcaActualizar, $modalMarcaActualizar } from "./modals/modal-brand-update.js";
import {MARCA} from "../../../crud/models.js";
import { deleteRow, select } from "../../../crud/crud.js";
import { PERMISSIONS } from "../../../api/permissions.js";
import {BrandRow} from "../../models/row/BrandRow.js";

export let hasUpdatePermission, hasDeletePermission;
export let $tablaMarcas;

window.addEventListener('load', async () => {
    $tablaMarcas = $('#tabla-marcas').DataTable();
    const json = await select(MARCA.TABLE_NAME, null, null, true);
    const { data: brands } = json;
    hasUpdatePermission = json['has-update-permission'] !== PERMISSIONS.NO_PERMISSIONS;
    hasDeletePermission = json['has-delete-permission'] !== PERMISSIONS.NO_PERMISSIONS;
    for (const brand of brands) {
        $tablaMarcas.row.add(
            new BrandRow(
                brand[MARCA.ID],
                brand[MARCA.MARCA],
                hasDeletePermission
            ).getRow());
    }
    $tablaMarcas.draw();
    $tablaMarcas.tableName = MARCA.TABLE_NAME;
    // Al pulsar una fila, abrir el modal de actualizar
    if (hasUpdatePermission) {
        $tablaMarcas.on('click', 'tbody tr', openUpdateBrand);
    }
    // Eliminar fila
    $tablaMarcas.on('click', '.eliminar-marca', e => deleteRow(e, $tablaMarcas));
})

/**
 * Al abrir una fila para actualizarla, coloca los campos de la fila en el modal de actualizar
 */
export function openUpdateBrand() {
    $modalMarcaActualizar.modal('show');
    $(this).attr('selected', '');
    const children = $(this).children();
    $campoMarcaActualizar.val(children[1].textContent);
}