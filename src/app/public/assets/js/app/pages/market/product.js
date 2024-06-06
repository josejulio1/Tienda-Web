import {InfoWindow} from "../../components/InfoWindow.js";
import {ajax} from "../../api/ajax.js";
import {END_POINTS} from "../../api/end-points.js";
import {COMENTARIO} from "../../api/models.js";
import {HTTP_STATUS_CODES} from "../../api/http-status-codes.js";
import {CommentItem} from "./components/CommentItem.js";

const $descripcionProducto = $('#descripcion-producto');
const $comentarios = $('#comentarios');
const $comentarioEstrellas = $('.aniadir-comentario__container .comentario__item--estrella');
const $comentario = $('#comentario');
const $comentarButton = $('#comentar');
let estrellaSeleccionada = -1;

// Conmutador para cambiar entre descripción y comentarios
$('.switcher').on('click', function() {
    $('.switcher-item:not(.hide)').addClass('hide');
    $(`#${$(this).attr('switcher-item-id')}`).removeClass('hide');
})

$comentarButton.on('click', async () => {
    if (estrellaSeleccionada === -1) {
        InfoWindow.make('Debes de elegir un número de estrellas');
        return;
    }

    const comentario = $comentario.val();
    if (!comentario) {
        InfoWindow.make('Escriba una descripción');
        return;
    }

    const productoId = new URLSearchParams(window.location.search).get('id');
    const numEstrellas = estrellaSeleccionada + 1;
    const Comentario = {
        [COMENTARIO.PRODUCTO_ID]: productoId,
        [COMENTARIO.COMENTARIO]: comentario,
        [COMENTARIO.NUM_ESTRELLAS]: numEstrellas
    }
    const response = await ajax(END_POINTS.COMENTARIO, 'POST', Comentario);
    if (response.status !== HTTP_STATUS_CODES.OK) {
        InfoWindow.make(response.message);
        return;
    }
    const { data: { cliente } } = response;
    $comentarios.prepend(
        new CommentItem(cliente).getItem()
    )
    $('.aniadir-comentario__container').remove();
    $('.separador-comentario').remove();
    $('#no-comentarios').remove();
})

$comentarioEstrellas.on('mouseenter', function() {
    // Si hay una estrella seleccionada, no quitar color de la estrella al entrar con el ratón
    if ($('#spotted-star').length) {
        return;
    }

    const $estrellasContainerChildren = $(this).closest('.comentario__item--estrellas').children();
    const $estrellaSeleccionadaIndex = $(this).index();
    $estrellasContainerChildren.each(function(i) {
        $(this).attr('src', '/assets/img/web/svg/star-filled.svg');
        if (i === $estrellaSeleccionadaIndex) {
            return false;
        }
    })
})

$comentarioEstrellas.on('mouseleave', function() {
    // Si hay una estrella seleccionada, no quitar color de la estrella al salir con el ratón
    if ($('#spotted-star').length) {
        return;
    }

    const $estrellasContainerChildren = $(this).closest('.comentario__item--estrellas').children();
    $estrellasContainerChildren.each(function() {
        $(this).attr('src', '/assets/img/web/svg/star-no-filled.svg');
    })
})

$comentarioEstrellas.on('click', function() {
    const $spottedStar = $('#spotted-star');
    if ($spottedStar) {
        $spottedStar.attr('id', '');
    }
    $(this).attr('id', 'spotted-star');
    estrellaSeleccionada = $(this).index();
    const $estrellasContainerChildren = $(this).closest('.comentario__item--estrellas').children();
    // Deseleccionar todas las estrellas
    $estrellasContainerChildren.each(function() {
        $(this).attr('src', '/assets/img/web/svg/star-no-filled.svg');
    })
    // Realizar de nuevo la selección hasta la estrella seleccionada
    $estrellasContainerChildren.each(function() {
        $(this).attr('src', '/assets/img/web/svg/star-filled.svg');
        if ($(this).attr('id') === 'spotted-star') {
            return false;
        }
    })
})

// Recoger descripción del producto y los comentarios acerca del producto
/*
window.addEventListener('load', async () => {
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
})*/
