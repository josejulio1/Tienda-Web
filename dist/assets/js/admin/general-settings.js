// Eliminar mensaje de error al quitar el foco
$('.form-control').on('focusout', function() {
    // Si contiene texto, eliminar el error
    if ($(this).val()) {
        $(this).removeClass('is-invalid');
    }
})

// Al cerrar un modal de actualizar, eliminar el atributo selected de la fila que se seleccionó
$('.modal-unique').on('hide.bs.modal', () => {
    $('tr[selected]').removeAttr('selected');
})