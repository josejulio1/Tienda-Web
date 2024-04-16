import { XSS_REGEX } from "../../../../helpers/regex.js";
import { updateRow } from "../../../../crud/crud.js";
import { USUARIO } from "../../../../crud/models.js";
import { $tablaUsuarios } from "../user.js";

export const $modalUsuarioActualizar = $('#modal-usuario-actualizar');

export const $campoUsuarioActualizar = $('#nombre-usuario-actualizar');
export const $campoCorreoActualizar = $('#correo-usuario-actualizar');
const $campoRolUsuarioActualizar = $('#rol-usuario-actualizar');
export const $campoRolUsuarioActualizarOptions = $('#rol-usuario-actualizar option');
const $buttonActualizar = $('#actualizar-usuario');

$modalUsuarioActualizar.on('hide.bs.modal', () => {
    $('#modal-usuario-actualizar option[selected]').removeAttr('selected');
})

$buttonActualizar.on('click', e => {
    e.preventDefault();

    let hayErrores = false;
    if (!$campoUsuarioActualizar.val() || XSS_REGEX.test($campoUsuarioActualizar.val())) {
        $campoUsuarioActualizar.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoRolUsuarioActualizar.val() || XSS_REGEX.test($campoRolUsuarioActualizar.val())) {
        $campoRolUsuarioActualizar.addClass('is-invalid');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }

    const fields = {
        [USUARIO.USUARIO]: $campoUsuarioActualizar.val(),
        [USUARIO.ROL_ID]: $campoRolUsuarioActualizar.val()
    }
    const filters = {
        [USUARIO.CORREO]: $campoCorreoActualizar.val()
    }

    updateRow(USUARIO.TABLE_NAME, fields, filters, async () => {
        const id = $tablaUsuarios.row($('tr[selected]')).index();
        $tablaUsuarios.cell({row: id, column: 1}).data($campoUsuarioActualizar.val()).draw();
        const $selectedOption = $('#rol-usuario-actualizar option:selected');
        $tablaUsuarios.cell({row: id, column: 3}).data($selectedOption.text());
        const spanColor = document.createElement('span');
        spanColor.style.backgroundColor = `#${$selectedOption.attr('color')}`;
        $tablaUsuarios.cell({row: id, column: 4}).data(spanColor.outerHTML).draw();
    });
})