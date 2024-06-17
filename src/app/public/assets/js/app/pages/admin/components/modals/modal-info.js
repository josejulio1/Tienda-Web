export const $modalInfo = $('#modal-info');
const $modalInfoCorrecto = $('#modal-info-correcto');
const $modalInfoIncorrecto = $('#modal-info-incorrecto');
const $modalInfoMensaje = $('#modal-info-mensaje');

/**
 * Esconde todos los modales abiertos en el panel de administración
 */
function hideAll() {
    $modalInfoCorrecto.addClass('hide');
    $modalInfoIncorrecto.addClass('hide');
}

/**
 * Abre el modal de operación realizada con éxito
 * @param message {string} Nombre que mostrar en el modal (se coge del backend)
 */
export function correctModal(message) {
    hideAll();
    $modalInfoCorrecto.removeClass('hide');
    $modalInfoMensaje.text(message);
}

/**
 * Abre el modal de operación con error
 * @param message {string} Nombre que mostrar en el modal (se coge del backend)
 */
export function incorrectModal(message) {
    hideAll();
    $modalInfoIncorrecto.removeClass('hide');
    $modalInfoMensaje.text(message);
}