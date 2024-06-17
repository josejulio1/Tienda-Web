/**
 * Baja hacia abajo del todo en un chat cada vez que se manda un mensaje
 */
export function scrollDown() {
    const $chatMensajesJs = document.getElementById('chat__mensajes');
    $chatMensajesJs.scrollTo(0, $chatMensajesJs.scrollHeight);
}