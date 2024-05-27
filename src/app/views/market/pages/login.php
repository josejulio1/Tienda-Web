<section class="imagen"></section>
<main>
    <a href="/">BYTEMARKET</a>
    <section class="acceso-contenedor">
        <nav>
            <button id="login-cambio" class="opcion opcion-seleccionada">Iniciar Sesión</button>
            <button id="register-cambio" class="opcion">Registrarse</button>
        </nav>
        <article class="forms-contenedor">
            <form class="login selected">
                <div class="box-form">
                    <label for="correo-login">Correo</label>
                    <input type="email" id="correo-login" required placeholder="Ej: mi.correo@gmail.com">
                    <p class="is-invalid hide">Introduzca su correo electrónico</p>
                </div>
                <div class="box-form">
                    <label for="contrasenia-login">Contraseña</label>
                    <input type="password" id="contrasenia-login" required>
                    <p class="is-invalid hide">Introduzca su contraseña</p>
                </div>
                <!-- Componente: LoadingButton -->
                <button class="btn-info" type="submit" id="button-iniciar-sesion">Iniciar Sesión</button>
            </form>
            <form class="register">
                <div class="box-form">
                    <label for="nombre-register">Nombre</label>
                    <input type="text" id="nombre-register" required placeholder="Ej: Darío">
                    <p class="is-invalid hide">Introduzca su nombre</p>
                </div>
                <div class="box-form">
                    <label for="apellidos-register">Apellidos</label>
                    <input type="text" id="apellidos-register" required placeholder="Ej: Gómez">
                    <p class="is-invalid hide">Introduzca sus apellidos</p>
                </div>
                <div class="box-form">
                    <label for="telefono-register">Teléfono</label>
                    <input type="tel" id="telefono-register" required placeholder="Ej: +34 123456789">
                    <p class="is-invalid hide">Introduzca su teléfono</p>
                </div>
                <div class="box-form">
                    <label for="correo-register">Correo</label>
                    <input type="email" id="correo-register" required placeholder="Ej: dario.gomez@gmail.com">
                    <p class="is-invalid hide">Introduzca un correo electrónico</p>
                </div>
                <div class="box-form">
                    <label for="contrasenia-register">Contraseña</label>
                    <input type="password" id="contrasenia-register" required>
                    <p class="is-invalid hide">Introduzca una contraseña</p>
                </div>
                <div class="box-form">
                    <label>Foto de perfil (Opcional)</label>
                    <!-- COMPONENTE: PreviewImage -->
                    <label class="img-container" for="imagen-register"></label>
                </div>
                <!-- Componente: LoadingButton -->
                <button class="btn-info" type="submit" id="button-registrarse">Registrarse</button>
            </form>
        </article>
    </section>
</main>