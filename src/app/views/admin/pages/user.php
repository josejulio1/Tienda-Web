  <?php
  use Util\Permission\Permissions;
  require_once __DIR__ . '/../templates/panel.php';
  ?>
  <main class="info-container">
    <div class="info" id="usuario">
        <table class="row-border hover" id="tabla">
          <thead>
           <th>ID</th>
           <th>Usuario</th>
           <th>Correo</th>
           <th>Rol</th>
           <th>Color del Rol</th>
           <th>Foto de perfil</th>
           <?php
           if ($userInfo -> permiso_usuario & Permissions::DELETE) {
             echo '<th>Borrar</th>';
           }
           ?>
          </thead>
        </table>
        <?php
        if ($userInfo -> permiso_usuario & Permissions::UPDATE) { ?>
         <div class="modal modal-unique fade" id="modal-actualizar" tabindex="-1" aria-labelledby="modal-actualizar" aria-hidden="true">
             <div class="modal-dialog modal-dialog-centered modal-xl">
               <form class="modal-content">
                 <div class="modal__header">
                   <h2 class="modal-title">Actualizar Usuario</h2>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                   <div class="modal-row">
                       <input type="number" id="id-usuario-actualizar" hidden>
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
                               foreach ($roles as $rol) { ?>
                                   <option value="<?php echo $rol -> id; ?>" color="<?php echo $rol -> color; ?>"><?php echo $rol -> nombre; ?></option>
                                   <?php
                               }
                               ?>
                           </select>
                           <div class="invalid-feedback">Debe seleccionar un rol</div>
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
        if ($userInfo -> permiso_usuario & Permissions::CREATE) { ?>
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
                            foreach ($roles as $rol) { ?>
                                <option value="<?php echo $rol -> id; ?>" color="<?php echo $rol -> color; ?>"><?php echo $rol -> nombre; ?></option>
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
      if ($userInfo -> permiso_usuario & Permissions::CREATE) {
          echo '<button data-bs-toggle="modal" data-bs-target="#modal-usuario-crear" class="btn-crear">Crear</button>';
      }
      ?>
  </main>
  <?php
  require_once __DIR__ . '/../templates/modal-choice-info.php';
  ?>