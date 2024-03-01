import { $tablaUsuarios, hasDeletePermission, hasUpdatePermission, openUpdateUser } from "../user.js";
import { insert } from "../../../../crud/crud.js";
import { END_POINTS } from "../../../../api/end-points.js";
import { UserRow } from "../../../models/row/UserRow.js";
import { USUARIO } from "../../../../crud/models.js";
import { PreviewImage } from "../../../../components/PreviewImage.js";
import { EMAIL_REGEX, XSS_REGEX } from "../../../../helpers/regex.js";

const $campoNombreCrear = $('#nombre-usuario-crear');
const $campoCorreoCrear = $('#correo-usuario-crear');
const $campoContraseniaCrear = $('#contrasenia-usuario-crear');
const $campoRolCrear = $('#rol-usuario-crear');
const $buttonCrear = $('#crear-usuario');

$buttonCrear.on('click', e => {
    e.preventDefault();

    let hayErrores = false;
    if (!$campoNombreCrear.val() || XSS_REGEX.test($campoRolCrear.val())) {
        $campoNombreCrear.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoCorreoCrear.val() || !EMAIL_REGEX.test($campoCorreoCrear.val()) || XSS_REGEX.test($campoCorreoCrear.val())) {
        $campoCorreoCrear.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoContraseniaCrear.val() || XSS_REGEX.test($campoContraseniaCrear.val())) {
        $campoContraseniaCrear.addClass('is-invalid');
        hayErrores = true;
    }
    
    if (!$campoRolCrear.val() || XSS_REGEX.test($campoRolCrear.val())) {
        $campoRolCrear.addClass('is-invalid');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }

    const fd = new FormData();
    fd.append(USUARIO.USUARIO, $campoNombreCrear.val());
    fd.append(USUARIO.CORREO, $campoCorreoCrear.val());
    fd.append(USUARIO.CONTRASENIA, $campoContraseniaCrear.val());
    fd.append(USUARIO.ROL_ID, $campoRolCrear.val());

    // Si se ha adjuntado una imagen, no usar la imagen por defecto
    if ($('#imagen-usuario-crear').prop('files')) {
        fd.append(USUARIO.RUTA_IMAGEN_PERFIL, $('#imagen-usuario-crear').prop('files')[0]);
    }

    insert(END_POINTS.USER.INSERT, fd, data => {
        // Coger color del rol
        const roleSelectedOption = $(`#rol-usuario-crear option[value=${$campoRolCrear.val()}]`);

        $tablaUsuarios.row.add(
            new UserRow(
                data[USUARIO.ID],
                $campoNombreCrear.val(),
                $campoCorreoCrear.val(),
                roleSelectedOption.text(),
                roleSelectedOption.attr('color'),
                data[USUARIO.RUTA_IMAGEN_PERFIL],
                hasDeletePermission
            ).getRow()).draw();
        if (hasUpdatePermission) {
            $tablaUsuarios.on('click', 'tbody tr:last', openUpdateUser);
        }
        clearFields();
    });
})

// Functions
function clearFields() {
    $campoNombreCrear.val('');
    $campoCorreoCrear.val('');
    $campoContraseniaCrear.val('');
    new PreviewImage('.img-container', 'imagen-usuario-crear');
}