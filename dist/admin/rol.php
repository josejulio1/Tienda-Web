<?php
require_once __DIR__ . '/../templates/admin/essentials.php';
require_once __DIR__ . '/../api/utils/permissions.php';
if (($userInfo[v_usuario_rol::PERMISO_ROL] & PERMISSIONS::READ) == PERMISSIONS::NO_PERMISSIONS) {
  return http_response_code(NOT_FOUND);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Usuarios</title>
  <?php
  require_once __DIR__ . '/../templates/admin/html-imports.php';
  ?>
  <script src="/assets/js/admin/sections/rol/rol-system.js" type="module" defer></script>
  <script src="/assets/js/admin/sections/rol/rol.js" type="module" defer></script>
  <script src="/assets/js/admin/sections/rol/modals/modal-rol-create.js" type="module" defer></script>
  <script src="/assets/js/admin/sections/rol/modals/modal-rol-update.js" type="module" defer></script>
</head>
<body>
  <?php
  require_once __DIR__ . '/../templates/admin/panel.php';
  ?>
  <main class="info-container">
    <div class="info" id="rol">
        <table class="row-border hover" id="tabla-roles">
          <thead>
           <th>ID</th>
           <th>Nombre</th>
           <th>Color</th>
           <?php
           if ($userInfo[v_usuario_rol::PERMISO_ROL] & PERMISSIONS::DELETE) {
             echo '<th>Borrar</th>';
           }
           ?>
          </thead>
        </table>
        <?php
        if ($userInfo[v_usuario_rol::PERMISO_ROL] & PERMISSIONS::UPDATE) { ?>
         <div class="modal fade" id="modal-rol-actualizar" tabindex="-1" aria-labelledby="modal-rol-actualizar" aria-hidden="true">
             <div class="modal-dialog modal-dialog-centered modal-xl">
               <form class="modal-content">
                 <div class="modal__header">
                   <h2 class="modal-title">Actualizar Rol</h2>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                   <div class="modal-row">
                         <div class="modal-column">
                             <label for="nombre-rol-actualizar">Nombre Rol</label>
                             <input type="text" id="nombre-rol-actualizar" class="form-control" required>
                             <div class="invalid-feedback">Introduzca un nombre de rol</div>
                         </div>
                         <div class="modal-column">
                             <label for="color-rol-actualizar">Color</label>
                             <input type="color" id="color-rol-actualizar" class="form-control" required>
                             <div class="invalid-feedback">Introduzca un color de rol</div>
                         </div>
                     </div>
                   </div>
                 <div class="modal-footer">
                   <button type="submit" class="btn btn-primary" id="actualizar-rol">Actualizar</button>
                 </div>
               </form>
             </div>
           </div>
           <?php
        }
        ?>
        <?php
        if ($userInfo[v_usuario_rol::PERMISO_ROL] & PERMISSIONS::CREATE) { ?>
          <div class="modal fade" id="modal-rol-crear" tabindex="-1" aria-labelledby="modal-rol-crear" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <form class="modal-content">
              <div class="modal__header">
                <h2 class="modal-title">Crear Rol</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="modal-row">
                      <div class="modal-column">
                          <label for="nombre-rol-crear">Nombre Rol</label>
                          <input type="text" id="nombre-rol-crear" class="form-control" required>
                          <div class="invalid-feedback">Introduzca un nombre de rol</div>
                      </div>
                      <div class="modal-column">
                          <label for="color-rol-crear">Color</label>
                          <input type="color" id="color-rol-crear" class="form-control" required>
                          <div class="invalid-feedback">Introduzca un color</div>
                      </div>
                  </div>
                  <div class="modal-row">
                      <div class="modal-column">
                          <nav>
                            <button class="btn-permiso selected-button" id="permiso-usuario">Usuario</button>
                            <button class="btn-permiso" id="permiso-producto">Producto</button>
                            <button class="btn-permiso" id="permiso-categoria">Categoría</button>
                            <button class="btn-permiso" id="permiso-cliente">Cliente</button>
                            <button class="btn-permiso" id="permiso-rol">Rol</button>
                          </nav>
                          <div class="contenedor-permisos">
                            <div class="contenedor-permiso contenedor-permiso-usuario">
                              <div class="permiso--header">
                                <div class="marcar-todo">
                                  <label for="marcar-todo-usuario">Marcar Todo</label>
                                  <input type="checkbox" class="marcar-todo" id="marcar-todo-usuario">
                                </div>
                                <div class="permiso-ver">
                                  <label for="ver-permiso-usuario">Ver</label>
                                  <input type="checkbox" id="ver-permiso-usuario">
                                </div>
                                <div class="permiso-crear">
                                  <label for="crear-permiso-usuario">Crear</label>
                                  <input type="checkbox" id="crear-permiso-usuario">
                                </div>
                                <div class="permiso-actualizar">
                                  <label for="actualizar-permiso-usuario">Actualizar</label>
                                  <input type="checkbox" id="actualizar-permiso-usuario">
                                </div>
                                <div class="permiso-eliminar">
                                  <label for="eliminar-permiso-usuario">Eliminar</label>
                                  <input type="checkbox" id="eliminar-permiso-usuario">
                                </div>
                              </div>
                            </div>
                            <div class="contenedor-permiso contenedor-permiso-producto hide">
                              <div class="permiso--header">
                                <div class="marcar-todo">
                                  <label for="marcar-todo-producto">Marcar Todo</label>
                                  <input type="checkbox" class="marcar-todo" id="marcar-todo-producto">
                                </div>
                                <div class="permiso-ver">
                                  <label for="ver-permiso-producto">Ver</label>
                                  <input type="checkbox" id="ver-permiso-producto">
                                </div>
                                <div class="permiso-crear">
                                  <label for="crear-permiso-producto">Crear</label>
                                  <input type="checkbox" id="crear-permiso-producto">
                                </div>
                                <div class="permiso-actualizar">
                                  <label for="actualizar-permiso-producto">Actualizar</label>
                                  <input type="checkbox" id="actualizar-permiso-producto">
                                </div>
                                <div class="permiso-eliminar">
                                  <label for="eliminar-permiso-producto">Eliminar</label>
                                  <input type="checkbox" id="eliminar-permiso-producto">
                                </div>
                              </div>
                            </div>
                            <div class="contenedor-permiso contenedor-permiso-categoria hide">
                              <div class="permiso--header">
                                <div class="marcar-todo">
                                  <label for="marcar-todo-categoria">Marcar Todo</label>
                                  <input type="checkbox" class="marcar-todo" id="marcar-todo-categoria">
                                </div>
                                <div class="permiso-ver">
                                  <label for="ver-permiso-categoria">Ver</label>
                                  <input type="checkbox" id="ver-permiso-categoria">
                                </div>
                                <div class="permiso-crear">
                                  <label for="crear-permiso-categoria">Crear</label>
                                  <input type="checkbox" id="crear-permiso-categoria">
                                </div>
                                <div class="permiso-actualizar">
                                  <label for="actualizar-permiso-categoria">Actualizar</label>
                                  <input type="checkbox" id="actualizar-permiso-categoria">
                                </div>
                                <div class="permiso-eliminar">
                                  <label for="eliminar-permiso-categoria">Eliminar</label>
                                  <input type="checkbox" id="eliminar-permiso-categoria">
                                </div>
                              </div>
                            </div>
                            <div class="contenedor-permiso contenedor-permiso-cliente hide">
                              <div class="permiso--header">
                                <div class="marcar-todo">
                                  <label for="marcar-todo-cliente">Marcar Todo</label>
                                  <input type="checkbox" class="marcar-todo" id="marcar-todo-cliente">
                                </div>
                                <div class="permiso-ver">
                                  <label for="ver-permiso-cliente">Ver</label>
                                  <input type="checkbox" id="ver-permiso-cliente">
                                </div>
                                <div class="permiso-crear">
                                  <label for="crear-permiso-cliente">Crear</label>
                                  <input type="checkbox" id="crear-permiso-cliente">
                                </div>
                                <div class="permiso-actualizar">
                                  <label for="actualizar-permiso-cliente">Actualizar</label>
                                  <input type="checkbox" id="actualizar-permiso-cliente">
                                </div>
                                <div class="permiso-eliminar">
                                  <label for="eliminar-permiso-cliente">Eliminar</label>
                                  <input type="checkbox" id="eliminar-permiso-cliente">
                                </div>
                              </div>
                            </div>
                            <div class="contenedor-permiso contenedor-permiso-rol hide">
                              <div class="permiso--header">
                                <div class="marcar-todo">
                                  <label for="marcar-todo-rol">Marcar Todo</label>
                                  <input type="checkbox" class="marcar-todo" id="marcar-todo-rol">
                                </div>
                                <div class="permiso-ver">
                                  <label for="ver-permiso-rol">Ver</label>
                                  <input type="checkbox" id="ver-permiso-rol">
                                </div>
                                <div class="permiso-crear">
                                  <label for="crear-permiso-rol">Crear</label>
                                  <input type="checkbox" id="crear-permiso-rol">
                                </div>
                                <div class="permiso-actualizar">
                                  <label for="actualizar-permiso-rol">Actualizar</label>
                                  <input type="checkbox" id="actualizar-permiso-rol">
                                </div>
                                <div class="permiso-eliminar">
                                  <label for="eliminar-permiso-rol">Eliminar</label>
                                  <input type="checkbox" id="eliminar-permiso-rol">
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>
                  </div>
                </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="crear-rol">Crear</button>
              </div>
            </form>
          </div>
        </div>
          <?php
        }
        ?>
        </div>
      <?php
      if ($userInfo[v_usuario_rol::PERMISO_ROL] & PERMISSIONS::CREATE) {
          echo '<button data-bs-toggle="modal" data-bs-target="#modal-rol-crear" class="btn-crear">Crear</button>';
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