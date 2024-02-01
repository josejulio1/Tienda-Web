$('.form-control').on('focusout', function() {
    // Si contiene texto, eliminar el error
    if ($(this).val()) {
        $(this).removeClass('is-invalid');
    }
})