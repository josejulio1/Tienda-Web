import { $tablaCategorias, hasDeletePermission } from "../category.js";
import { insert } from "../../crud.js";
import { END_POINTS } from "../../../api/end-points.js";
import { CategoryRow } from "../../models/row/CategoryRow.js";
import { openUpdateCategory } from "../category.js";

const $campoCategoriaCrear = $('#nombre-categoria-crear');

$buttonCrear.on('click', e => {
    e.preventDefault();

    if (!$campoCategoriaCrear.val()) {
        $campoCategoriaCrear.addClass('is-invalid');
        return;
    }

    const fields = [$campoCategoriaCrear];

    insert(END_POINTS.CATEGORY.INSERT, fields, data => {
        $tablaCategorias.row.add(new CategoryRow(data.categoria_id, $campoCategoriaCrear.val(), hasDeletePermission).getRow()).draw();
        if (hasDeletePermission) {
            $('#tabla-categorias tbody tr:last').on('click', openUpdateCategory);
        }
        clearFields();
    });
})

// Functions
function clearFields() {
    $campoCategoriaCrear.val('');
    $campoCorreoCrear.val('');
    $campoContraseniaCrear.val('');
    $campoImagenCrear.val('');
}