import { select } from "../crud/crud.js";
import { PRODUCTO, V_COMENTARIO_CLIENTE_PRODUCTO } from "../crud/models.js";
import { TYPE_FILTERS } from "../crud/utils.js";
import { CommentItem } from "./models/CommentItem.js";

const $descripcionProducto = $('#descripcion-producto');
const $comentarios = $('#comentarios');
const $noComentarios = $('#no-comentarios');

// Conmutador para cambiar entre descripción y comentarios
$('.switcher').on('click', function() {
    $('.switcher-item:not(.hide)').addClass('hide');
    $(`#${$(this).attr('switcher-item-id')}`).removeClass('hide');
})

// Recoger descripción del producto y los comentarios acerca del producto
window.addEventListener('load', async () => {
    // Descripción
    const productoId = new URLSearchParams(window.location.search).get('id');
    const jsonDescripcion = await select(PRODUCTO.TABLE_NAME, [PRODUCTO.DESCRIPCION], {
        [TYPE_FILTERS.EQUALS]: {
            [PRODUCTO.ID]: productoId
        }
    });
    $descripcionProducto.html(jsonDescripcion[0][PRODUCTO.DESCRIPCION]);

    // Comentarios
    const jsonComentarios = await select(V_COMENTARIO_CLIENTE_PRODUCTO.TABLE_NAME, [
        V_COMENTARIO_CLIENTE_PRODUCTO.NOMBRE_CLIENTE,
        V_COMENTARIO_CLIENTE_PRODUCTO.APELLIDOS_CLIENTE,
        V_COMENTARIO_CLIENTE_PRODUCTO.RUTA_IMAGEN_PERFIL,
        V_COMENTARIO_CLIENTE_PRODUCTO.COMENTARIO,
        V_COMENTARIO_CLIENTE_PRODUCTO.NUM_ESTRELLAS,
    ], {
        [TYPE_FILTERS.EQUALS]: {
            [V_COMENTARIO_CLIENTE_PRODUCTO.PRODUCTO_ID]: productoId
        }
    });
    // En caso de no haber comentarios, no hacer nada
    if (jsonComentarios.length === 0) {
        return;
    }
    $noComentarios.addClass('hide');
    $comentarios.removeClass('hide');
    for (const comentario of jsonComentarios) {
        $comentarios.append(
            new CommentItem(
                comentario[V_COMENTARIO_CLIENTE_PRODUCTO.RUTA_IMAGEN_PERFIL],
                comentario[V_COMENTARIO_CLIENTE_PRODUCTO.NOMBRE_CLIENTE],
                comentario[V_COMENTARIO_CLIENTE_PRODUCTO.APELLIDOS_CLIENTE],
                comentario[V_COMENTARIO_CLIENTE_PRODUCTO.NUM_ESTRELLAS],
                comentario[V_COMENTARIO_CLIENTE_PRODUCTO.COMENTARIO],
            ).getItem()
        );
    }
})