<aside class="panel">
    <section class="info-usuario">
        <img src="<?php echo $userInfo[v_usuario_rol::RUTA_IMAGEN_PERFIL]; ?>" alt="Imagen Perfil Usuario">
        <p><?php echo $userInfo[v_usuario_rol::USUARIO]; ?></p>
        <p>(<?php echo $userInfo[v_usuario_rol::NOMBRE_ROL]; ?>)</p>
    </section>
    <section class="opciones">
        <?php
        if ($userInfo[v_usuario_rol::PERMISO_USUARIO] != PERMISSIONS::NO_PERMISSIONS) {
            echo '<a href="user.php">Usuarios</a>';
        }
        if ($userInfo[v_usuario_rol::PERMISO_PRODUCTO] != PERMISSIONS::NO_PERMISSIONS) {
            echo '<a href="product.php">Productos</a>';
        }
        if ($userInfo[v_usuario_rol::PERMISO_CATEGORIA] != PERMISSIONS::NO_PERMISSIONS) {
            echo '<a href="category.php">Categorías</a>';
        }
        if ($userInfo[v_usuario_rol::PERMISO_CLIENTE] != PERMISSIONS::NO_PERMISSIONS) {
            echo '<a href="customer.php">Clientes</a>';
        }
        if ($userInfo[v_usuario_rol::PERMISO_ROL] != PERMISSIONS::NO_PERMISSIONS) {
            echo '<a href="rol.php">Roles</a>';
        }
        ?>
        <a href="#" id="cerrar-sesion">Cerrar Sesión</a>
    </section>
    <section class="dark-mode"></section>
</aside>