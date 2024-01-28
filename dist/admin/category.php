<?php
require_once __DIR__ . '/../api/utils/permissions.php';
require_once __DIR__ . '/../api/utils/http-status-codes.php';
require_once __DIR__ . '/../db/models/v_usuario_rol.php';
require_once __DIR__ . '/../db/crud.php';
session_start();
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
if (($permisos[v_usuario_rol::PERMISO_CATEGORIA] & PERMISSIONS::READ) == PERMISSIONS::NO_PERMISSIONS) {
  return http_response_code(NOT_FOUND);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categorías</title>
  <link rel="stylesheet" href="/assets/css/lib/bootstrap.min.css">
	<link rel="stylesheet" href="/assets/css/lib/jquery.dataTables.css">
  <link rel="stylesheet" href="/assets/css/globals.css">
  <link rel="stylesheet" href="/assets/css/admin.css">
  <link rel="stylesheet" href="/assets/css/modal.css">
  <link rel="stylesheet" href="/assets/css/utils.css">
  <script src="/assets/js/lib/jquery-3.7.1.min.js"></script>
  <script src="/assets/js/lib/bootstrap.bundle.min.js" defer></script>
	<script src="/assets/js/lib/jquery.dataTables.js"></script>
  <script src="/assets/js/admin/category/category.js" type="module" defer></script>
  <script src="/assets/js/admin/category/modals/modal-category-create.js" type="module" defer></script>
  <script src="/assets/js/admin/category/modals/modal-category-update.js" type="module" defer></script>
</head>
<body>
  <?php
  require_once __DIR__ . '/../views/admin/panel.php';
  ?>
  <main class="info-container">

    <div class="info" id="categoria">
     <table class="row-border hover" id="tabla-categorias">
       <thead>
        <th>ID</th>
        <th>Nombre</th>
        <?php
        if ($permisos[v_usuario_rol::PERMISO_CATEGORIA] & PERMISSIONS::DELETE) {
          echo '<th>Borrar</th>';
        }
        ?>
       </thead>
     </table>
        <div class="modal fade" id="modal-categoria-actualizar" tabindex="-1" aria-labelledby="modal-categoria-actualizar" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <form class="modal-content">
              <div class="modal__header">
                <h2 class="modal-title">Actualizar Categoría</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="modal-row">
                      <div class="modal-column">
                          <label for="nombre-categoria-actualizar">Nombre</label>
                          <input type="text" id="nombre-categoria-actualizar" class="form-control" required>
                          <div class="invalid-feedback">Introduzca un nombre de categoría</div>
                      </div>
                  </div>
                </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="actualizar-categoria">Actualizar</button>
              </div>
            </form>
          </div>
        </div>
        <div class="modal fade" id="modal-categoria-crear" tabindex="-1" aria-labelledby="modal-categoria-crear" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <form class="modal-content">
              <div class="modal__header">
                <h2 class="modal-title">Crear Categoría</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="modal-row">
                    <div class="modal-column">
                        <label for="nombre-categoria-crear">Categoría</label>
                        <input type="text" id="nombre-categoria-crear" class="form-control" required>
                        <div class="invalid-feedback">Introduzca un nombre de categoria</div>
                    </div>
                </div>
                </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="crear-categoria">Crear</button>
              </div>
            </form>
          </div>
        </div>
    </div>
  <?php
  if ($permisos[v_usuario_rol::PERMISO_CATEGORIA] & PERMISSIONS::READ) {
      echo '<button data-bs-toggle="modal" data-bs-target="#modal-categoria-crear" class="btn-crear">Crear</button>';
  }
  ?>
  </main>
</body>
</html>