<?php
session_start();
if (!$_SESSION) {
    header('Location: /admin/auth.php');
}

require_once __DIR__ . '/../db/crud.php';
require_once __DIR__ . '/../db/utils/utils.php';
require_once __DIR__ . '/../db/models/v_usuario_rol.php';
require_once __DIR__ . '/../db/models/rol.php';
require_once __DIR__ . '/../api/utils/permissions.php';

$permisos = select(v_usuario_rol::class, [
  v_usuario_rol::PERMISO_CATEGORIA,
  v_usuario_rol::PERMISO_PRODUCTO,
  v_usuario_rol::PERMISO_CLIENTE,
  v_usuario_rol::PERMISO_USUARIO,
  v_usuario_rol::PERMISO_ROL
], [
  TypesFilters::EQUALS => [
      v_usuario_rol::CORREO => $_SESSION[v_usuario_rol::CORREO]
  ]
])[0];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Panel de Administrador">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="/assets/css/lib/bootstrap.min.css">
	  <link rel="stylesheet" href="/assets/css/lib/jquery.dataTables.css">
    <link rel="stylesheet" href="/assets/css/globals.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="/assets/css/modal.css">
    <link rel="stylesheet" href="/assets/css/utils.css">
    <script src="/assets/js/lib/jquery-3.7.1.min.js"></script>
    <script src="/assets/js/lib/bootstrap.bundle.min.js" defer></script>
	  <script src="/assets/js/lib/jquery.dataTables.js"></script>
    <!-- <script src="/assets/js/components/preview-image.js" defer></script> -->
    <script src="/assets/js/admin/panel.js" type="module" defer></script>
    <!-- USER -->
    <script src="/assets/js/admin/user/user.js" type="module" defer></script>
    <script src="/assets/js/admin/user/modals/modal-user-create.js" type="module" defer></script>
    <script src="/assets/js/admin/user/modals/modal-user-update.js" type="module" defer></script>
    <!-- CATEGORY -->
    <script src="/assets/js/admin/category/category.js" type="module" defer></script>
    <script src="/assets/js/admin/category/modals/modal-category-create.js" type="module" defer></script>
    <script src="/assets/js/admin/category/modals/modal-category-update.js" type="module" defer></script>
</head>
<body>
    <?php
    require_once __DIR__ . '/../views/admin/panel.php';
    ?>
    <main class="info-container">
        <?php
        /* require_once __DIR__ . '/../views/admin/user.php'; */
        require_once __DIR__ . '/../views/admin/product.php';
        /* require_once __DIR__ . '/../views/admin/category.php'; */
        ?>
    </main>
    <div class="modal fade" id="modal-info" tabindex="-1" aria-labelledby="modal-info" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
              <img id="modal-info-correcto" class="hide" src="/assets/img/web/svg/success.svg" alt="Correcto">
              <img id="modal-info-incorrecto" class="hide" src="/assets/img/web/svg/error.svg" alt="Error">
              <p id="modal-info-mensaje"></p>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-choice" tabindex="-1" aria-labelledby="modal-choice" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
              <img src="/assets/img/web/svg/choice.svg" alt="Decisión">
              <div class="modal-body__info">
                <p>¿Está seguro de que desea eliminar el registro?</p>
                <p class="modal-body__info--important">No podrá revertir los cambios</p>
              </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" id="modal-choice-accept">Aceptar</button>
            <button class="btn btn-secondary" id="modal-choice-cancel">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
</body>
</html>