<aside class="open-close-chat">
    <p id="notifications">0</p>
    <audio id="audio-notification">
        <source type="audio/mp3" src="/assets/audio/notification.mp3">
    </audio>
    <img src="/assets/img/web/svg/market/chat.svg" alt="Chat" id="chat-abierto">
    <img class="hide" src="/assets/img/web/svg/market/send.svg" alt="Chat" id="chat-cerrado">
</aside>
<aside id="chat-container">
    <section class="chats__container">
        <h2 class="chats__cabecera">Clientes</h2>
        <div id="chats"></div>
    </section>
    <section class="chat-mensajes__container">
        <article class="chat__cabecera">
            <img src="/assets/img/internal/default/default-avatar.jpg" alt="Imagen de Perfil del cliente">
            <p id="info-cliente-chat">Pepe Pérez</p>
        </article>
        <article id="chat__mensajes">
            <div class="mensaje__container">
                <img src="/assets/img/internal/default/default-avatar.jpg" alt="Imagen de Perfil del cliente">
                <p class="mensaje">Hola tengo un problema</p>
            </div>
            <div class="mensaje__container admin">
                <img src="/assets/img/internal/default/default-avatar.jpg" alt="Imagen de Perfil del cliente">
                <div class="mensaje">Qué sucede</div>
            </div>
        </article>
        <article class="enviar-mensaje__container">
            <input type="text" id="enviar-mensaje">
            <img src="/assets/img/web/svg/market/send.svg" alt="Enviar Mensaje" id="enviar-mensaje-button">
        </article>
    </section>
</aside>