import { updateRow } from "../../../crud.js";
import { CATEGORIA } from "../../../models/models.js";
import { $tablaCategorias } from "../category.js";

export const $modalCategoriaActualizar = $('#modal-categoria-actualizar');

export const $campoCategoriaActualizar = $('#nombre-categoria-actualizar');
const $buttonActualizar = $('#actualizar-categoria');

$modalCategoriaActualizar.on('hide.bs.modal', () => {
    $('.lista-item-categoria[selected]').removeAttr('selected');
})

// Events
/* $campoCategoriaActualizar.on('focusout', removeErrors); */

$buttonActualizar.on('click', e => {
    e.preventDefault();

    if (!$campoCategoriaActualizar.val()) {
        $campoCategoriaActualizar.addClass('is-invalid');
        return
    }

    const fields = {
        [CATEGORIA.NOMBRE]: $campoCategoriaActualizar.val(),
    };
    const filters = {
        [CATEGORIA.ID]: $('tr[selected]').children()[0].textContent
    }

    updateRow(CATEGORIA.TABLE_NAME, fields, filters, () => {
        const id = $tablaCategorias.row($('tr[selected]')).index();
        $tablaCategorias.cell({row: id, column: 1}).data($campoCategoriaActualizar.val()).draw();
    });
})