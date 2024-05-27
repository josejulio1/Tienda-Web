const $modalChoice = $('#modal-choice');
const $modalChoiceAccept = $('#modal-choice-accept');
const $modalChoiceCancel = $('#modal-choice-cancel');

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