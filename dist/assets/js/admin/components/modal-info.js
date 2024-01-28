export const $modalInfo = $('#modal-info');
export const $modalInfoCorrecto = $('#modal-info-correcto');
export const $modalInfoIncorrecto = $('#modal-info-incorrecto');
export const $modalInfoMensaje = $('#modal-info-mensaje');

function hideAll() {
    $modalInfoCorrecto.addClass('hide');
    $modalInfoIncorrecto.addClass('hide');
}

export function correctModal(message) {
    hideAll();
    $modalInfoCorrecto.removeClass('hide');
    $modalInfoMensaje.text(message);
}

export function incorrectModal(message) {
    hideAll();
    $modalInfoIncorrecto.removeClass('hide');
    $modalInfoMensaje.text(message);
}