<?php
require_once __DIR__ . '/../templates/admin/essentials.php';
require_once __DIR__ . '/../api/utils/permissions.php';
if (($userInfo[v_usuario_rol::PERMISO_CLIENTE] & PERMISSIONS::READ) == PERMISSIONS::NO_PERMISSIONS) {
  return http_response_code(UNAUTHORIZED);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clientes</title>
  <?php
  require_once __DIR__ . '/../templates/admin/html-imports.php';
  ?>
  <script src="/assets/js/admin/sections/customer/customer.js" type="module" defer></script>
  <script src="/assets/js/admin/sections/customer/modals/modal-customer-create.js" type="module" defer></script>
  <script src="/assets/js/admin/sections/customer/modals/modal-customer-update.js" type="module" defer></script>
</head>
<body>
  <?php
  require_once __DIR__ . '/../templates/admin/panel.php';
  ?>
  <main class="info-container">
    <div class="info" id="cliente">
        <table class="row-border hover" id="tabla-clientes">
          <thead>
           <th>ID</th>
           <th>Nombre</th>
           <th>Apellidos</th>
           <th>Teléfono</th>
           <th>Dirección</th>
           <th>Correo</th>
           <th>Foto de perfil</th>
           <?php
           if ($userInfo[v_usuario_rol::PERMISO_CLIENTE] & PERMISSIONS::DELETE) {
             echo '<th>Borrar</th>';
           }
           ?>
          </thead>
        </table>
        <?php
        if ($userInfo[v_usuario_rol::PERMISO_CLIENTE] & PERMISSIONS::UPDATE) { ?>
         <div class="modal modal-unique fade" id="modal-cliente-actualizar" tabindex="-1" aria-labelledby="modal-cliente-actualizar" aria-hidden="true">
             <div class="modal-dialog modal-dialog-centered modal-xl">
               <form class="modal-content">
                 <div class="modal__header">
                   <h2 class="modal-title">Actualizar Usuario</h2>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                   <div class="modal-row">
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
                             <label for="contrasenia-cliente-actualizar">Contraseña (Opcional)</label>
                             <input type="password" id="contrasenia-cliente-actualizar" class="form-control" required>
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
                   <button type="submit" class="btn btn-primary" id="actualizar-cliente">Actualizar</button>
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
                        <th>Nombre</th>
                        <th>Apellidos</th>
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
        if ($userInfo[v_usuario_rol::PERMISO_CLIENTE] & PERMISSIONS::CREATE) { ?>
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
                <button type="submit" class="btn btn-primary" id="crear-cliente">Crear</button>
              </div>
            </form>
          </div>
        </div>
          <?php
        }
        ?>
        </div>
      <?php
      if ($userInfo[v_usuario_rol::PERMISO_CLIENTE] & PERMISSIONS::CREATE) {
          echo '<button data-bs-toggle="modal" data-bs-target="#modal-cliente-crear" class="btn-crear">Crear</button>';
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