<main class="no-overflow">
    <form id="login-form">
        <section class="security">
            <img src="/assets/img/web/admin/auth/lock.svg" alt="Candado">
        </section>
        <section class="form-row">
            <article class="form-column">
                <label for="correo">Correo</label>
                <input type="email" id="correo">
                <div class="is-invalid hide">Introduzca un correo válido</div>
            </article>
        </section>
        <section class="form-row">
            <article class="form-column">
                <label for="contrasenia">Contraseña</label>
                <input type="password" id="contrasenia">
                <div class="is-invalid hide">Introduzca una contraseña válida</div>
            </article>
        </section>
        <section class="form-row">
            <article class="form-column checkbox-column">
                <input type="checkbox" id="mantener-sesion">
                <label for="mantener-sesion">Mantener sesión iniciada</label>
            </article>
        </section>
        <!-- COMPONENTE: LoadingButton -->
        <button class="btn-info" type="submit">Iniciar Sesión</button>
    </form>
</main>