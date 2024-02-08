$('.marcar-todo').on('click', e => {
    const { target: { id } } = e;
    const nombrePagina = id.split('-')[2];
    $(`#ver-permiso-${nombrePagina}`).prop('checked', true);
    $(`#crear-permiso-${nombrePagina}`).prop('checked', true);
    $(`#actualizar-permiso-${nombrePagina}`).prop('checked', true);
    $(`#eliminar-permiso-${nombrePagina}`).prop('checked', true);
})

// Cambiar de página
$('.btn-permiso').on('click', e => {
    e.preventDefault();
    const { target } = e;
    $('.btn-permiso.selected-button').removeClass('selected-button');
    target.classList.add('selected-button');
    // Ocultar página que esté mostrándose
    $('.contenedor-permiso:not(.hide)').addClass('hide');
    $(`.contenedor-${target.id}`).removeClass('hide');
})

const palabrasClaveMarcarVer = ['crear', 'actualizar', 'eliminar'];
// Si se marca crear, actualizar o eliminar, también dar permisos de ver
$('input[type=checkbox]').on('click', e => {
    const { target: { id } } = e;
    for (const palabraClave of palabrasClaveMarcarVer) {
        if (id.includes(palabraClave)) {
            $(`#ver-permiso-${id.split('-')[2]}`).prop('checked', true);
            break;
        }
    }
})