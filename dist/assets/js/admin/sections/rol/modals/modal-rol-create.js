import { $tablaRoles, hasDeletePermission, hasUpdatePermission, openUpdateRol } from "../rol.js";
import { insert } from "../../../crud.js";
import { END_POINTS } from "../../../../api/end-points.js";
import { ROL } from "../../../models/models.js";
import { PERMISSIONS, PERMISSIONS_TEXT } from "../../../../api/permissions.js";
import { RolRow } from "../../../models/row/RolRow.js";

const $campoNombreRolCrear = $('#nombre-rol-crear');
const $campoColorCrear = $('#color-rol-crear');
// CheckBoxes Rol
// Usuario
const $permisoVerUsuario = $('#ver-permiso-usuario');
const $permisoCrearUsuario = $('#crear-permiso-usuario');
const $permisoActualizarUsuario = $('#actualizar-permiso-usuario');
const $permisoEliminarUsuario = $('#eliminar-permiso-usuario');

// Producto
const $permisoVerProducto = $('#ver-permiso-producto');
const $permisoCrearProducto = $('#crear-permiso-producto');
const $permisoActualizarProducto = $('#actualizar-permiso-producto');
const $permisoEliminarProducto = $('#eliminar-permiso-producto');

// Categoría
const $permisoVerCategoria = $('#ver-permiso-categoria');
const $permisoCrearCategoria = $('#crear-permiso-categoria');
const $permisoActualizarCategoria = $('#actualizar-permiso-categoria');
const $permisoEliminarCategoria = $('#eliminar-permiso-categoria');

// Cliente
const $permisoVerCliente = $('#ver-permiso-cliente');
const $permisoCrearCliente = $('#crear-permiso-cliente');
const $permisoActualizarCliente = $('#actualizar-permiso-cliente');
const $permisoEliminarCliente = $('#eliminar-permiso-cliente');

// Rol
const $permisoVerRol = $('#ver-permiso-rol');
const $permisoCrearRol = $('#crear-permiso-rol');
const $permisoActualizarRol = $('#actualizar-permiso-rol');
const $permisoEliminarRol = $('#eliminar-permiso-rol');

const $buttonCrear = $('#crear-rol');

$buttonCrear.on('click', e => {
    e.preventDefault();

    let hayErrores = false;
    if (!$campoNombreRolCrear.val()) {
        $campoNombreRolCrear.addClass('is-invalid');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }

    const permisoUsuario = getPermissions($permisoVerUsuario, $permisoCrearUsuario, $permisoActualizarUsuario, $permisoEliminarUsuario);
    const permisoProducto = getPermissions($permisoVerProducto, $permisoCrearProducto, $permisoActualizarProducto, $permisoEliminarProducto);
    const permisoCategoria = getPermissions($permisoVerCategoria, $permisoCrearCategoria, $permisoActualizarCategoria, $permisoEliminarCategoria);
    const permisoCliente = getPermissions($permisoVerCliente, $permisoCrearCliente, $permisoActualizarCliente, $permisoEliminarCliente);
    const permisoRol = getPermissions($permisoVerRol, $permisoCrearRol, $permisoActualizarRol, $permisoEliminarRol);

    const fd = new FormData();
    fd.append(ROL.NOMBRE, $campoNombreRolCrear.val());
    fd.append(ROL.COLOR, $campoColorCrear.val().substring(1));
    fd.append(ROL.PERMISO_USUARIO, permisoUsuario);
    fd.append(ROL.PERMISO_PRODUCTO, permisoProducto);
    fd.append(ROL.PERMISO_CATEGORIA, permisoCategoria);
    fd.append(ROL.PERMISO_CLIENTE, permisoCliente);
    fd.append(ROL.PERMISO_ROL, permisoRol);

    insert(END_POINTS.ROL.INSERT, fd, data => {
        $tablaRoles.row.add(new RolRow(data.rol_id, $campoNombreRolCrear.val(), $campoColorCrear.val().substring(1), hasDeletePermission).getRow()).draw();
        if (hasUpdatePermission) {
            $tablaRoles.on('click', 'tbody tr:last', openUpdateRol);
        }
        clearFields();
    });
})

// Functions
function getPermissions(...$checkBoxes) {
    let permissionNumber = 0;
    let idValue;
    const permissionsText = Object.entries(PERMISSIONS_TEXT);
    for (const $checkBox of $checkBoxes) {
        idValue = $checkBox.attr('id');
        for (const permissionText of permissionsText) {
            if (idValue.includes(permissionText[0]) && $checkBox.prop('checked')) {
                permissionNumber += permissionText[1];
            }
        }
    }
    return permissionNumber;
}

function clearFields() {
    $campoNombreRolCrear.val('');
}