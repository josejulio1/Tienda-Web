<?php
require_once __DIR__ . '/../templates/admin/essentials.php';
require_once __DIR__ . '/../api/utils/permissions.php';
if (($userInfo[v_usuario_rol::PERMISO_USUARIO] & PERMISSIONS::READ) == PERMISSIONS::NO_PERMISSIONS) {
  return http_response_code(UNAUTHORIZED);
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
  <script src="/assets/js/admin/sections/user/user.js" type="module" defer></script>
  <script src="/assets/js/admin/sections/user/modals/modal-user-create.js" type="module" defer></script>
  <script src="/assets/js/admin/sections/user/modals/modal-user-update.js" type="module" defer></script>
</head>
<body>
  <?php
  require_once __DIR__ . '/../templates/admin/panel.php';
  ?>
  <main class="info-container">
    <div class="info" id="usuario">
        <table class="row-border hover" id="tabla-usuarios">
          <thead>
           <th>ID</th>
           <th>Usuario</th>
           <th>Correo</th>
           <th>Rol</th>
           <th>Color del Rol</th>
           <th>Foto de perfil</th>
           <?php
           if ($userInfo[v_usuario_rol::PERMISO_USUARIO] & PERMISSIONS::DELETE) {
             echo '<th>Borrar</th>';
           }
           ?>
          </thead>
        </table>
        <?php
        if ($userInfo[v_usuario_rol::PERMISO_USUARIO] & PERMISSIONS::UPDATE) { ?>
         <div class="modal modal-unique fade" id="modal-usuario-actualizar" tabindex="-1" aria-labelledby="modal-usuario-actualizar" aria-hidden="true">
             <div class="modal-dialog modal-dialog-centered modal-xl">
               <form class="modal-content">
                 <div class="modal__header">
                   <h2 class="modal-title">Actualizar Usuario</h2>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                   <div class="modal-row">
                         <div class="modal-column">
                             <label for="nombre-usuario-actualizar">Usuario</label>
                             <input type="text" id="nombre-usuario-actualizar" class="form-control" required>
                             <div class="invalid-feedback">Introduzca un nombre de usuario</div>
                         </div>
                         <div class="modal-column">
                             <label for="correo-usuario-actualizar">Correo</label>
                             <input type="email" id="correo-usuario-actualizar" class="form-control" disabled required>
                             <div class="invalid-feedback">Introduzca un correo válido (micorreo@gmail.com)</div>
                         </div>
                     </div>
                     <div class="modal-row">
                       <div class="modal-column">
                           <label for="rol-usuario-actualizar">Rol</label>
                           <select id="rol-usuario-actualizar" required>
                               <?php
                               require_once __DIR__ . '/../db/models/Rol.php';
                               $rows = select(Rol::class, [Rol::ID, Rol::NOMBRE, Rol::COLOR]);
                               $propertiesName = array_keys($rows[0]);
                               foreach ($rows as $colorRow) { ?>
                                   <option value="<?php echo $colorRow[$propertiesName[0]]; ?>" color="<?php echo $colorRow[$propertiesName[2]]; ?>"><?php echo $colorRow[$propertiesName[1]]; ?></option>
                                   <?php
                               }
                               ?>
                           </select>
                           <div class="invalid-feedback">Debe seleccionar un rol</div>
                       </div>
                     </div>
                   </div>
                 <div class="modal-footer">
                   <button type="submit" class="btn btn-primary" id="actualizar-usuario">Actualizar</button>
                 </div>
               </form>
             </div>
           </div>
           <?php
        }
        ?>
        <?php
        if ($userInfo[v_usuario_rol::PERMISO_USUARIO] & PERMISSIONS::CREATE) { ?>
          <div class="modal modal-unique fade" id="modal-usuario-crear" tabindex="-1" aria-labelledby="modal-usuario-crear" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <form class="modal-content">
              <div class="modal__header">
                <h2 class="modal-title">Crear Usuario</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="modal-row">
                      <div class="modal-column">
                          <label for="nombre-usuario-crear">Nombre</label>
                          <input type="text" id="nombre-usuario-crear" class="form-control" required>
                          <div class="invalid-feedback">Introduzca un nombre de usuario</div>
                      </div>
                      <div class="modal-column">
                          <label for="correo-usuario-crear">Correo</label>
                          <input type="email" id="correo-usuario-crear" class="form-control" required>
                          <div class="invalid-feedback">Introduzca un correo válido (micorreo@gmail.com)</div>
                      </div>
                  </div>
                  <div class="modal-row">
                      <div class="modal-column">
                          <label for="contrasenia-usuario-crear">Contraseña</label>
                          <input type="password" id="contrasenia-usuario-crear" class="form-control" required>
                          <div class="invalid-feedback">Introduzca una contraseña</div>
                      </div>
                  </div>
                  <div class="modal-row">
                    <div class="modal-column">
                        <label for="rol-usuario-crear">Rol</label>
                        <select id="rol-usuario-crear" required>
                            <?php
                            require_once __DIR__ . '/../db/models/Rol.php';
                            $rows = select(Rol::class, [Rol::ID, Rol::NOMBRE, Rol::COLOR]);
                            $propertiesName = array_keys($rows[0]);
                            foreach ($rows as $colorRow) { ?>
                                <option value="<?php echo $colorRow[$propertiesName[0]]; ?>" color="<?php echo $colorRow[$propertiesName[2]]; ?>"><?php echo $colorRow[$propertiesName[1]]; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">Debe seleccionar un rol</div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-column">
                        <label>Foto de perfil (Opcional)</label>
                        <!-- COMPONENTE: PreviewImage -->
                        <label class="img-container" for="imagen-usuario-crear"></label>
                    </div>
                </div>
                </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="crear-usuario">Crear</button>
              </div>
            </form>
          </div>
        </div>
          <?php
        }
        ?>
        </div>
      <?php
      if ($userInfo[v_usuario_rol::PERMISO_USUARIO] & PERMISSIONS::CREATE) {
          echo '<button data-bs-toggle="modal" data-bs-target="#modal-usuario-crear" class="btn-crear">Crear</button>';
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
</body>
</html>