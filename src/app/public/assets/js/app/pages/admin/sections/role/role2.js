import {
    $campoColorActualizar,
    $campoNombreRolActualizar,
    $modalRolActualizar,
    $permisoActualizarActualizarCategoria,
    $permisoActualizarActualizarCliente, $permisoActualizarActualizarMarca,
    $permisoActualizarActualizarProducto,
    $permisoActualizarActualizarRol,
    $permisoActualizarActualizarUsuario,
    $permisoCrearActualizarCategoria,
    $permisoCrearActualizarCliente, $permisoCrearActualizarMarca,
    $permisoCrearActualizarProducto,
    $permisoCrearActualizarRol,
    $permisoCrearActualizarUsuario,
    $permisoEliminarActualizarCategoria,
    $permisoEliminarActualizarCliente, $permisoEliminarActualizarMarca,
    $permisoEliminarActualizarProducto,
    $permisoEliminarActualizarRol,
    $permisoEliminarActualizarUsuario,
    $permisoVerActualizarCategoria,
    $permisoVerActualizarCliente,
    $permisoVerActualizarMarca,
    $permisoVerActualizarProducto,
    $permisoVerActualizarRol,
    $permisoVerActualizarUsuario,
    allUpdateCheckBoxes
} from "./modals/modal-rol-update.js";
import { ROL } from "../../../crud/components.js";
import { deleteRow, select } from "../../../crud/crud.js";
import { RoleRow } from "../../components/row/rows/RoleRow.js";
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
            new RoleRow(
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
    $tablaRoles.on('click', '.eliminar-role', e => deleteRow(e, $tablaRoles));
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
    const permissions = await select(ROL.TABLE_NAME, [
        ROL.PERMISO_USUARIO,
        ROL.PERMISO_PRODUCTO,
        ROL.PERMISO_MARCA,
        ROL.PERMISO_CATEGORIA,
        ROL.PERMISO_CLIENTE,
        ROL.PERMISO_ROL
    ], {
        [TYPE_FILTERS.EQUALS]: {
            [ROL.ID]: $('tr[selected]').children()[0].textContent
        }
    });
    clearCheckboxes(...allUpdateCheckBoxes);
    permissionNumberToCheckBox(
        permissions[0][ROL.PERMISO_USUARIO],
        $permisoVerActualizarUsuario,
        $permisoCrearActualizarUsuario,
        $permisoActualizarActualizarUsuario,
        $permisoEliminarActualizarUsuario
    );
    permissionNumberToCheckBox(
        permissions[0][ROL.PERMISO_PRODUCTO],
        $permisoVerActualizarProducto,
        $permisoCrearActualizarProducto,
        $permisoActualizarActualizarProducto,
        $permisoEliminarActualizarProducto
    );
    permissionNumberToCheckBox(
        permissions[0][ROL.PERMISO_MARCA],
        $permisoVerActualizarMarca,
        $permisoCrearActualizarMarca,
        $permisoActualizarActualizarMarca,
        $permisoEliminarActualizarMarca
    );
    permissionNumberToCheckBox(
        permissions[0][ROL.PERMISO_CATEGORIA],
        $permisoVerActualizarCategoria,
        $permisoCrearActualizarCategoria,
        $permisoActualizarActualizarCategoria,
        $permisoEliminarActualizarCategoria
    );
    permissionNumberToCheckBox(
        permissions[0][ROL.PERMISO_CLIENTE],
        $permisoVerActualizarCliente,
        $permisoCrearActualizarCliente,
        $permisoActualizarActualizarCliente,
        $permisoEliminarActualizarCliente
    );
    permissionNumberToCheckBox(
        permissions[0][ROL.PERMISO_ROL],
        $permisoVerActualizarRol,
        $permisoCrearActualizarRol,
        $permisoActualizarActualizarRol,
        $permisoEliminarActualizarRol
    );
}