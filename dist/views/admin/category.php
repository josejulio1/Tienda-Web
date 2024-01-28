<?php
require_once __DIR__ . '/../../api/utils/permissions.php';
if ($permisos[v_usuario_rol::PERMISO_CATEGORIA] & PERMISSIONS::READ) { ?>
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
                          <label for="nombre-categoria-actualizar">Categoría</label>
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
  <?php
}
?>