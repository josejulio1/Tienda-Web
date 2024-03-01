import { $tablaRoles, hasDeletePermission, hasUpdatePermission, openUpdateRol } from "../rol.js";
import { insert } from "../../../../crud/crud.js";
import { END_POINTS } from "../../../../api/end-points.js";
import { ROL } from "../../../../crud/models.js";
import { RolRow } from "../../../models/row/RolRow.js";
import { clearCheckboxes, getPermissions } from "../rol-system.js";
import { XSS_REGEX } from "../../../../helpers/regex.js";

const $campoNombreRolCrear = $('#nombre-rol-crear');
const $campoColorCrear = $('#color-rol-crear');
// CheckBoxes Rol
// Usuario
const $marcarTodoUsuario = $('marcar-todo-usuario');
const $permisoVerUsuario = $('#ver-permiso-usuario');
const $permisoCrearUsuario = $('#crear-permiso-usuario');
const $permisoActualizarUsuario = $('#actualizar-permiso-usuario');
const $permisoEliminarUsuario = $('#eliminar-permiso-usuario');

// Producto
const $marcarTodoProducto = $('marcar-todo-producto');
const $permisoVerProducto = $('#ver-permiso-producto');
const $permisoCrearProducto = $('#crear-permiso-producto');
const $permisoActualizarProducto = $('#actualizar-permiso-producto');
const $permisoEliminarProducto = $('#eliminar-permiso-producto');

// Categoría
const $marcarTodoCategoria = $('marcar-todo-categoria');
const $permisoVerCategoria = $('#ver-permiso-categoria');
const $permisoCrearCategoria = $('#crear-permiso-categoria');
const $permisoActualizarCategoria = $('#actualizar-permiso-categoria');
const $permisoEliminarCategoria = $('#eliminar-permiso-categoria');

// Cliente
const $marcarTodoCliente = $('marcar-todo-cliente');
const $permisoVerCliente = $('#ver-permiso-cliente');
const $permisoCrearCliente = $('#crear-permiso-cliente');
const $permisoActualizarCliente = $('#actualizar-permiso-cliente');
const $permisoEliminarCliente = $('#eliminar-permiso-cliente');

// Rol
const $marcarTodoRol = $('marcar-todo-rol');
const $permisoVerRol = $('#ver-permiso-rol');
const $permisoCrearRol = $('#crear-permiso-rol');
const $permisoActualizarRol = $('#actualizar-permiso-rol');
const $permisoEliminarRol = $('#eliminar-permiso-rol');

const $buttonCrear = $('#crear-rol');

$buttonCrear.on('click', e => {
    e.preventDefault();

    let hayErrores = false;
    if (!$campoNombreRolCrear.val() || XSS_REGEX.test($campoNombreRolCrear.val())) {
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
        $tablaRoles.row.add(
            new RolRow(
                data[ROL.ID],
                $campoNombreRolCrear.val(),
                $campoColorCrear.val().substring(1),
                hasDeletePermission
            ).getRow()).draw();
        if (hasUpdatePermission) {
            $tablaRoles.on('click', 'tbody tr:last', openUpdateRol);
        }
        clearFields();
    });
})

// Functions
function clearFields() {
    $campoNombreRolCrear.val('');
    $campoColorCrear.val('#000000');
    clearCheckboxes(
        $marcarTodoUsuario,
        $permisoVerUsuario,
        $permisoCrearUsuario,
        $permisoActualizarUsuario,
        $permisoEliminarUsuario,

        $marcarTodoProducto,
        $permisoVerProducto,
        $permisoCrearProducto,
        $permisoActualizarProducto,
        $permisoEliminarProducto,

        $marcarTodoCategoria,
        $permisoVerCategoria,
        $permisoCrearCategoria,
        $permisoActualizarCategoria,
        $permisoEliminarCategoria,

        $marcarTodoCliente,
        $permisoVerCliente,
        $permisoCrearCliente,
        $permisoActualizarCliente,
        $permisoEliminarCliente,

        $marcarTodoRol,
        $permisoVerRol,
        $permisoCrearRol,
        $permisoActualizarRol,
        $permisoEliminarRol
    );
}