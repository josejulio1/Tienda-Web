import { $campoPrecioActualizar, $campoMarcaActualizar, $campoNombreActualizar, $modalProductoActualizar, $campoDescripcionActualizar } from "./modals/modal-product-update.js";
import { PRODUCTO, V_PRODUCTO_CATEGORIA } from "../../models/models.js";
import { deleteRow, select } from "../../crud.js";
import { ProductRow } from "../../models/row/ProductRow.js";
import { PERMISSIONS } from "../../../api/permissions.js";
import { PreviewImage } from "../../../components/PreviewImage.js";
import { TYPE_FILTERS } from "../../models/utils.js";

export let hasUpdatePermission, hasDeletePermission;
export let $tablaProductos;

// Cargar la página
window.addEventListener('load', async () => {
    $tablaProductos = $('#tabla-productos').DataTable();
    const json = await select(V_PRODUCTO_CATEGORIA.TABLE_NAME, [
        V_PRODUCTO_CATEGORIA.PRODUCTO_ID,
        V_PRODUCTO_CATEGORIA.NOMBRE,
        V_PRODUCTO_CATEGORIA.PRECIO,
        V_PRODUCTO_CATEGORIA.MARCA,
        V_PRODUCTO_CATEGORIA.STOCK,
        V_PRODUCTO_CATEGORIA.RUTA_IMAGEN,
        V_PRODUCTO_CATEGORIA.NOMBRE_CATEGORIA
    ], null, true);
    const { data: products } = json;
    hasUpdatePermission = json['has-update-permission'] != PERMISSIONS.NO_PERMISSIONS;
    hasDeletePermission = json['has-delete-permission'] != PERMISSIONS.NO_PERMISSIONS;
    for (const product of products) {
        $tablaProductos.row.add(new ProductRow(product.producto_id, product.nombre,
            product.precio, product.marca, product.stock,
            product.ruta_imagen, product.nombre_categoria, hasDeletePermission).getRow());
    }
    $tablaProductos.draw();
    $tablaProductos.tableName = PRODUCTO.TABLE_NAME;
    if (hasUpdatePermission) {
        // Al pulsar una fila, abrir el modal de actualizar
        $tablaProductos.on('click', 'tbody tr', openUpdateProduct);
    }
    // Eliminar fila
    $tablaProductos.on('click', '.eliminar-producto', e => deleteRow(e, $tablaProductos));
    // Componente de previsualización de imagen
    new PreviewImage('.img-container', 'imagen-producto-crear');
})


/**
 * Al abrir una fila para actualizarla, coloca los campos de la fila en el modal de actualizar
 */
export async function openUpdateProduct() {
    $modalProductoActualizar.modal('show');
    $(this).attr('selected', '');
    const children = $(this).children();
    $campoNombreActualizar.val(children[1].textContent);
    $campoPrecioActualizar.val(parseFloat(children[2].textContent));
    $campoMarcaActualizar.val(children[3].textContent);
    const descripcionProducto = await select(PRODUCTO.TABLE_NAME, [PRODUCTO.DESCRIPCION], {
        [TYPE_FILTERS.EQUALS]: {
            [PRODUCTO.ID]: $('tr[selected]').children()[0].textContent
        }
    })
    $campoDescripcionActualizar.val(descripcionProducto[0].descripcion);
}