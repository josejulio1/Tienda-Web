  <?php
  use Util\Permission\Permissions;
  require_once __DIR__ . '/../templates/panel.php';
  ?>
  <main class="info-container">
  <div class="info" id="producto">
     <table class="row-border hover" id="tabla">
     	<thead>
        <th>ID</th>
        <th>Nombre</th>
     		<th>Precio</th>
     		<th>Marca</th>
     		<th>Stock</th>
     		<th>Imagen</th>
     		<th>Categoría</th>
        <?php
        if ($userInfo -> permiso_producto & Permissions::DELETE) {
          echo '<th>Borrar</th>';
        }
        ?>
     	</thead>
     </table>
        <div class="modal modal-unique fade" id="modal-actualizar" tabindex="-1" aria-labelledby="modal-actualizar" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <form class="modal-content">
              <div class="modal__header">
                <h2 class="modal-title">Actualizar Producto</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="modal-row">
                    <input type="number" id="id-producto-actualizar" hidden>
                      <div class="modal-column">
                          <label for="nombre-producto-actualizar">Nombre</label>
                          <input type="text" id="nombre-producto-actualizar" class="form-control" required>
                          <div class="invalid-feedback">Introduzca un nombre de producto</div>
                      </div>
                      <div class="modal-column">
                          <label for="precio-producto-actualizar">Precio</label>
                          <input type="number" id="precio-producto-actualizar" class="form-control" min="1" required>
                          <div class="invalid-feedback">Introduzca el precio del producto</div>
                      </div>
                  </div>
                  <div class="modal-column">
                    <label for="descripcion-producto-actualizar">Descripción</label>
                    <textarea id="descripcion-producto-actualizar" class="form-control" cols="30" rows="10" required></textarea>
                    <div class="invalid-feedback">Introduzca una descripción</div>
                  </div>
                </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="actualizar">Actualizar</button>
              </div>
            </form>
          </div>
        </div>
        <?php
        if ($userInfo -> permiso_producto & Permissions::CREATE) { ?>
          <div class="modal modal-unique fade" id="modal-producto-crear" tabindex="-1" aria-labelledby="modal-producto-crear" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <form class="modal-content">
              <div class="modal__header">
                <h2 class="modal-title">Crear Producto</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="modal-row">
                      <div class="modal-column">
                          <label for="nombre-producto-crear">Nombre</label>
                          <input type="text" id="nombre-producto-crear" class="form-control" required>
                          <div class="invalid-feedback">Introduzca un nombre de producto</div>
                      </div>
                      <div class="modal-column">
                      <label for="precio-producto-crear">Precio</label>
                          <input type="number" id="precio-producto-crear" class="form-control" min="1" required>
                          <div class="invalid-feedback">Introduzca el precio del producto</div>
                      </div>
                  </div>
                  <div class="modal-row">
                    <div class="modal-column">
                        <label for="marca-producto-crear">Marca</label>
                        <select id="marca-producto-crear" required>
                            <?php
                            foreach ($marcas as $marca) { ?>
                                <option value="<?php echo $marca -> id;?>"><?php echo $marca -> marca; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">Introduzca una marca</div>
                    </div>
                    <div class="modal-column">
                        <label for="stock-producto-crear">Stock</label>
                        <input type="number" id="stock-producto-crear" class="form-control" required>
                        <div class="invalid-feedback">Introduzca una cantidad de stock</div>
                    </div>
                  </div>
                  <div class="modal-column">
                      <label for="descripcion-producto-crear">Descripción</label>
                      <textarea id="descripcion-producto-crear" class="form-control" cols="30" rows="10" required></textarea>
                      <div class="invalid-feedback">Introduzca una descripción</div>
                  </div>
                  <div class="modal-row">
                    <div class="modal-column">
                        <label for="categoria-producto-crear">Categoría</label>
                        <select id="categoria-producto-crear" required>
                            <?php
                            foreach ($categorias as $categoria) { ?>
                                <option value="<?php echo $categoria -> id; ?>"><?php echo $categoria -> nombre; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">Debe seleccionar una categoría</div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-column">
                        <label>Foto de producto</label>
                        <!-- COMPONENTE: PreviewImage -->
                        <label class="img-container" for="imagen-producto-crear"></label>
                        <div class="invalid-feedback">Debe introducir una imagen de producto</div>
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
    if ($userInfo -> permiso_producto & Permissions::CREATE) {
        echo '<button data-bs-toggle="modal" data-bs-target="#modal-producto-crear" class="btn-crear">Crear</button>';
    }
    ?>
  </main>
  <?php
  require_once __DIR__ . '/../templates/modal-choice-info.php';
  ?>