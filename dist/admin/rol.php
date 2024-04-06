<?php
require_once __DIR__ . '/../templates/admin/essentials.php';
require_once __DIR__ . '/../api/utils/permissions.php';
if (($userInfo[v_usuario_rol::PERMISO_ROL] & PERMISSIONS::READ) == PERMISSIONS::NO_PERMISSIONS) {
  return http_response_code(UNAUTHORIZED);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rol</title>
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
         <div class="modal modal-unique fade" id="modal-rol-actualizar" tabindex="-1" aria-labelledby="modal-rol-actualizar" aria-hidden="true">
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
                                <div class="marcar-todo-container">
                                  <label for="marcar-todo-usuario-actualizar">Marcar Todo</label>
                                  <input type="checkbox" class="marcar-todo" id="marcar-todo-usuario-actualizar">
                                </div>
                                <div class="permiso-ver-container">
                                  <label for="ver-permiso-usuario-actualizar">Ver</label>
                                  <input type="checkbox" class="permiso-ver" id="ver-permiso-usuario-actualizar">
                                </div>
                                <div class="permiso-crear-container">
                                  <label for="crear-permiso-usuario-actualizar">Crear</label>
                                  <input type="checkbox" class="permiso-crear" id="crear-permiso-usuario-actualizar">
                                </div>
                                <div class="permiso-actualizar-container">
                                  <label for="actualizar-permiso-usuario-actualizar">Actualizar</label>
                                  <input type="checkbox" class="permiso-actualizar" id="actualizar-permiso-usuario-actualizar">
                                </div>
                                <div class="permiso-eliminar-container">
                                  <label for="eliminar-permiso-usuario-actualizar">Eliminar</label>
                                  <input type="checkbox" class="permiso-eliminar" id="eliminar-permiso-usuario-actualizar">
                                </div>
                              </div>
                            </div>
                            <div class="contenedor-permiso contenedor-permiso-producto hide">
                              <div class="permiso--header">
                                <div class="marcar-todo-container">
                                  <label for="marcar-todo-producto-actualizar">Marcar Todo</label>
                                  <input type="checkbox" class="marcar-todo" id="marcar-todo-producto-actualizar">
                                </div>
                                <div class="permiso-ver-container">
                                  <label for="ver-permiso-producto-actualizar">Ver</label>
                                  <input type="checkbox" class="permiso-ver" id="ver-permiso-producto-actualizar">
                                </div>
                                <div class="permiso-crear-container">
                                  <label for="crear-permiso-producto-actualizar">Crear</label>
                                  <input type="checkbox" class="permiso-crear" id="crear-permiso-producto-actualizar">
                                </div>
                                <div class="permiso-actualizar-container">
                                  <label for="actualizar-permiso-producto-actualizar">Actualizar</label>
                                  <input type="checkbox" class="permiso-actualizar" id="actualizar-permiso-producto-actualizar">
                                </div>
                                <div class="permiso-eliminar-container">
                                  <label for="eliminar-permiso-producto-actualizar">Eliminar</label>
                                  <input type="checkbox" class="permiso-eliminar" id="eliminar-permiso-producto-actualizar">
                                </div>
                              </div>
                            </div>
                            <div class="contenedor-permiso contenedor-permiso-categoria hide">
                              <div class="permiso--header">
                                <div class="marcar-todo-container">
                                  <label for="marcar-todo-categoria-actualizar">Marcar Todo</label>
                                  <input type="checkbox" class="marcar-todo" id="marcar-todo-categoria-actualizar">
                                </div>
                                <div class="permiso-ver-container">
                                  <label for="ver-permiso-categoria-actualizar">Ver</label>
                                  <input type="checkbox" class="permiso-ver" id="ver-permiso-categoria-actualizar">
                                </div>
                                <div class="permiso-crear-container">
                                  <label for="crear-permiso-categoria-actualizar">Crear</label>
                                  <input type="checkbox" class="permiso-crear" id="crear-permiso-categoria-actualizar">
                                </div>
                                <div class="permiso-actualizar-container">
                                  <label for="actualizar-permiso-categoria-actualizar">Actualizar</label>
                                  <input type="checkbox" class="permiso-actualizar" id="actualizar-permiso-categoria-actualizar">
                                </div>
                                <div class="permiso-eliminar-container">
                                  <label for="eliminar-permiso-categoria-actualizar">Eliminar</label>
                                  <input type="checkbox" class="permiso-eliminar" id="eliminar-permiso-categoria-actualizar">
                                </div>
                              </div>
                            </div>
                            <div class="contenedor-permiso contenedor-permiso-cliente hide">
                              <div class="permiso--header">
                                <div class="marcar-todo-container">
                                  <label for="marcar-todo-cliente-actualizar">Marcar Todo</label>
                                  <input type="checkbox" class="marcar-todo" id="marcar-todo-cliente-actualizar">
                                </div>
                                <div class="permiso-ver-container">
                                  <label for="ver-permiso-cliente-actualizar">Ver</label>
                                  <input type="checkbox" class="permiso-ver" id="ver-permiso-cliente-actualizar">
                                </div>
                                <div class="permiso-crear-container">
                                  <label for="crear-permiso-cliente-actualizar">Crear</label>
                                  <input type="checkbox" class="permiso-crear" id="crear-permiso-cliente-actualizar">
                                </div>
                                <div class="permiso-actualizar-container">
                                  <label for="actualizar-permiso-cliente-actualizar">Actualizar</label>
                                  <input type="checkbox" class="permiso-actualizar" id="actualizar-permiso-cliente-actualizar">
                                </div>
                                <div class="permiso-eliminar-container">
                                  <label for="eliminar-permiso-cliente-actualizar">Eliminar</label>
                                  <input type="checkbox" class="permiso-eliminar" id="eliminar-permiso-cliente-actualizar">
                                </div>
                              </div>
                            </div>
                            <div class="contenedor-permiso contenedor-permiso-rol hide">
                              <div class="permiso--header">
                                <div class="marcar-todo-container">
                                  <label for="marcar-todo-rol-actualizar">Marcar Todo</label>
                                  <input type="checkbox" class="marcar-todo" id="marcar-todo-rol-actualizar">
                                </div>
                                <div class="permiso-ver-container">
                                  <label for="ver-permiso-rol-actualizar">Ver</label>
                                  <input type="checkbox" class="permiso-ver" id="ver-permiso-rol-actualizar">
                                </div>
                                <div class="permiso-crear-container">
                                  <label for="crear-permiso-rol-actualizar">Crear</label>
                                  <input type="checkbox" class="permiso-crear" id="crear-permiso-rol-actualizar">
                                </div>
                                <div class="permiso-actualizar-container">
                                  <label for="actualizar-permiso-rol-actualizar">Actualizar</label>
                                  <input type="checkbox" class="permiso-actualizar" id="actualizar-permiso-rol-actualizar">
                                </div>
                                <div class="permiso-eliminar-container">
                                  <label for="eliminar-permiso-rol-actualizar">Eliminar</label>
                                  <input type="checkbox" class="permiso-eliminar" id="eliminar-permiso-rol-actualizar">
                                </div>
                              </div>
                            </div>
                          </div>
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
          <div class="modal modal-unique fade" id="modal-rol-crear" tabindex="-1" aria-labelledby="modal-rol-crear" aria-hidden="true">
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
                                <div class="marcar-todo-container">
                                  <label for="marcar-todo-usuario">Marcar Todo</label>
                                  <input type="checkbox" class="marcar-todo" id="marcar-todo-usuario">
                                </div>
                                <div class="permiso-ver-container">
                                  <label for="ver-permiso-usuario">Ver</label>
                                  <input type="checkbox" class="permiso-ver" id="ver-permiso-usuario">
                                </div>
                                <div class="permiso-crear-container">
                                  <label for="crear-permiso-usuario">Crear</label>
                                  <input type="checkbox" class="permiso-crear" id="crear-permiso-usuario">
                                </div>
                                <div class="permiso-actualizar-container">
                                  <label for="actualizar-permiso-usuario">Actualizar</label>
                                  <input type="checkbox" class="permiso-actualizar" id="actualizar-permiso-usuario">
                                </div>
                                <div class="permiso-eliminar-container">
                                  <label for="eliminar-permiso-usuario">Eliminar</label>
                                  <input type="checkbox" class="permiso-eliminar" id="eliminar-permiso-usuario">
                                </div>
                              </div>
                            </div>
                            <div class="contenedor-permiso contenedor-permiso-producto hide">
                              <div class="permiso--header">
                                <div class="marcar-todo-container">
                                  <label for="marcar-todo-producto">Marcar Todo</label>
                                  <input type="checkbox" class="marcar-todo" id="marcar-todo-producto">
                                </div>
                                <div class="permiso-ver-container">
                                  <label for="ver-permiso-producto">Ver</label>
                                  <input type="checkbox" class="permiso-ver" id="ver-permiso-producto">
                                </div>
                                <div class="permiso-crear-container">
                                  <label for="crear-permiso-producto">Crear</label>
                                  <input type="checkbox" class="permiso-crear" id="crear-permiso-producto">
                                </div>
                                <div class="permiso-actualizar-container">
                                  <label for="actualizar-permiso-producto">Actualizar</label>
                                  <input type="checkbox" class="permiso-actualizar" id="actualizar-permiso-producto">
                                </div>
                                <div class="permiso-eliminar-container">
                                  <label for="eliminar-permiso-producto">Eliminar</label>
                                  <input type="checkbox" class="permiso-eliminar" id="eliminar-permiso-producto">
                                </div>
                              </div>
                            </div>
                            <div class="contenedor-permiso contenedor-permiso-categoria hide">
                              <div class="permiso--header">
                                <div class="marcar-todo-container">
                                  <label for="marcar-todo-categoria">Marcar Todo</label>
                                  <input type="checkbox" class="marcar-todo" id="marcar-todo-categoria">
                                </div>
                                <div class="permiso-ver-container">
                                  <label for="ver-permiso-categoria">Ver</label>
                                  <input type="checkbox" class="permiso-ver" id="ver-permiso-categoria">
                                </div>
                                <div class="permiso-crear-container">
                                  <label for="crear-permiso-categoria">Crear</label>
                                  <input type="checkbox" class="permiso-crear" id="crear-permiso-categoria">
                                </div>
                                <div class="permiso-actualizar-container">
                                  <label for="actualizar-permiso-categoria">Actualizar</label>
                                  <input type="checkbox" class="permiso-actualizar" id="actualizar-permiso-categoria">
                                </div>
                                <div class="permiso-eliminar-container">
                                  <label for="eliminar-permiso-categoria">Eliminar</label>
                                  <input type="checkbox" class="permiso-eliminar" id="eliminar-permiso-categoria">
                                </div>
                              </div>
                            </div>
                            <div class="contenedor-permiso contenedor-permiso-cliente hide">
                              <div class="permiso--header">
                                <div class="marcar-todo-container">
                                  <label for="marcar-todo-cliente">Marcar Todo</label>
                                  <input type="checkbox" class="marcar-todo" id="marcar-todo-cliente">
                                </div>
                                <div class="permiso-ver-container">
                                  <label for="ver-permiso-cliente">Ver</label>
                                  <input type="checkbox" class="permiso-ver" id="ver-permiso-cliente">
                                </div>
                                <div class="permiso-crear-container">
                                  <label for="crear-permiso-cliente">Crear</label>
                                  <input type="checkbox" class="permiso-crear" id="crear-permiso-cliente">
                                </div>
                                <div class="permiso-actualizar-container">
                                  <label for="actualizar-permiso-cliente">Actualizar</label>
                                  <input type="checkbox" class="permiso-actualizar" id="actualizar-permiso-cliente">
                                </div>
                                <div class="permiso-eliminar-container">
                                  <label for="eliminar-permiso-cliente">Eliminar</label>
                                  <input type="checkbox" class="permiso-eliminar" id="eliminar-permiso-cliente">
                                </div>
                              </div>
                            </div>
                            <div class="contenedor-permiso contenedor-permiso-rol hide">
                              <div class="permiso--header">
                                <div class="marcar-todo-container">
                                  <label for="marcar-todo-rol">Marcar Todo</label>
                                  <input type="checkbox" class="marcar-todo" id="marcar-todo-rol">
                                </div>
                                <div class="permiso-ver-container">
                                  <label for="ver-permiso-rol">Ver</label>
                                  <input type="checkbox" class="permiso-ver" id="ver-permiso-rol">
                                </div>
                                <div class="permiso-crear-container">
                                  <label for="crear-permiso-rol">Crear</label>
                                  <input type="checkbox" class="permiso-crear" id="crear-permiso-rol">
                                </div>
                                <div class="permiso-actualizar-container">
                                  <label for="actualizar-permiso-rol">Actualizar</label>
                                  <input type="checkbox" class="permiso-actualizar" id="actualizar-permiso-rol">
                                </div>
                                <div class="permiso-eliminar-container">
                                  <label for="eliminar-permiso-rol">Eliminar</label>
                                  <input type="checkbox" class="permiso-eliminar" id="eliminar-permiso-rol">
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
  require_once __DIR__ . '/../templates/admin/chat.php';
  ?>
</body>
</html>