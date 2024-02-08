<?php
require_once __DIR__ . '/../templates/admin/essentials.php';
require_once __DIR__ . '/../api/utils/permissions.php';
if (($userInfo[v_usuario_rol::PERMISO_PRODUCTO] & PERMISSIONS::READ) == PERMISSIONS::NO_PERMISSIONS) {
  return http_response_code(NOT_FOUND);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Productos</title>
  <?php
  require_once __DIR__ . '/../templates/admin/html-imports.php';
  ?>
  <script src="/assets/js/admin/sections/product/product.js" type="module" defer></script>
  <script src="/assets/js/admin/sections/product/modals/modal-product-create.js" type="module" defer></script>
  <script src="/assets/js/admin/sections/product/modals/modal-product-update.js" type="module" defer></script>
</head>
<body>
  <?php
  require_once __DIR__ . '/../templates/admin/panel.php';
  ?>
  <main class="info-container">
  <div class="info" id="producto">
     <table class="row-border hover" id="tabla-productos">
     	<thead>
        <th>ID</th>
        <th>Nombre</th>
     		<th>Precio</th>
     		<th>Marca</th>
     		<th>Stock</th>
     		<th>Imagen</th>
     		<th>Categoría</th>
        <?php
        if ($userInfo[v_usuario_rol::PERMISO_PRODUCTO] & PERMISSIONS::DELETE) {
          echo '<th>Borrar</th>';
        }
        ?>
     	</thead>
     </table>
        <div class="modal fade" id="modal-producto-actualizar" tabindex="-1" aria-labelledby="modal-producto-actualizar" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <form class="modal-content">
              <div class="modal__header">
                <h2 class="modal-title">Actualizar Producto</h2>
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
                  <div class="modal-row">
                    <div class="modal-column">
                        <label for="marca-producto-actualizar">Marca</label>
                        <input type="text" id="marca-producto-actualizar" class="form-control" required>
                        <div class="invalid-feedback">Debe escribir una marca</div>
                    </div>
                  </div>
                  <div class="modal-column">
                    <label for="descripcion-producto-actualizar">Descripción</label>
                    <textarea id="descripcion-producto-actualizar" class="form-control" cols="30" rows="10" required></textarea>
                    <div class="invalid-feedback">Introduzca una descripción</div>
                  </div>
                </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="actualizar-producto">Actualizar</button>
              </div>
            </form>
          </div>
        </div>
        <?php
        if ($userInfo[v_usuario_rol::PERMISO_PRODUCTO] & PERMISSIONS::CREATE) { ?>
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
                          <label for="nombre-producto-crear">Nombre</label>
                          <input type="text" id="nombre-producto-crear" class="form-control" required>
                          <div class="invalid-feedback">Introduzca un nombre de producto</div>
                      </div>
                      <div class="modal-column">
                      <label for="precio-producto-crear">Precio</label>
                          <input type="number" id="precio-producto-crear" class="form-control" required>
                          <div class="invalid-feedback">Introduzca el precio del producto</div>
                      </div>
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
                            require_once __DIR__ . '/../db/models/categoria.php';
                            $rows = select(categoria::class, [categoria::ID, categoria::NOMBRE]);
                            $propertiesName = array_keys($rows[0]);
                            foreach ($rows as $categoriaRow) { ?>
                                <option value="<?php echo $categoriaRow[$propertiesName[0]]; ?>"><?php echo $categoriaRow[$propertiesName[1]]; ?></option>
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
                <button type="submit" class="btn btn-primary" id="crear-producto">Crear</button>
              </div>
            </form>
          </div>
        </div>
          <?php
        }
        ?>
    </div>
    <?php
    if ($userInfo[v_usuario_rol::PERMISO_PRODUCTO] & PERMISSIONS::CREATE) {
        echo '<button data-bs-toggle="modal" data-bs-target="#modal-producto-crear" class="btn-crear">Crear</button>';
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