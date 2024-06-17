const $modalChoice = $('#modal-choice');
const $modalChoiceAccept = $('#modal-choice-accept');
const $modalChoiceCancel = $('#modal-choice-cancel');

/**
 * Modal que se abre cuando se quiere eliminar una fila para pedir confirmación
 * de si se quiere realizar la operación. Debe usarse de forma asíncrona con un await.
 * Devolverá un true si se pulsa el botón de Aceptar y false si se pulsa el botón de Cancelar
 * @returns {Promise<unknown>} Devuelve una promesa que no es necesario recogerla
 */
export async function waitResolveModalChoice() {
    $modalChoice.modal('show');
    return await new Promise(resolve => {
        $modalChoiceAccept.on('click', () => {
            $modalChoice.modal('hide');
            resolve(true);
        });
        $modalChoiceCancel.on('click', () => {
            $modalChoice.modal('hide');
            resolve(false);
        });
    });
}