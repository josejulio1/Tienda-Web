import { $tablaClientes, hasDeletePermission, hasUpdatePermission, openUpdateCustomer } from "../customer.js";
import { insert } from "../../../crud.js";
import { END_POINTS } from "../../../../api/end-points.js";
import { CustomerRow } from "../../../models/row/CustomerRow.js";
import { CLIENTE } from "../../../models/models.js";
import { PreviewImage } from "../../../../components/PreviewImage.js";
import { EMAIL_REGEX, PHONE_REGEX } from "../../../../helpers/regex.js";

const $campoNombreCrear = $('#nombre-cliente-crear');
const $campoApellidosCrear = $('#apellidos-cliente-crear');
const $campoTelefonoCrear = $('#telefono-cliente-crear');
const $campoDireccionCrear = $('#direccion-cliente-crear');
const $campoCorreoCrear = $('#correo-cliente-crear');
const $campoContraseniaCrear = $('#contrasenia-cliente-crear');
const $buttonCrear = $('#crear-cliente');

$buttonCrear.on('click', e => {
    e.preventDefault();

    let hayErrores = false;
    if (!$campoNombreCrear.val()) {
        $campoNombreCrear.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoApellidosCrear.val()) {
        $campoApellidosCrear.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoTelefonoCrear.val() || !PHONE_REGEX.test($campoTelefonoCrear.val())) {
        $campoTelefonoCrear.addClass('is-invalid');
        hayErrores = true;
    }
    
    if (!$campoDireccionCrear.val()) {
        $campoDireccionCrear.addClass('is-invalid');
        hayErrores = true;
    }
    
    if (!$campoCorreoCrear.val() || !EMAIL_REGEX.test($campoCorreoCrear.val())) {
        $campoCorreoCrear.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoContraseniaCrear.val()) {
        $campoContraseniaCrear.addClass('is-invalid');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }

    const fd = new FormData();
    fd.append(CLIENTE.NOMBRE, $campoNombreCrear.val());
    fd.append(CLIENTE.APELLIDOS, $campoApellidosCrear.val());
    fd.append(CLIENTE.TELEFONO, $campoTelefonoCrear.val());
    fd.append(CLIENTE.DIRECCION, $campoDireccionCrear.val());
    fd.append(CLIENTE.CORREO, $campoCorreoCrear.val());
    fd.append(CLIENTE.CONTRASENIA, $campoContraseniaCrear.val());

    // Si se ha adjuntado una imagen, no usar la imagen por defecto
    if ($('#imagen-cliente-crear').prop('files')) {
        fd.append(CLIENTE.RUTA_IMAGEN_PERFIL, $('#imagen-cliente-crear').prop('files')[0]);
    }

    insert(END_POINTS.CUSTOMER.INSERT, fd, data => {
        $tablaClientes.row.add(new CustomerRow(data.cliente_id, $campoNombreCrear.val(), $campoApellidosCrear.val(), $campoTelefonoCrear.val(),
            $campoDireccionCrear.val(), $campoCorreoCrear.val(), data.ruta_imagen_perfil, hasDeletePermission).getRow()).draw();
        if (hasUpdatePermission) {
            $tablaClientes.on('click', 'tbody tr:last', openUpdateCustomer);
        }
        clearFields();
    });
})

// Functions
function clearFields() {
    $campoNombreCrear.val('');
    $campoApellidosCrear.val('');
    $campoTelefonoCrear.val('');
    $campoDireccionCrear.val('');
    $campoCorreoCrear.val('');
    $campoContraseniaCrear.val('');
    new PreviewImage('.img-container', 'imagen-usuario-crear');
}