  <?php
  use Util\Permission\Permissions;
  require_once __DIR__ . '/../templates/panel.php';
  ?>
  <main class="info-container">
    <div class="info" id="categoria">
     <table class="row-border hover" id="tabla">
       <thead>
        <th>ID</th>
        <th>Nombre</th>
        <?php
        if ($userInfo -> permiso_categoria & PERMISSIONS::DELETE) {
          echo '<th>Borrar</th>';
        }
        ?>
       </thead>
     </table>
     <?php
     if ($userInfo -> permiso_categoria & PERMISSIONS::CREATE) { ?>
      <div class="modal modal-unique fade" id="modal-actualizar" tabindex="-1" aria-labelledby="modal-actualizar" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <form class="modal-content">
              <div class="modal__header">
                <h2 class="modal-title">Actualizar Categoría</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="modal-row">
                    <input type="number" id="id-categoria-actualizar" hidden>
                      <div class="modal-column">
                          <label for="nombre-categoria-actualizar">Nombre</label>
                          <input type="text" id="nombre-categoria-actualizar" class="form-control" required>
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
        if ($userInfo -> permiso_categoria & PERMISSIONS::CREATE) { ?>
          <div class="modal modal-unique fade" id="modal-categoria-crear" tabindex="-1" aria-labelledby="modal-categoria-crear" aria-hidden="true">
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
  if ($userInfo -> permiso_categoria & PERMISSIONS::CREATE) {
      echo '<button data-bs-toggle="modal" data-bs-target="#modal-categoria-crear" class="btn-crear">Crear</button>';
  }
  ?>
  </main>
  <div class="modal modal-unique fade" id="modal-info" tabindex="-1" aria-labelledby="modal-info" aria-hidden="true">
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
  <div class="modal modal-unique fade" id="modal-choice" tabindex="-1" aria-labelledby="modal-choice" aria-hidden="true">
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
  <?php
  require_once __DIR__ . '/../templates/modal-choice-info.php';
  ?>
