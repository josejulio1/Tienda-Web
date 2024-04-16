import { $tablaMarcas, hasDeletePermission } from "../brand.js";
import { insert } from "../../../../crud/crud.js";
import { END_POINTS } from "../../../../api/end-points.js";
import { openUpdateBrand } from "../brand.js";
import {MARCA} from "../../../../crud/models.js";
import { XSS_REGEX } from "../../../../helpers/regex.js";
import {BrandRow} from "../../../models/row/BrandRow.js";

const $campoMarcaCrear = $('#nombre-marca-crear');
const $buttonCrear = $('#crear-marca');

$buttonCrear.on('click', e => {
    e.preventDefault();

    if (!$campoMarcaCrear.val() || XSS_REGEX.test($campoMarcaCrear.val())) {
        $campoMarcaCrear.addClass('is-invalid');
        return;
    }

    const fd = new FormData();
    fd.append(MARCA.MARCA, $campoMarcaCrear.val());

    insert(END_POINTS.BRAND.INSERT, fd, data => {
        $tablaMarcas.row.add(
            new BrandRow(
                data[MARCA.ID],
                $campoMarcaCrear.val(),
                hasDeletePermission
            ).getRow()).draw();
        if (hasDeletePermission) {
            $('#tabla-marcas tbody tr:last').on('click', openUpdateBrand);
        }
        clearFields();
    });
})

// Functions
function clearFields() {
    $campoMarcaCrear.val('');
}