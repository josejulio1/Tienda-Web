import { $campoColorActualizar, $campoNombreRolActualizar, $modalRolActualizar, $permisoActualizarActualizarCategoria, $permisoActualizarActualizarCliente, $permisoActualizarActualizarProducto, $permisoActualizarActualizarRol, $permisoActualizarActualizarUsuario, $permisoCrearActualizarCategoria, $permisoCrearActualizarCliente, $permisoCrearActualizarProducto, $permisoCrearActualizarRol, $permisoCrearActualizarUsuario, $permisoEliminarActualizarCategoria, $permisoEliminarActualizarCliente, $permisoEliminarActualizarProducto, $permisoEliminarActualizarRol, $permisoEliminarActualizarUsuario, $permisoVerActualizarCategoria, $permisoVerActualizarCliente, $permisoVerActualizarProducto, $permisoVerActualizarRol, $permisoVerActualizarUsuario, allUpdateCheckBoxes } from "./modals/modal-rol-update.js";
import { ROL } from "../../../crud/models.js";
import { deleteRow, select } from "../../../crud/crud.js";
import { RolRow } from "../../models/row/RolRow.js";
import { PERMISSIONS } from "../../../api/permissions.js";
import { rgbToHex } from "../../../helpers/rgb-to-hex-converter.js";
import { TYPE_FILTERS } from "../../../crud/utils.js";
import { clearCheckboxes, permissionNumberToCheckBox } from "./rol-system.js";

export let hasUpdatePermission, hasDeletePermission;
export let $tablaRoles;

// Cargar la página
window.addEventListener('load', async () => {
    $tablaRoles = $('#tabla-roles').DataTable();
    const json = await select(ROL.TABLE_NAME, [ROL.ID, ROL.NOMBRE, ROL.COLOR], null, true);
    const { data: roles } = json;
    hasUpdatePermission = json['has-update-permission'] !== PERMISSIONS.NO_PERMISSIONS;
    hasDeletePermission = json['has-delete-permission'] !== PERMISSIONS.NO_PERMISSIONS;
    for (const rol of roles) {
        $tablaRoles.row.add(
            new RolRow(
                rol[ROL.ID],
                rol[ROL.NOMBRE],
                rol[ROL.COLOR],
                hasDeletePermission
            ).getRow()
        );
    }
    $tablaRoles.draw();
    $tablaRoles.tableName = ROL.TABLE_NAME;
    if (hasUpdatePermission) {
        // Al pulsar una fila, abrir el modal de actualizar
        $tablaRoles.on('click', 'tbody tr', openUpdateRol);
    }
    // Eliminar fila
    $tablaRoles.on('click', '.eliminar-rol', e => deleteRow(e, $tablaRoles));
})


/**
 * Al abrir una fila para actualizarla, coloca los campos de la fila en el modal de actualizar
 */
export async function openUpdateRol() {
    $modalRolActualizar.modal('show');
    $(this).attr('selected', '');
    const children = $(this).children();
    $campoNombreRolActualizar.val(children[1].textContent);
    $campoColorActualizar.val(`#${rgbToHex(children[2].children[0].style.backgroundColor)}`);
    const permissions = await select(ROL.TABLE_NAME, [ROL.PERMISO_USUARIO, ROL.PERMISO_PRODUCTO, ROL.PERMISO_CATEGORIA, ROL.PERMISO_CLIENTE, ROL.PERMISO_ROL], {
        [TYPE_FILTERS.EQUALS]: {
            [ROL.ID]: $('tr[selected]').children()[0].textContent
        }
    });
    clearCheckboxes(...allUpdateCheckBoxes);
    permissionNumberToCheckBox(
        permissions[0].permiso_usuario,
        $permisoVerActualizarUsuario,
        $permisoCrearActualizarUsuario,
        $permisoActualizarActualizarUsuario,
        $permisoEliminarActualizarUsuario
    );
    permissionNumberToCheckBox(
        permissions[0].permiso_producto,
        $permisoVerActualizarProducto,
        $permisoCrearActualizarProducto,
        $permisoActualizarActualizarProducto,
        $permisoEliminarActualizarProducto
    );
    permissionNumberToCheckBox(
        permissions[0].permiso_categoria,
        $permisoVerActualizarCategoria,
        $permisoCrearActualizarCategoria,
        $permisoActualizarActualizarCategoria,
        $permisoEliminarActualizarCategoria
    );
    permissionNumberToCheckBox(
        permissions[0].permiso_cliente,
        $permisoVerActualizarCliente,
        $permisoCrearActualizarCliente,
        $permisoActualizarActualizarCliente,
        $permisoEliminarActualizarCliente
    );
    permissionNumberToCheckBox(
        permissions[0].permiso_rol,
        $permisoVerActualizarRol,
        $permisoCrearActualizarRol,
        $permisoActualizarActualizarRol,
        $permisoEliminarActualizarRol
    );
}