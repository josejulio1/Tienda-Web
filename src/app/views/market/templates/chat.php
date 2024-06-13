<?php
use Util\Auth\RoleAccess;
if ($_SESSION && $_SESSION['rol'] === RoleAccess::CUSTOMER) { ?>
    <aside class="chat-container">
        <section class="chat">
            <h2>Chat BYTEMARKET</h2>
            <section class="chat__detalles">
                <article id="chat__mensajes"></article>
                <article class="enviar-mensaje">
                    <input type="text" id="enviar-mensaje" placeholder="Introduzca su mensaje...">
                    <img src="/assets/img/web/chat/send.svg" alt="Enviar Mensaje" id="enviar-mensaje-button">
                </article>
            </section>
        </section>
        <section class="chat-container__open-close">
            <img src="/assets/img/web/chat/chat.svg" alt="Chat" id="chat-abierto">
            <img class="hide" src="/assets/img/web/chat/send.svg" alt="Chat" id="chat-cerrado">
        </section>
    </aside>
    <?php
}