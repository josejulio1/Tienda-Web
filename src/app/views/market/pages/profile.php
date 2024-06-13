<header>
    <?php
    require_once __DIR__ . '/../templates/nav.php';
    ?>
</header>
<main class="perfil">
    <section class="info-perfil">
        <article id="no-guardado" class="hide">
            <img src="/assets/img/web/market/profile/no-saved.svg" alt="Sin Guardar">
            <p>Sin Guardar</p>
        </article>
        <article class="imagen-perfil">
            <img src="<?php echo $cliente -> ruta_imagen_perfil; ?>" alt="Imagen Perfil" id="imagen-perfil">
            <label for="imagen" class="editar-imagen-perfil">
                <img src="/assets/img/web/market/profile/square-add.svg" alt="Cambiar Imagen Perfil" class="hide">
                <input type="file" id="imagen" class="hide">
            </label>
        </article>
        <h3><?php echo $cliente -> correo; ?></h3>
    </section>
    <section class="campos-perfil">
        <h2>Mis datos</h2>
        <article class="datos">
            <div class="columna">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="<?php echo $cliente -> nombre; ?>">
                <div class="invalid-feedback hide">Introduzca un nombre correcto</div>
            </div>
            <div class="columna">
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" placeholder="<?php echo $cliente -> apellidos; ?>">
                <div class="invalid-feedback hide">Introduzca unos apellidos correctos</div>
            </div>
            <div class="columna">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" placeholder="<?php echo $cliente -> telefono; ?>">
                <div class="invalid-feedback hide">Introduzca un número de teléfono correcto</div>
            </div>
            <div class="columna">
                <label for="contrasenia">Nueva Contraseña</label>
                <input type="password" id="contrasenia">
                <div class="invalid-feedback hide">Introduzca una contraseña correcta</div>
            </div>
        </article>
    </section>
</main>
<aside class="guardar">
    <button id="guardar-cambios">Guardar Cambios</button>
</aside>
<?php
require_once __DIR__ . '/../templates/chat.php';