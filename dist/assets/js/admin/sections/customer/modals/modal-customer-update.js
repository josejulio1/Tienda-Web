import { PHONE_REGEX, XSS_REGEX } from "../../../../helpers/regex.js";
import { select, updateRow } from "../../../crud.js";
import { CLIENTE, V_PEDIDO } from "../../../../crud/models.js";
import { $tablaClientes } from "../customer.js";
import { TYPE_FILTERS } from "../../../../crud/utils.js";

export const $modalClienteActualizar = $('#modal-cliente-actualizar');

export const $campoNombreActualizar = $('#nombre-cliente-actualizar');
export const $campoApellidosActualizar = $('#apellidos-cliente-actualizar');
export const $campoTelefonoActualizar = $('#telefono-cliente-actualizar');
export const $campoDireccionActualizar = $('#direccion-cliente-actualizar');
const $campoContraseniaActualizar = $('#contrasenia-cliente-actualizar');
const $buttonActualizar = $('#actualizar-cliente');

const $tablaPedidosDataTable = $('#tabla-pedidos').DataTable();
const $modalVerPedidos = $('#modal-cliente-pedidos');
const $buttonVerPedidos = $('#mostrar-pedidos-cliente');
$buttonVerPedidos.on('click', async e => {
    e.preventDefault();
    const json = await select(V_PEDIDO.TABLE_NAME, [
        V_PEDIDO.ID,
        V_PEDIDO.NOMBRE_CLIENTE,
        V_PEDIDO.APELLIDOS_CLIENTE,
        V_PEDIDO.NOMBRE_PRODUCTO,
        V_PEDIDO.METODO_PAGO,
        V_PEDIDO.ESTADO_PAGO,
        V_PEDIDO.DIRECCION_ENVIO
    ], {
        [TYPE_FILTERS.EQUALS]: {
            [V_PEDIDO.CLIENTE_ID]: $('tr[selected]').children()[0].textContent
        }
    })
    $tablaPedidosDataTable.clear();
    for (const row of json) {
        $tablaPedidosDataTable.row.add([
            row[V_PEDIDO.ID],
            row[V_PEDIDO.NOMBRE_CLIENTE],
            row[V_PEDIDO.APELLIDOS_CLIENTE],
            row[V_PEDIDO.NOMBRE_PRODUCTO],
            row[V_PEDIDO.METODO_PAGO],
            row[V_PEDIDO.ESTADO_PAGO],
            row[V_PEDIDO.DIRECCION_ENVIO]
        ])
    }
    $tablaPedidosDataTable.draw();
    $modalVerPedidos.modal('show');
})

$buttonActualizar.on('click', e => {
    e.preventDefault();

    let hayErrores = false;
    if (!$campoNombreActualizar.val() || XSS_REGEX.test($campoNombreActualizar.val())) {
        $campoNombreActualizar.addClass('is-invalid');
        hayErrores = true;
    }
    
    if (!$campoApellidosActualizar.val() || XSS_REGEX.test($campoApellidosActualizar.val())) {
        $campoApellidosActualizar.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoTelefonoActualizar.val() || !PHONE_REGEX.test($campoTelefonoActualizar.val()) || XSS_REGEX.test($campoTelefonoActualizar.val())) {
        $campoTelefonoActualizar.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoDireccionActualizar.val() || XSS_REGEX.test($campoDireccionActualizar.val())) {
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