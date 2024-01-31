<?php
require_once __DIR__ . '/../templates/admin/essentials.php';
require_once __DIR__ . '/../api/utils/permissions.php';
if (($userInfo[v_usuario_rol::PERMISO_CATEGORIA] & PERMISSIONS::READ) == PERMISSIONS::NO_PERMISSIONS) {
  return http_response_code(NOT_FOUND);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categorías</title>
  <?php
  require_once __DIR__ . '/../templates/admin/html-imports.php';
  ?>
  <script src="/assets/js/admin/sections/category/category.js" type="module" defer></script>
  <script src="/assets/js/admin/sections/category/modals/modal-category-create.js" type="module" defer></script>
  <script src="/assets/js/admin/sections/category/modals/modal-category-update.js" type="module" defer></script>
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
        if ($userInfo[v_usuario_rol::PERMISO_CATEGORIA] & PERMISSIONS::DELETE) {
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
  if ($userInfo[v_usuario_rol::PERMISO_CATEGORIA] & PERMISSIONS::READ) {
      echo '<button data-bs-toggle="modal" data-bs-target="#modal-categoria-crear" class="btn-crear">Crear</button>';
  }
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