<aside class="panel">
    <section class="panel--info">
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
            if ($userInfo[v_usuario_rol::PERMISO_MARCA] != PERMISSIONS::NO_PERMISSIONS) {
                echo '<a href="brand.php">Marcas</a>';
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
        <?php
        require_once __DIR__ . '/../../templates/dark-mode.php';
        ?>
    </section>
    <section class="open-close-panel">
        <img src="/assets/img/web/svg/arrow-left.svg" alt="Abrir-Cerrar Panel">
    </section>
</aside>