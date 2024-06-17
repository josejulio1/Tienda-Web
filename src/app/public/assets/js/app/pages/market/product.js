import {InfoWindow} from "../../components/InfoWindow.js";
import {ajax} from "../../api/ajax.js";
import {END_POINTS} from "../../api/end-points.js";
import {COMENTARIO} from "../../api/models.js";
import {HTTP_STATUS_CODES} from "../../api/http-status-codes.js";
import {CommentItem} from "./components/CommentItem.js";
import {Validators} from "../../services/Validators.js";

// Fichero que contiene la lógica para realizar un comentario en un producto (también el funcionamiento de escoger valoración),
// poder ver la descripción y comentarios de un producto

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
    if (!comentario || !Validators.isNotXss(comentario)) {
        InfoWindow.make('Escriba una descripción');
        return;
    }

    const productoId = new URLSearchParams(window.location.search).get('id');
    const numEstrellas = estrellaSeleccionada + 1;
    const formData = new FormData();
    formData.append(COMENTARIO.PRODUCTO_ID, productoId);
    formData.append(COMENTARIO.COMENTARIO, comentario);
    formData.append(COMENTARIO.NUM_ESTRELLAS, `${numEstrellas}`);
    const response = await ajax(END_POINTS.COMENTARIO, 'POST', formData);
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
        $(this).attr('src', '/assets/img/web/market/comment/star-filled.svg');
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
        $(this).attr('src', '/assets/img/web/market/comment/star-no-filled.svg');
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
        $(this).attr('src', '/assets/img/web/market/comment/star-no-filled.svg');
    })
    // Realizar de nuevo la selección hasta la estrella seleccionada
    $estrellasContainerChildren.each(function() {
        $(this).attr('src', '/assets/img/web/market/comment/star-filled.svg');
        if ($(this).attr('id') === 'spotted-star') {
            return false;
        }
    })
})