import { $campoCategoriaActualizar, $modalCategoriaActualizar } from "./modals/modal-category-update.js";
import { CATEGORIA } from "../../../crud/models.js";
import { deleteRow, select } from "../../crud.js";
import { CategoryRow } from "../../models/row/CategoryRow.js";
import { PERMISSIONS } from "../../../api/permissions.js";

export let hasUpdatePermission, hasDeletePermission;
export let $tablaCategorias;

window.addEventListener('load', async () => {
    $tablaCategorias = $('#tabla-categorias').DataTable();
    const json = await select(CATEGORIA.TABLE_NAME, null, null, true);
    const { data: categories } = json;
    hasUpdatePermission = json['has-update-permission'] != PERMISSIONS.NO_PERMISSIONS;
    hasDeletePermission = json['has-delete-permission'] != PERMISSIONS.NO_PERMISSIONS;
    for (const category of categories) {
        $tablaCategorias.row.add(new CategoryRow(category.id, category.nombre, hasDeletePermission).getRow());
    }
    $tablaCategorias.draw();
    $tablaCategorias.tableName = CATEGORIA.TABLE_NAME;
    // Al pulsar una fila, abrir el modal de actualizar
    if (hasUpdatePermission) {
        $tablaCategorias.on('click', 'tbody tr', openUpdateCategory);
    }
    // Eliminar fila
    $tablaCategorias.on('click', '.eliminar-categoria', e => deleteRow(e, $tablaCategorias));
})

/**
 * Al abrir una fila para actualizarla, coloca los campos de la fila en el modal de actualizar
 */
export function openUpdateCategory() {
    $modalCategoriaActualizar.modal('show');
    $(this).attr('selected', '');
    const children = $(this).children();
    $campoCategoriaActualizar.val(children[1].textContent);
}