import { $tablaCategorias, hasDeletePermission } from "../brand.js";
import { insert } from "../../../../crud/crud.js";
import { END_POINTS } from "../../../../api/end-points.js";
import { CategoryRow } from "../../../models/row/CategoryRow.js";
import { openUpdateCategory } from "../brand.js";
import { CATEGORIA } from "../../../../crud/models.js";
import { XSS_REGEX } from "../../../../helpers/regex.js";

const $campoCategoriaCrear = $('#nombre-categoria-crear');
const $buttonCrear = $('#crear-categoria');

$buttonCrear.on('click', e => {
    e.preventDefault();

    if (!$campoCategoriaCrear.val() || XSS_REGEX.test($campoCategoriaCrear.val())) {
        $campoCategoriaCrear.addClass('is-invalid');
        return;
    }

    const fd = new FormData();
    fd.append(CATEGORIA.NOMBRE, $campoCategoriaCrear.val());

    insert(END_POINTS.CATEGORY.INSERT, fd, data => {
        $tablaCategorias.row.add(
            new CategoryRow(
                data[CATEGORIA.ID],
                $campoCategoriaCrear.val(),
                hasDeletePermission
            ).getRow()).draw();
        if (hasDeletePermission) {
            $('#tabla-categorias tbody tr:last').on('click', openUpdateCategory);
        }
        clearFields();
    });
})

// Functions
function clearFields() {
    $campoCategoriaCrear.val('');
}