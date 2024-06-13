<?php
use Util\Permission\Permissions;
require_once __DIR__ . '/../templates/panel.php';
?>
<main class="info-container">
  <div class="info" id="marca">
   <table class="row-border hover" id="tabla">
     <thead>
        <tr>
            <th>ID</th>
            <th>Marca</th>
            <?php
            if ($userInfo -> permiso_marca & Permissions::DELETE) {
                echo '<th>Borrar</th>';
            }
            ?>
        </tr>
     </thead>
   </table>
   <?php
   if ($userInfo -> permiso_marca & Permissions::CREATE) { ?>
    <div class="modal modal-unique fade" id="modal-actualizar" tabindex="-1" aria-labelledby="modal-actualizar" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
          <form class="modal-content">
            <div class="modal__header">
              <h2 class="modal-title">Actualizar Marca</h2>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="modal-row">
                    <div class="modal-column">
                        <label for="nombre-marca-actualizar">Nombre</label>
                        <input type="text" id="nombre-marca-actualizar" class="form-control" required>
                        <div class="invalid-feedback">Introduzca un nombre de categoría</div>
                    </div>
                </div>
              </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" id="actualizar">Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    <?php
   }
   ?>
      <?php
      if ($userInfo -> permiso_marca & Permissions::CREATE) { ?>
        <div class="modal modal-unique fade" id="modal-marca-crear" tabindex="-1" aria-labelledby="modal-marca-crear" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
          <form class="modal-content">
            <div class="modal__header">
              <h2 class="modal-title">Crear Marca</h2>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="modal-row">
                  <input type="number" id="id-marca-actualizar" hidden>
                  <div class="modal-column">
                      <label for="nombre-marca-crear">Marca</label>
                      <input type="text" id="nombre-marca-crear" class="form-control" required>
                      <div class="invalid-feedback">Introduzca un nombre de marca</div>
                  </div>
              </div>
              </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" id="crear">Crear</button>
            </div>
          </form>
        </div>
      </div>
        <?php
      }
      ?>
  </div>
<?php
if ($userInfo -> permiso_marca & Permissions::CREATE) {
    echo '<button data-bs-toggle="modal" data-bs-target="#modal-marca-crear" class="btn-crear">Crear</button>';
}
?>
</main>
<?php
require_once __DIR__ . '/../templates/modal-choice-info.php';
require_once __DIR__ . '/../templates/chat.php';