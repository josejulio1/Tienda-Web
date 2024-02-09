import { updateRow } from "../../../crud.js";
import { PRODUCTO } from "../../../models/models.js";
import { $tablaProductos } from "../product.js";

export const $modalProductoActualizar = $('#modal-producto-actualizar');

export const $campoNombreActualizar = $('#nombre-producto-actualizar');
export const $campoPrecioActualizar = $('#precio-producto-actualizar');
export const $campoDescripcionActualizar = $('#descripcion-producto-actualizar');
export const $campoMarcaActualizar = $('#marca-producto-actualizar');
const $buttonActualizar = $('#actualizar-producto');

$buttonActualizar.on('click', e => {
    e.preventDefault();

    let hayErrores = false;
    if (!$campoNombreActualizar.val()) {
        $campoNombreActualizar.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoPrecioActualizar.val()) {
        $campoPrecioActualizar.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoDescripcionActualizar.val()) {
        $campoDescripcionActualizar.addClass('is-invalid');
        hayErrores = true;
    }

    if (!$campoMarcaActualizar.val()) {
        $campoMarcaActualizar.addClass('is-invalid');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }

    const fields = {
        [PRODUCTO.NOMBRE]: $campoNombreActualizar.val(),
        [PRODUCTO.PRECIO]: $campoPrecioActualizar.val(),
        [PRODUCTO.MARCA]: $campoMarcaActualizar.val(),
        [PRODUCTO.DESCRIPCION]: $campoDescripcionActualizar.val()
    }
    const filters = {
        [PRODUCTO.ID]: $('tr[selected]').children()[0].textContent
    }

    updateRow(PRODUCTO.TABLE_NAME, fields, filters, async () => {
        const id = $tablaProductos.row($('tr[selected]')).index();
        $tablaProductos.cell({row: id, column: 1}).data($campoNombreActualizar.val());
        $tablaProductos.cell({row: id, column: 2}).data($campoPrecioActualizar.val());
        $tablaProductos.cell({row: id, column: 3}).data($campoMarcaActualizar.val()).draw();
    });
})