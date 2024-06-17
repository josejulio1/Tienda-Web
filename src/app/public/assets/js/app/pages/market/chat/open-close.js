const $chatAbierto = $('#chat-abierto');
const $chatCerrado = $('#chat-cerrado');
const $chat = $('.chat');

// Realiza el funcionamiento de la animación de apertura-cierre del chat

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