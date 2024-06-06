  <?php
  use Util\Permission\Permissions;
  require_once __DIR__ . '/../templates/panel.php';
  ?>
  <main class="info-container">
    <div class="info" id="cliente">
        <table class="row-border hover" id="tabla">
          <thead>
           <th>ID</th>
           <th>Nombre</th>
           <th>Apellidos</th>
           <th>Teléfono</th>
           <th>Dirección</th>
           <th>Correo</th>
           <th>Foto de perfil</th>
           <?php
           if ($userInfo -> permiso_cliente & PERMISSIONS::DELETE) {
             echo '<th>Borrar</th>';
           }
           ?>
          </thead>
        </table>
        <?php
        if ($userInfo -> permiso_cliente & PERMISSIONS::UPDATE) { ?>
         <div class="modal modal-unique fade" id="modal-actualizar" tabindex="-1" aria-labelledby="modal-actualizar" aria-hidden="true">
             <div class="modal-dialog modal-dialog-centered modal-xl">
               <form class="modal-content">
                 <div class="modal__header">
                   <h2 class="modal-title">Actualizar Cliente</h2>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                   <div class="modal-row">
                       <input type="number" id="id-cliente-actualizar" hidden>
                         <div class="modal-column">
                             <label for="nombre-cliente-actualizar">Nombre</label>
                             <input type="text" id="nombre-cliente-actualizar" class="form-control" required>
                             <div class="invalid-feedback">Introduzca el nombre del cliente</div>
                         </div>
                         <div class="modal-column">
                             <label for="apellidos-cliente-actualizar">Apellidos</label>
                             <input type="text" id="apellidos-cliente-actualizar" class="form-control" required>
                             <div class="invalid-feedback">Introduzca los apellidos del cliente</div>
                         </div>
                     </div>
                   <div class="modal-row">
                         <div class="modal-column">
                             <label for="telefono-cliente-actualizar">Teléfono</label>
                             <input type="tel" id="telefono-cliente-actualizar" class="form-control" required>
                             <div class="invalid-feedback">Introduzca el teléfono del cliente (+34 123456789)</div>
                         </div>
                         <div class="modal-column">
                             <label for="direccion-cliente-actualizar">Dirección</label>
                             <input type="text" id="direccion-cliente-actualizar" class="form-control" required>
                             <div class="invalid-feedback">Introduzca la dirección del cliente</div>
                         </div>
                     </div>
                   <div class="modal-row">
                         <div class="modal-column">
                             <label for="contrasenia-cliente-actualizar">Contraseña</label>
                             <input type="password" id="contrasenia-cliente-actualizar" class="form-control">
                             <div class="invalid-feedback">Introduzca la nueva contraseña del cliente</div>
                         </div>
                     </div>
                   </div>
                   <div class="modal-row">
                    <div class="modal-column">
                      <button id="mostrar-pedidos-cliente">Ver Pedidos</button>
                    </div>
                   </div>
                 <div class="modal-footer">
                   <button type="submit" class="btn btn-primary" id="actualizar">Actualizar</button>
                 </div>
               </form>
             </div>
           </div>
           <!-- Modal Pedidos -->
           <div class="modal fade" id="modal-cliente-pedidos" tabindex="-1" aria-labelledby="modal-cliente-pedidos" aria-hidden="true">
             <div class="modal-dialog modal-dialog-centered modal-xl">
               <form class="modal-content">
                 <div class="modal__header">
                   <h2 class="modal-title">Ver Pedidos</h2>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                  <div class="modal-body">
                    <table id="tabla-pedidos">
                      <thead>
                        <th>ID</th>
                        <th>Nombre Producto</th>
                        <th>Método de pago</th>
                        <th>Estado del pago</th>
                        <th>Dirección de envío</th>
                      </thead>
                    </table>
                  </div>
               </form>
             </div>
           </div>
           <?php
        }
        ?>
        <?php
        if ($userInfo -> permiso_cliente & PERMISSIONS::CREATE) { ?>
          <div class="modal modal-unique fade" id="modal-cliente-crear" tabindex="-1" aria-labelledby="modal-cliente-crear" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <form class="modal-content">
              <div class="modal__header">
                <h2 class="modal-title">Crear Cliente</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="modal-row">
                      <div class="modal-column">
                          <label for="nombre-cliente-crear">Nombre</label>
                          <input type="text" id="nombre-cliente-crear" class="form-control" required>
                          <div class="invalid-feedback">Introduzca el nombre del cliente</div>
                      </div>
                      <div class="modal-column">
                          <label for="apellidos-cliente-crear">Apellidos</label>
                          <input type="text" id="apellidos-cliente-crear" class="form-control" required>
                          <div class="invalid-feedback">Introduzca los apellidos del cliente</div>
                      </div>
                  </div>
                <div class="modal-row">
                      <div class="modal-column">
                          <label for="telefono-cliente-crear">Teléfono</label>
                          <input type="tel" id="telefono-cliente-crear" class="form-control" required>
                          <div class="invalid-feedback">Introduzca el telefono del cliente</div>
                      </div>
                      <div class="modal-column">
                          <label for="direccion-cliente-crear">Dirección</label>
                          <input type="text" id="direccion-cliente-crear" class="form-control" required>
                          <div class="invalid-feedback">Introduzca la dirección del cliente</div>
                      </div>
                  </div>
                <div class="modal-row">
                      <div class="modal-column">
                          <label for="correo-cliente-crear">Correo</label>
                          <input type="email" id="correo-cliente-crear" class="form-control" required>
                          <div class="invalid-feedback">Introduzca el correo del cliente</div>
                      </div>
                      <div class="modal-column">
                          <label for="contrasenia-cliente-crear">Contraseña</label>
                          <input type="password" id="contrasenia-cliente-crear" class="form-control" required>
                          <div class="invalid-feedback">Introduzca una contraseña</div>
                      </div>
                  </div>
                  <div class="form-row">
                    <div class="form-column">
                        <label>Foto de perfil (Opcional)</label>
                        <!-- COMPONENTE: PreviewImage -->
                        <label class="img-container" for="imagen-cliente-crear"></label>
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
      if ($userInfo -> permiso_cliente & PERMISSIONS::CREATE) {
          echo '<button data-bs-toggle="modal" data-bs-target="#modal-cliente-crear" class="btn-crear">Crear</button>';
      }
      ?>
  </main>
  <?php
  require_once __DIR__ . '/../templates/modal-choice-info.php';
  ?>