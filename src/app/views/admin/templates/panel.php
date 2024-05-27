<?php
use Util\Permission\Permissions;
?>
<aside class="panel">
    <section class="panel--info">
        <section class="info-usuario">
            <img src="<?php echo $userInfo -> ruta_imagen_perfil; ?>" alt="Imagen Perfil Usuario">
            <p><?php echo $userInfo -> usuario; ?></p>
            <p>(<?php echo $userInfo -> nombre_rol; ?>)</p>
        </section>
        <section class="opciones">
            <?php
            if ($userInfo -> permiso_usuario != Permissions::NO_PERMISSIONS) {
                echo '<a href="/admin/user">Usuarios</a>';
            }
            if ($userInfo -> permiso_producto != Permissions::NO_PERMISSIONS) {
                echo '<a href="/admin/product">Productos</a>';
            }
            if ($userInfo -> permiso_marca != Permissions::NO_PERMISSIONS) {
                echo '<a href="/admin/brand">Marcas</a>';
            }
            if ($userInfo -> permiso_categoria != Permissions::NO_PERMISSIONS) {
                echo '<a href="/admin/category">Categorías</a>';
            }
            if ($userInfo -> permiso_cliente != Permissions::NO_PERMISSIONS) {
                echo '<a href="/admin/customer">Clientes</a>';
            }
            if ($userInfo -> permiso_rol != Permissions::NO_PERMISSIONS) {
                echo '<a href="/admin/role">Roles</a>';
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