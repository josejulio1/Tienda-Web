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

// Al pulsar el CheckBox de marcar todo, marcar todos los CheckBox
$('.marcar-todo').on('change', e => {
    const { target: { id, checked } } = e;
    const splittedId = id.split('-')[2];
    let strActualizar;
    if (id.includes('actualizar')) {
        strActualizar = '-actualizar';
    }
    $(`#ver-permiso-${splittedId}${strActualizar}`).prop('checked', checked);
    $(`#crear-permiso-${splittedId}${strActualizar}`).prop('checked', checked);
    $(`#actualizar-permiso-${splittedId}${strActualizar}`).prop('checked', checked);
    $(`#eliminar-permiso-${splittedId}${strActualizar}`).prop('checked', checked);
})

$('.permiso-crear').on('change', checkVer);
$('.permiso-actualizar').on('change', checkVer);
$('.permiso-eliminar').on('change', checkVer);

/**
 * Marca el CheckBox "Ver Permiso" en caso de que se marque "Crear, Actualizar o Eliminar"
 * @param {Event} e CheckBox que accionó el evento
 * @returns En caso de que se haya desmarcado el CheckBox, no hará nada
 */
function checkVer(e) {
    const { target, target: { id } } = e;
    // Si se desmarca, no hacer nada
    if (!target.checked) {
        return;
    }
    // Si es del modal de actualizar, cambiar el ID para coger la referencia del modal de actualizar
    $(`#ver-permiso-${id.split('-')[2]}${id.includes('-actualizar') ? '-actualizar' : ''}`).prop('checked', true);
}