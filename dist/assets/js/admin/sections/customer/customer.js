import { $campoNombreActualizar, $modalClienteActualizar, $campoApellidosActualizar, $campoTelefonoActualizar, $campoDireccionActualizar } from "./modals/modal-customer-update.js";
import { CLIENTE } from "../../../crud/models.js";
import { deleteRow, select } from "../../../crud/crud.js";
import { PERMISSIONS } from "../../../api/permissions.js";
import { PreviewImage } from "../../../components/PreviewImage.js";
import { CustomerRow } from "../../models/row/CustomerRow.js";

export let hasUpdatePermission, hasDeletePermission;
export let $tablaClientes;

// Cargar la página
window.addEventListener('load', async () => {
    $tablaClientes = $('#tabla-clientes').DataTable();
    const json = await select(CLIENTE.TABLE_NAME, [
        CLIENTE.ID,
        CLIENTE.NOMBRE,
        CLIENTE.APELLIDOS,
        CLIENTE.TELEFONO,
        CLIENTE.DIRECCION,
        CLIENTE.CORREO,
        CLIENTE.RUTA_IMAGEN_PERFIL
    ], null, true);
    const { data: customers } = json;
    hasUpdatePermission = json['has-update-permission'] !== PERMISSIONS.NO_PERMISSIONS;
    hasDeletePermission = json['has-delete-permission'] !== PERMISSIONS.NO_PERMISSIONS;
    for (const customer of customers) {
        $tablaClientes.row.add(
            new CustomerRow(
                customer[CLIENTE.ID],
                customer[CLIENTE.NOMBRE],
                customer[CLIENTE.APELLIDOS],
                customer[CLIENTE.TELEFONO],
                customer[CLIENTE.DIRECCION],
                customer[CLIENTE.CORREO],
                customer[CLIENTE.RUTA_IMAGEN_PERFIL],
                hasDeletePermission
            ).getRow());
    }
    $tablaClientes.draw();
    $tablaClientes.tableName = CLIENTE.TABLE_NAME;
    if (hasUpdatePermission) {
        // Al pulsar una fila, abrir el modal de actualizar
        $tablaClientes.on('click', 'tbody tr', openUpdateCustomer);
    }
    // Eliminar fila
    $tablaClientes.on('click', '.eliminar-cliente', e => deleteRow(e, $tablaClientes));
    // Componente de previsualización de imagen
    new PreviewImage('.img-container', 'imagen-cliente-crear');
})


/**
 * Al abrir una fila para actualizarla, coloca los campos de la fila en el modal de actualizar
 */
export function openUpdateCustomer() {
    $modalClienteActualizar.modal('show');
    $(this).attr('selected', '');
    const children = $(this).children();
    $campoNombreActualizar.val(children[1].textContent);
    $campoApellidosActualizar.val(children[2].textContent);
    $campoTelefonoActualizar.val(children[3].textContent);
    $campoDireccionActualizar.val(children[4].textContent);
}