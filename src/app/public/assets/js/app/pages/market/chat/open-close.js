const $chatAbierto = $('#chat-abierto');
const $chatCerrado = $('#chat-cerrado');
const $chat = $('.chat');

$chatAbierto.on('click', () => {
    $chat.addClass('open-chat');
    $chatAbierto.addClass('hide');
    $chatCerrado.removeClass('hide');
})

$chatCerrado.on('click', () => {
    $chat.removeClass('open-chat');
    $chatCerrado.addClass('hide');
    $chatAbierto.removeClass('hide');
})