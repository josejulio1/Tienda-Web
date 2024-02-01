import { $campoCorreoActualizar, $campoRolUsuarioActualizarOptions, $campoUsuarioActualizar, $modalUsuarioActualizar } from "./modals/modal-user-update.js";
import { USUARIO, V_USUARIO_ROL } from "../../models/models.js";
import { deleteRow, select } from "../../crud.js";
import { UserRow } from "../../models/row/UserRow.js";
import { PERMISSIONS } from "../../../api/permissions.js";
import { PreviewImage } from "../../../components/PreviewImage.js";

export let hasUpdatePermission, hasDeletePermission;
export let $tablaUsuarios;

// Cargar la página
window.addEventListener('load', async () => {
    $tablaUsuarios = $('#tabla-usuarios').DataTable();
    const json = await select(V_USUARIO_ROL.TABLE_NAME, true);
    const { data: users } = json;
    hasUpdatePermission = json['has-update-permission'] != PERMISSIONS.NO_PERMISSIONS;
    hasDeletePermission = json['has-delete-permission'] != PERMISSIONS.NO_PERMISSIONS;
    for (const user of users) {
        $tablaUsuarios.row.add(new UserRow(user.usuario_id, user.usuario,
            user.correo, user.nombre_rol, user.color_rol, user.ruta_imagen_perfil, hasDeletePermission).getRow());
    }
    $tablaUsuarios.draw();
    $tablaUsuarios.tableName = USUARIO.TABLE_NAME;
    if (hasUpdatePermission) {
        // Al pulsar una fila, abrir el modal de actualizar
        $tablaUsuarios.on('click', 'tbody tr', openUpdateUser);
    }
    // Eliminar fila
    $tablaUsuarios.on('click', '.eliminar-usuario', e => deleteRow(e, $tablaUsuarios));
    // Componente de previsualización de imagen
    new PreviewImage('.img-container', 'imagen-usuario-crear');
})


/**
 * Al abrir una fila para actualizarla, coloca los campos de la fila en el modal de actualizar
 */
export function openUpdateUser() {
    $modalUsuarioActualizar.modal('show');
    $(this).attr('selected', '');
    const children = $(this).children();
    $campoUsuarioActualizar.val(children[1].textContent);
    $campoCorreoActualizar.val(children[2].textContent);
    const $campoRol = children[3].textContent;
    $campoRolUsuarioActualizarOptions.each(function() {
        if ($(this).text() == $campoRol) {
            $(this).attr('selected', '');
            return;
        }
    })
}