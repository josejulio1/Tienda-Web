const $iniciarSesionOpcion = $('#iniciar-sesion-opcion');
const $registrarseOpcion = $('#registrarse-opcion');

// Cambiar de formulario
$('.opcion').on('click', e => {
    const { target } = e;
    if (target.classList.contains('opcion-seleccionada')) {
        return;
    }
    $('form.hide').removeClass('hide');
    $(`.${$('.opcion-seleccionada').attr('id').split('-')[0]}`).addClass('hide');
    $('.opcion-seleccionada').removeClass('opcion-seleccionada');
    target.classList.add('opcion-seleccionada');
})
/* $('.opcion').on('click', e => {
    const { target } = e;
    if (target.classList.contains('opcion-seleccionada')) {
        return;
    }
    const $form = $(`.${$('.opcion-seleccionada').attr('id').split('-')[0]}`);
    if ($form.attr('class').includes('login')) {
        $form.addClass('move-to-left');
        $form.on('animationend', moveToLeftListener)
    } else {
        $form.addClass('move-to-right');
        $form.on('animationend', moveToRightListener)
    }
    $('.opcion-seleccionada').removeClass('opcion-seleccionada');
    target.classList.add('opcion-seleccionada');
})

function moveToLeftListener(e) {
    const { target } = e;
    $('.move-to-right').removeClass('move-to-right');
    target.removeEventListener('animationend', moveToLeftListener);
}

function moveToRightListener(e) {
    const { target } = e;
    $('.move-to-left').removeClass('move-to-left');
    target.removeEventListener('animationend', moveToRightListener);
} */