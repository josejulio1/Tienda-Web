<?php
require_once __DIR__ . '/../../api/utils/permissions.php';
if ($permisos[v_usuario_rol::PERMISO_USUARIO] & PERMISSIONS::READ) { ?>
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
        if ($permisos[v_usuario_rol::PERMISO_USUARIO] & PERMISSIONS::DELETE) {
          echo '<th>Borrar</th>';
        }
        ?>
     	</thead>
     </table>
        <div class="modal fade" id="modal-usuario-actualizar" tabindex="-1" aria-labelledby="modal-usuario-actualizar" aria-hidden="true">
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
                            $rows = select(rol::class, [rol::ID, rol::NOMBRE, rol::COLOR]);
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
        <div class="modal fade" id="modal-usuario-crear" tabindex="-1" aria-labelledby="modal-usuario-crear" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <form class="modal-content">
              <div class="modal__header">
                <h2 class="modal-title">Crear Usuario</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="modal-row">
                      <div class="modal-column">
                          <label for="nombre-usuario-crear">Usuario</label>
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
                          <div class="invalid-feedback">Introduzca un nombre de usuario</div>
                      </div>
                  </div>
                  <div class="modal-row">
                    <div class="modal-column">
                        <label for="rol-usuario-crear">Rol</label>
                        <select id="rol-usuario-crear" required>
                            <?php
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
                        <label class="img-container" for="imagen-usuario-crear">
                            <input type="file" class="image" id="imagen-usuario-crear" hidden>
                            <img src="/assets/img/web/svg/add.svg" alt="Plus">
                            <img class="profile-photo hide" alt="Profile Photo">
                        </label>
                    </div>
                </div>
                </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="crear-usuario">Crear</button>
              </div>
            </form>
          </div>
        </div>
    </div>
    <?php
    if ($permisos[v_usuario_rol::PERMISO_USUARIO] & PERMISSIONS::READ) {
        echo '<button data-bs-toggle="modal" data-bs-target="#modal-usuario-crear" class="btn-crear">Crear</button>';
    }
    ?>
  <?php
}
?>