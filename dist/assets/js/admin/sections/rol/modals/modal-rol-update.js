import { updateRow } from "../../../crud.js";
import { ROL } from "../../../models/models.js";
import { $tablaRoles } from "../rol.js";

export const $modalRolActualizar = $('#modal-rol-actualizar');

export const $campoNombreRolActualizar = $('#nombre-rol-actualizar');
export const $campoColorActualizar = $('#color-rol-actualizar');
const $buttonActualizar = $('#actualizar-rol');

$buttonActualizar.on('click', e => {
    e.preventDefault();

    let hayErrores = false;
    if (!$campoNombreRolActualizar.val()) {
        $campoNombreRolActualizar.addClass('is-invalid');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }

    const fields = {
        [ROL.NOMBRE]: $campoNombreRolActualizar.val(),
        [ROL.COLOR]: $campoColorActualizar.val().substring(1)
    }
    const filters = {
        [ROL.ID]: $('tr[selected]').children()[0].textContent
    }

    updateRow(ROL.TABLE_NAME, fields, filters, () => {
        const id = $tablaRoles.row($('tr[selected]')).index();
        $tablaRoles.cell({row: id, column: 1}).data($campoNombreRolActualizar.val());
        const spanColor = document.createElement('span');
        spanColor.style.backgroundColor = $campoColorActualizar.val();
        $tablaRoles.cell({row: id, column: 2}).data(spanColor.outerHTML).draw();
    });
})