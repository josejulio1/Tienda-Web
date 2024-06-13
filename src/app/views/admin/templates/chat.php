<aside class="open-close-chat">
    <p id="notifications">0</p>
    <audio id="audio-notification">
        <source type="audio/mp3" src="/assets/audio/notification.mp3">
    </audio>
    <img src="/assets/img/web/chat/chat.svg" alt="Chat" id="chat-abierto">
    <img class="hide" src="/assets/img/web/chat/send.svg" alt="Chat" id="chat-cerrado">
</aside>
<aside id="chat-container">
    <section class="chats__container">
        <h2 class="chats__cabecera">Clientes</h2>
        <div id="chats"></div>
    </section>
    <section class="chat-mensajes__container">
        <article class="chat__cabecera">
            <img src="/assets/img/internal/default/default-avatar.jpg" alt="Imagen de Perfil del cliente" id="imagen-perfil-cliente">
            <p id="info-cliente-chat">Usuario</p>
        </article>
        <article id="chat__mensajes"></article>
        <article class="enviar-mensaje__container">
            <input type="text" id="enviar-mensaje">
            <img src="/assets/img/web/chat/send.svg" alt="Enviar Mensaje" id="enviar-mensaje-button">
        </article>
    </section>
</aside>