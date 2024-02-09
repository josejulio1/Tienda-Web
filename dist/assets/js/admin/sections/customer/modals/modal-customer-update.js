import { PHONE_REGEX } from "../../../../helpers/regex.js";
import { updateRow } from "../../../crud.js";
import { CLIENTE } from "../../../models/models.js";
import { $tablaClientes } from "../customer.js";

export const $modalClienteActualizar = $('#modal-cliente-actualizar');

export const $campoNombreActualizar = $('#nombre-cliente-actualizar');
export const $campoApellidosActualizar = $('#apellidos-cliente-actualizar');
export const $campoTelefonoActualizar = $('#telefono-cliente-actualizar');
export const $campoDireccionActualizar = $('#direccion-cliente-actualizar');
const $campoContraseniaActualizar = $('#contrasenia-cliente-actualizar');
const $buttonActualizar = $('#actualizar-cliente');

$buttonActualizar.on('click', e => {
    e.preventDefault();

    let hayErrores = false;
    if (!$campoNombreActualizar.val()) {
        $campoNombreActualizar.addClass('is-invalid');
        hayErrores = true;
    }
    
    if (!$campoApellidosActualizar.val()) {
        $campoApellidosActualizar.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoTelefonoActualizar.val() || !PHONE_REGEX.test($campoTelefonoActualizar.val())) {
        $campoTelefonoActualizar.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoDireccionActualizar.val()) {
        $campoDireccionActualizar.addClass('is-invalid');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }

    const fields = {
        [CLIENTE.NOMBRE]: $campoNombreActualizar.val(),
        [CLIENTE.APELLIDOS]: $campoApellidosActualizar.val(),
        [CLIENTE.TELEFONO]: $campoTelefonoActualizar.val(),
        [CLIENTE.DIRECCION]: $campoDireccionActualizar.val(),
    }
    if ($campoContraseniaActualizar.val()) {
        fields[CLIENTE.CONTRASENIA] = $campoContraseniaActualizar.val();
    }
    const filters = {
        [CLIENTE.ID]: $('tr[selected]').children()[0].textContent
    }

    updateRow(CLIENTE.TABLE_NAME, fields, filters, async () => {
        const id = $tablaClientes.row($('tr[selected]')).index();
        $tablaClientes.cell({row: id, column: 1}).data($campoNombreActualizar.val());
        $tablaClientes.cell({row: id, column: 2}).data($campoApellidosActualizar.val());
        $tablaClientes.cell({row: id, column: 3}).data($campoTelefonoActualizar.val());
        $tablaClientes.cell({row: id, column: 4}).data($campoDireccionActualizar.val()).draw();
    });
})