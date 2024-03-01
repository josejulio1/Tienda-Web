import { hasDeletePermission, hasUpdatePermission } from "../product.js";
import { insert } from "../../../../crud/crud.js";
import { END_POINTS } from "../../../../api/end-points.js";
import { PRODUCTO } from "../../../../crud/models.js";
import { $tablaProductos, openUpdateProduct } from "../product.js";
import { ProductRow } from "../../../models/row/ProductRow.js";
import { PreviewImage } from "../../../../components/PreviewImage.js";
import { XSS_REGEX } from "../../../../helpers/regex.js";

const $campoNombreCrear = $('#nombre-producto-crear');
const $campoPrecioCrear = $('#precio-producto-crear');
const $campoMarcaCrear = $('#marca-producto-crear');
const $campoStockCrear = $('#stock-producto-crear');
const $campoDescripcionCrear = $('#descripcion-producto-crear');
const $campoCategoriaCrear = $('#categoria-producto-crear');
const $buttonCrear = $('#crear-producto');

$buttonCrear.on('click', e => {
    e.preventDefault();

    const $campoImagenCrear = $('#imagen-producto-crear');

    let hayErrores = false;
    if (!$campoNombreCrear.val() || XSS_REGEX.test($campoNombreCrear.val())) {
        $campoNombreCrear.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoPrecioCrear.val() || XSS_REGEX.test($campoPrecioCrear.val()) || $campoPrecioCrear.val() < 1) {
        $campoPrecioCrear.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoMarcaCrear.val() || XSS_REGEX.test($campoMarcaCrear.val())) {
        $campoMarcaCrear.addClass('is-invalid');
        hayErrores = true;
    }
    
    if (!$campoStockCrear.val() || XSS_REGEX.test($campoStockCrear.val()) || $campoStockCrear.val() < 1) {
        $campoStockCrear.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoDescripcionCrear.val() || XSS_REGEX.test($campoDescripcionCrear.val())) {
        $campoDescripcionCrear.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoImagenCrear.prop('files')[0] || XSS_REGEX.test($campoImagenCrear.val())) {
        $('label[for=imagen-producto-crear]').addClass('is-invalid');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }

    const fd = new FormData();
    fd.append(PRODUCTO.NOMBRE, $campoNombreCrear.val());
    fd.append(PRODUCTO.PRECIO, $campoPrecioCrear.val());
    fd.append(PRODUCTO.MARCA, $campoMarcaCrear.val());
    fd.append(PRODUCTO.STOCK, $campoStockCrear.val());
    fd.append(PRODUCTO.DESCRIPCION, $campoDescripcionCrear.val());
    fd.append(PRODUCTO.CATEGORIA_ID, $campoCategoriaCrear.val());
    fd.append(PRODUCTO.RUTA_IMAGEN, $campoImagenCrear.prop('files')[0]);

    insert(END_POINTS.PRODUCT.INSERT, fd, data => {
        $tablaProductos.row.add(
            new ProductRow(
                data[PRODUCTO.ID],
                $campoNombreCrear.val(),
                $campoPrecioCrear.val(),
                $campoMarcaCrear.val(),
                $campoStockCrear.val(),
                data[PRODUCTO.RUTA_IMAGEN],
                $('#categoria-producto-crear option:selected').text(),
                hasDeletePermission
            ).getRow()).draw();
        if (hasUpdatePermission) {
            $tablaProductos.on('click', 'tbody tr:last', openUpdateProduct);
        }
        clearFields();
    });
})

// Functions
function clearFields() {
    $campoNombreCrear.val('');
    $campoPrecioCrear.val('');
    $campoMarcaCrear.val('');
    $campoStockCrear.val('');
    $campoDescripcionCrear.val('');
    new PreviewImage('.img-container', 'imagen-producto-crear');
}