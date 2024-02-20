import { updateRow } from "../../../crud.js";
import { ROL } from "../../../../crud/models.js";
import { $tablaRoles } from "../rol.js";
import { clearCheckboxes, getPermissions, validatePermissions } from "../rol-system.js";
import { ErrorWindow } from "../../../../components/ErrorWindow.js";
import { XSS_REGEX } from "../../../../helpers/regex.js";

export const $modalRolActualizar = $('#modal-rol-actualizar');
export const $campoNombreRolActualizar = $('#nombre-rol-actualizar');
export const $campoColorActualizar = $('#color-rol-actualizar');
// CheckBoxes Rol
// Usuario
const $marcarTodoActualizarUsuario = $('#marcar-todo-usuario-actualizar');
export const $permisoVerActualizarUsuario = $('#ver-permiso-usuario-actualizar');
export const $permisoCrearActualizarUsuario = $('#crear-permiso-usuario-actualizar');
export const $permisoActualizarActualizarUsuario = $('#actualizar-permiso-usuario-actualizar');
export const $permisoEliminarActualizarUsuario = $('#eliminar-permiso-usuario-actualizar');

// Producto
const $marcarTodoActualizarProducto = $('#marcar-todo-usuario-producto');
export const $permisoVerActualizarProducto = $('#ver-permiso-producto-actualizar');
export const $permisoCrearActualizarProducto = $('#crear-permiso-producto-actualizar');
export const $permisoActualizarActualizarProducto = $('#actualizar-permiso-producto-actualizar');
export const $permisoEliminarActualizarProducto = $('#eliminar-permiso-producto-actualizar');

// Categoría
const $marcarTodoActualizarCategoria = $('#marcar-todo-usuario-categoria');
export const $permisoVerActualizarCategoria = $('#ver-permiso-categoria-actualizar');
export const $permisoCrearActualizarCategoria = $('#crear-permiso-categoria-actualizar');
export const $permisoActualizarActualizarCategoria = $('#actualizar-permiso-categoria-actualizar');
export const $permisoEliminarActualizarCategoria = $('#eliminar-permiso-categoria-actualizar');

// Cliente
const $marcarTodoActualizarCliente = $('#marcar-todo-usuario-cliente');
export const $permisoVerActualizarCliente = $('#ver-permiso-cliente-actualizar');
export const $permisoCrearActualizarCliente = $('#crear-permiso-cliente-actualizar');
export const $permisoActualizarActualizarCliente = $('#actualizar-permiso-cliente-actualizar');
export const $permisoEliminarActualizarCliente = $('#eliminar-permiso-cliente-actualizar');

// Rol
const $marcarTodoActualizarRol = $('#marcar-todo-usuario-rol');
export const $permisoVerActualizarRol = $('#ver-permiso-rol-actualizar');
export const $permisoCrearActualizarRol = $('#crear-permiso-rol-actualizar');
export const $permisoActualizarActualizarRol = $('#actualizar-permiso-rol-actualizar');
export const $permisoEliminarActualizarRol = $('#eliminar-permiso-rol-actualizar');

export const allUpdateCheckBoxes = [
    $marcarTodoActualizarUsuario,
    $permisoVerActualizarUsuario,
    $permisoCrearActualizarUsuario,
    $permisoActualizarActualizarUsuario,
    $permisoEliminarActualizarUsuario,
    
    $marcarTodoActualizarProducto,
    $permisoVerActualizarProducto,
    $permisoCrearActualizarProducto,
    $permisoActualizarActualizarProducto,
    $permisoEliminarActualizarProducto,
    
    $marcarTodoActualizarCategoria,
    $permisoVerActualizarCategoria,
    $permisoCrearActualizarCategoria,
    $permisoActualizarActualizarCategoria,
    $permisoEliminarActualizarCategoria,
    
    $marcarTodoActualizarCliente,
    $permisoVerActualizarCliente,
    $permisoCrearActualizarCliente,
    $permisoActualizarActualizarCliente,
    $permisoEliminarActualizarCliente,
    
    $marcarTodoActualizarRol,
    $permisoVerActualizarRol,
    $permisoCrearActualizarRol,
    $permisoActualizarActualizarRol,
    $permisoEliminarActualizarRol
];

const $buttonActualizar = $('#actualizar-rol');

$buttonActualizar.on('click', e => {
    e.preventDefault();

    if (!$campoNombreRolActualizar.val() || XSS_REGEX.test($campoNombreRolActualizar.val())) {
        $campoNombreRolActualizar.addClass('is-invalid');
        return;
    }

    const permisoUsuario = getPermissions($permisoVerActualizarUsuario, $permisoCrearActualizarUsuario, $permisoActualizarActualizarUsuario, $permisoEliminarActualizarUsuario);
    const permisoProducto = getPermissions($permisoVerActualizarProducto, $permisoCrearActualizarProducto, $permisoActualizarActualizarProducto, $permisoEliminarActualizarProducto);
    const permisoCategoria = getPermissions($permisoVerActualizarCategoria, $permisoCrearActualizarCategoria, $permisoActualizarActualizarCategoria, $permisoEliminarActualizarCategoria);
    const permisoCliente = getPermissions($permisoVerActualizarCliente, $permisoCrearActualizarCliente, $permisoActualizarActualizarCliente, $permisoEliminarActualizarCliente);
    const permisoRol = getPermissions($permisoVerActualizarRol, $permisoCrearActualizarRol, $permisoActualizarActualizarRol, $permisoEliminarActualizarRol);

    if (permisoUsuario && !validatePermissions($permisoCrearActualizarUsuario, $permisoActualizarActualizarUsuario, $permisoEliminarActualizarUsuario)) {
        ErrorWindow.make('Debe tener el permiso Ver en Usuario marcado');
        return;
    }

    if (permisoProducto && !validatePermissions($permisoCrearActualizarProducto, $permisoActualizarActualizarProducto, $permisoEliminarActualizarProducto)) {
        ErrorWindow.make('Debe tener el permiso Ver en Producto marcado');
        return;
    }

    if (permisoCategoria && !validatePermissions($permisoCrearActualizarCategoria, $permisoActualizarActualizarCategoria, $permisoEliminarActualizarCategoria)) {
        ErrorWindow.make('Debe tener el permiso Ver en Categoría marcado');
        return;
    }

    if (permisoCliente && !validatePermissions($permisoCrearActualizarCliente, $permisoActualizarActualizarCliente, $permisoEliminarActualizarCliente)) {
        ErrorWindow.make('Debe tener el permiso Ver en Cliente marcado');
        return;
    }

    if (permisoRol && !validatePermissions($permisoCrearActualizarRol, $permisoActualizarActualizarRol, $permisoEliminarActualizarRol)) {
        ErrorWindow.make('Debe tener el permiso Ver en Rol marcado');
        return;
    }

    const fields = {
        [ROL.NOMBRE]: $campoNombreRolActualizar.val(),
        [ROL.COLOR]: $campoColorActualizar.val().substring(1),
        [ROL.PERMISO_USUARIO]: permisoUsuario,
        [ROL.PERMISO_PRODUCTO]: permisoProducto,
        [ROL.PERMISO_CATEGORIA]: permisoCategoria,
        [ROL.PERMISO_CLIENTE]: permisoCliente,
        [ROL.PERMISO_ROL]: permisoRol
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
        clearFields();
    });
})

function clearFields() {
    clearCheckboxes(...allUpdateCheckBoxes);
}