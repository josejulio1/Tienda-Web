import { $tablaUsuarios, hasDeletePermission, hasUpdatePermission, openUpdateUser } from "../user.js";
import { insert } from "../../crud.js";
import { END_POINTS } from "../../../api/end-points.js";
import { UserRow } from "../../models/row/UserRow.js";

const $campoNombreCrear = $('#nombre-usuario-crear');
const $campoCorreoCrear = $('#correo-usuario-crear');
const $campoContraseniaCrear = $('#contrasenia-usuario-crear');
const $campoRolCrear = $('#rol-usuario-crear');
const $campoImagenCrear = $('#imagen-usuario-crear');
const $buttonCrear = $('#crear-usuario');

$buttonCrear.on('click', e => {
    e.preventDefault();

    let hayErrores = false;
    if (!$campoNombreCrear.val()) {
        $campoNombreCrear.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoCorreoCrear.val()) {
        $campoCorreoCrear.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoContraseniaCrear.val()) {
        $campoContraseniaCrear.addClass('is-invalid');
        hayErrores = true;
    }
    
    if (!$campoRolCrear.val()) {
        $campoRolCrear.addClass('is-invalid');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }

    const fields = [$campoNombreCrear, $campoCorreoCrear, $campoContraseniaCrear, $campoRolCrear];
    // Si se ha adjuntado una imagen, no usar la imagen por defecto
    if ($campoImagenCrear.prop('files')) {
        fields.push($campoImagenCrear);
    }

    insert(END_POINTS.USER.INSERT, fields, data => {
        // Coger color del rol
        const roleSelectedOption = $(`#rol-usuario-crear option[value=${$campoRolCrear.val()}]`);

        $tablaUsuarios.row.add(new UserRow(data.usuario_id, $campoNombreCrear.val(), $campoCorreoCrear.val(),
            roleSelectedOption.text(), roleSelectedOption.attr('color'), data.ruta_imagen_perfil, hasDeletePermission).getRow()).draw();
        if (hasUpdatePermission) {
            $('#tabla-usuarios tbody tr:last').on('click', openUpdateUser);
        }
        clearFields();
    });
})

// Functions
function clearFields() {
    $campoNombreCrear.val('');
    $campoCorreoCrear.val('');
    $campoContraseniaCrear.val('');
    $campoImagenCrear.val('');
}