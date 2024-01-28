<?php
require_once __DIR__ . '/../../api/utils/permissions.php';
if ($permisos[v_usuario_rol::PERMISO_PRODUCTO] & PERMISSIONS::READ) { ?>
    <div class="info" id="producto">
     <table class="row-border hover" id="tabla-productos">
     	<thead>
        <th>ID</th>
        <th>Nombre</th>
     		<th>Descripción</th>
     		<th>Precio</th>
     		<th>Marca</th>
     		<th>Stock</th>
     		<th>Categoría</th>
        <?php
        if ($permisos[v_usuario_rol::PERMISO_PRODUCTO] & PERMISSIONS::DELETE) {
          echo '<th>Borrar</th>';
        }
        ?>
     	</thead>
     </table>
        <div class="modal fade" id="modal-producto-actualizar" tabindex="-1" aria-labelledby="modal-producto-actualizar" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <form class="modal-content">
              <div class="modal__header">
                <h2 class="modal-title">Actualizar producto</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="modal-row">
                      <div class="modal-column">
                          <label for="nombre-producto-actualizar">Nombre</label>
                          <input type="text" id="nombre-producto-actualizar" class="form-control" required>
                          <div class="invalid-feedback">Introduzca un nombre de producto</div>
                      </div>
                      <div class="modal-column">
                          <label for="precio-producto-actualizar">Precio</label>
                          <input type="number" id="precio-producto-actualizar" class="form-control" required>
                          <div class="invalid-feedback">Introduzca el precio del producto</div>
                      </div>
                  </div>
                  <div class="modal-column">
                    <label for="descripcion-producto-actualizar">Descripción</label>
                    <textarea id="descripcion-producto-actualizar" class="form-control" cols="30" rows="10" required></textarea>
                    <div class="invalid-feedback">Introduzca una descripción</div>
                  </div>
                  <div class="modal-column">
                      <label for="marca-producto-actualizar">Marca</label>
                      <input type="text" id="marca-producto-actualizar" class="form-control" required>
                      <div class="invalid-feedback">Debe escribir una marca</div>
                  </div>
                </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="actualizar-producto">Actualizar</button>
              </div>
            </form>
          </div>
        </div>
        <div class="modal fade" id="modal-producto-crear" tabindex="-1" aria-labelledby="modal-producto-crear" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <form class="modal-content">
              <div class="modal__header">
                <h2 class="modal-title">Crear Producto</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="modal-row">
                      <div class="modal-column">
                          <label for="nombre-producto-crear">Producto</label>
                          <input type="text" id="nombre-producto-crear" class="form-control" required>
                          <div class="invalid-feedback">Introduzca un nombre de producto</div>
                      </div>
                      <div class="modal-column">
                      <label for="precio-producto-crear">Precio</label>
                          <input type="number" id="precio-producto-crear" class="form-control" required>
                          <div class="invalid-feedback">Introduzca el precio del producto</div>
                      </div>
                  </div>
                  <div class="modal-column">
                      <label for="descripcion-producto-crear">Descripción</label>
                      <textarea id="descripcion-producto-crear" class="form-control" cols="30" rows="10" required></textarea>
                      <div class="invalid-feedback">Introduzca una descripción</div>
                  </div>
                  <div class="modal-row">
                    <div class="modal-column">
                        <label for="marca-producto-crear">Marca</label>
                        <input type="text" id="marca-producto-crear" class="form-control" required>
                        <div class="invalid-feedback">Introduzca una marca</div>
                    </div>
                    <div class="modal-column">
                        <label for="stock-producto-crear">Stock</label>
                        <input type="number" id="stock-producto-crear" class="form-control" required>
                        <div class="invalid-feedback">Introduzca una cantidad de stock</div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-column">
                        <label>Foto de producto</label>
                        <label class="img-container" for="imagen-producto-crear">
                            <input type="file" class="image" id="imagen-producto-crear" hidden>
                            <img src="/assets/img/web/svg/add.svg" alt="Plus">
                            <img class="profile-photo hide" alt="Profile Photo">
                        </label>
                    </div>
                </div>
                </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="crear-producto">Crear</button>
              </div>
            </form>
          </div>
        </div>
    </div>
    <?php
    if ($permisos[v_usuario_rol::PERMISO_PRODUCTO] & PERMISSIONS::READ) {
        echo '<button data-bs-toggle="modal" data-bs-target="#modal-producto-crear" class="btn-crear">Crear</button>';
    }
    ?>
  <?php
}
?>