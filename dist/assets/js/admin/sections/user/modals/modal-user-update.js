import { updateRow } from "../../../crud.js";
import { USUARIO } from "../../../models/models.js";
import { $tablaUsuarios } from "../user.js";

export const $modalUsuarioActualizar = $('#modal-usuario-actualizar');

export const $campoUsuarioActualizar = $('#nombre-usuario-actualizar');
export const $campoCorreoActualizar = $('#correo-usuario-actualizar');
const $campoRolUsuarioActualizar = $('#rol-usuario-actualizar');
export const $campoRolUsuarioActualizarOptions = $('#rol-usuario-actualizar option');
const $buttonActualizar = $('#actualizar-usuario');

$modalUsuarioActualizar.on('hide.bs.modal', () => {
    $('.lista-item-usuario[selected]').removeAttr('selected');
})

// Regex
/* const emailRegex = new RegExp(/^[a-zA-Z]{1,127}@[a-zA-Z]{1,124}\.[a-zA-Z]{3,}$/); */

// Events
/* $campoUsuarioActualizar.on('focusout', removeErrors); */
/* $campoCorreoActualizar.on('focusout', e => {
    if (emailRegex.test($campoCorreoActualizar.val())) {
        removeErrors(e);
    }
}); */

$buttonActualizar.on('click', e => {
    e.preventDefault();

    let hayErrores = false;
    if (!$campoUsuarioActualizar.val()) {
        $campoUsuarioActualizar.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoRolUsuarioActualizar.val()) {
        $campoRolUsuarioActualizar.addClass('is-invalid');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }

    const fields = {
        [USUARIO.USUARIO]: $campoUsuarioActualizar.val(),
        [USUARIO.ROL_ID]: $campoRolUsuarioActualizar.val()
    };
    const filters = {
        [USUARIO.CORREO]: $campoCorreoActualizar.val()
    }

    updateRow(USUARIO.TABLE_NAME, fields, filters, () => {
        const id = $tablaUsuarios.row($('tr[selected]')).index();
        $tablaUsuarios.cell({row: id, column: 1}).data($campoUsuarioActualizar.val()).draw();
        $tablaUsuarios.cell({row: id, column: 3}).data($('#rol-usuario-actualizar option:selected').text()).draw();
    });
})