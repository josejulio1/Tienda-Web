const $openChat = $('#chat-abierto');
const $closeChat = $('#chat-cerrado');
const $chatContainer = $('#chat-container');

$openChat.on('click', () => {
    $openChat.addClass('hide');
    $closeChat.removeClass('hide');
    $chatContainer.addClass('open-chat');
})

$closeChat.on('click', () => {
    $closeChat.addClass('hide');
    $openChat.removeClass('hide');
    $chatContainer.removeClass('open-chat');
})