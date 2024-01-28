<aside class="panel">
    <section class="info-usuario">
        <img src="<?php echo $_SESSION['ruta_imagen_perfil']; ?>" alt="Imagen Perfil Usuario">
        <p><?php echo $_SESSION['usuario']; ?></p>
        <p>(<?php echo $_SESSION['nombre_rol']; ?>)</p>
    </section>
    <section class="opciones">
        <?php
        if ($permisos[v_usuario_rol::PERMISO_USUARIO] != PERMISSIONS::NO_PERMISSIONS) {
            echo '<a href="#">Usuarios</a>';
        }
        if ($permisos[v_usuario_rol::PERMISO_PRODUCTO] != PERMISSIONS::NO_PERMISSIONS) {
            echo '<a href="#">Productos</a>';
        }
        if ($permisos[v_usuario_rol::PERMISO_CATEGORIA] != PERMISSIONS::NO_PERMISSIONS) {
            echo '<a href="#">Categorías</a>';
        }
        if ($permisos[v_usuario_rol::PERMISO_CLIENTE] != PERMISSIONS::NO_PERMISSIONS) {
            echo '<a href="#">Clientes</a>';
        }
        if ($permisos[v_usuario_rol::PERMISO_ROL] != PERMISSIONS::NO_PERMISSIONS) {
            echo '<a href="#">Roles</a>';
        }
        ?>
        <a href="#" id="cerrar-sesion">Cerrar Sesión</a>
    </section>
    <section class="dark-mode"></section>
</aside>