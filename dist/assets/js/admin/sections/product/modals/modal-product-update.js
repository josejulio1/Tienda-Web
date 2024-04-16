import { XSS_REGEX } from "../../../../helpers/regex.js";
import { updateRow } from "../../../../crud/crud.js";
import { PRODUCTO } from "../../../../crud/models.js";
import { $tablaProductos } from "../product.js";

export const $modalProductoActualizar = $('#modal-producto-actualizar');

export const $campoNombreActualizar = $('#nombre-producto-actualizar');
export const $campoPrecioActualizar = $('#precio-producto-actualizar');
export const $campoDescripcionActualizar = $('#descripcion-producto-actualizar');
export const $campoMarcaActualizar = $('#marca-producto-actualizar');
export const $campoMarcaProductoActualizarOptions = $('#marca-producto-actualizar option');
const $buttonActualizar = $('#actualizar-producto');

$modalProductoActualizar.on('hide.bs.modal', () => {
    $('#modal-producto-actualizar option[selected]').removeAttr('selected');
})

$buttonActualizar.on('click', e => {
    e.preventDefault();

    let hayErrores = false;
    const nombre = $campoNombreActualizar.val();
    if (!nombre || XSS_REGEX.test(nombre)) {
        $campoNombreActualizar.addClass('is-invalid');
        hayErrores = true;
    }

    const precio = $campoPrecioActualizar.val();
    if (!precio || XSS_REGEX.test(precio) || precio < 1) {
        $campoPrecioActualizar.addClass('is-invalid');
        hayErrores = true;
    }

    const descripcion = $campoDescripcionActualizar.val();
    if (!descripcion || XSS_REGEX.test(descripcion)) {
        $campoDescripcionActualizar.addClass('is-invalid');
        hayErrores = true;
    }

    const marca = $campoMarcaActualizar.val();
    if (!marca || XSS_REGEX.test(marca)) {
        $campoMarcaActualizar.addClass('is-invalid');
        hayErrores = true;
    }

    if (hayErrores) {
        return;
    }

    const fields = {
        [PRODUCTO.NOMBRE]: nombre,
        [PRODUCTO.PRECIO]: precio,
        [PRODUCTO.MARCA_ID]: marca,
        [PRODUCTO.DESCRIPCION]: descripcion
    }
    const filters = {
        [PRODUCTO.ID]: $('tr[selected]').children()[0].textContent
    }

    updateRow(PRODUCTO.TABLE_NAME, fields, filters, async () => {
        const id = $tablaProductos.row($('tr[selected]')).index();
        $tablaProductos.cell({row: id, column: 1}).data(nombre);
        $tablaProductos.cell({row: id, column: 2}).data(precio);
        $tablaProductos.cell({row: id, column: 3}).data($('#marca-producto-actualizar option:selected').text()).draw();
    });
})