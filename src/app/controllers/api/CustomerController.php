<?php
namespace API;

use Database\Database;
use Model\Cliente;
use Model\Comentario;
use Model\Producto;
use Model\VComentarioClienteProducto;
use Model\VUsuarioRol;
use Util\API\AdminHelper;
use Util\API\HttpErrorMessages;
use Util\API\HttpStatusCode;
use Util\API\HttpSuccessMessages;
use Util\API\Response;
use Util\Auth\AuthHelper;
use Util\Auth\RoleAccess;
use Util\Image\ImageFolder;
use Util\Image\ImageHelper;
use Util\Image\DefaultPath;
use Util\Image\TypeImage;

/**
 * Controlador de API para la tabla {@see Cliente}
 * @author josejulio1
 * @version 1.0
 */
class CustomerController {
    /**
     * Inicia sesión con un {@see Cliente}
     * @return void
     */
    public static function login(): void {
        $clienteDb = Cliente::findByEmail($_POST[Cliente::CORREO], [
            Cliente::ID,
            Cliente::CONTRASENIA
        ]);
        // Verificar si el usuario existe o la base de datos no funciona
        if (!$clienteDb) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE,HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::NOT_FOUND, HttpErrorMessages::INCORRECT_USER_OR_PASSWORD);
            }
            return;
        }
        $clienteFormulario = new Cliente($_POST);
        // Verificar si la contraseña es incorrecta
        if (!password_verify($clienteFormulario -> contrasenia, $clienteDb -> contrasenia)) {
            Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::INCORRECT_USER_OR_PASSWORD);
            return;
        }
        // En caso de que el usuario sea correcto, ofrecer sesión
        AuthHelper::startSession($clienteDb -> id, RoleAccess::CUSTOMER, $_POST['mantener-sesion'] === 'true');
        Response::sendResponse(HttpStatusCode::OK);
    }

    /**
     * Registra un {@see Cliente} en la base de datos
     * @return void
     */
    public static function register() {
        if ($_FILES) {
            $_POST[Cliente::RUTA_IMAGEN_PERFIL] = ImageHelper::createImage(
                $_FILES[Cliente::RUTA_IMAGEN_PERFIL],
                new ImageFolder($_POST[Cliente::CORREO], TypeImage::PROFILE_CUSTOMER)
            );
        } else {
            $_POST[Cliente::RUTA_IMAGEN_PERFIL] = DefaultPath::DEFAULT_IMAGE_PROFILE;
        }
        // Verificar si el cliente ya existe
        $clienteDb = Cliente::findByEmail($_POST[Cliente::CORREO], [Cliente::ID]);
        if ($clienteDb) {
            Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::CUSTOMER_EXISTS);
            return;
        }

        $clienteFormulario = new Cliente($_POST);
        if (!$clienteFormulario -> create()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE,HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::INCORRECT_DATA);
            }
            return;
        }
        AuthHelper::startSession(Cliente::last([Cliente::ID]) -> id, RoleAccess::CUSTOMER, true);
        Response::sendResponse(HttpStatusCode::OK);
    }

    /**
     * Permite cambiar al {@see Cliente} su foto de perfil, su nombre, apellidos, teléfono o contraseña en la ruta /profile
     * @return void
     */
    public static function saveProfile(): void {
        // Si se ha subido una imagen, guardarla en el servidor
        $imagePath = null;
        if ($_FILES) {
            // Si el usuario tenía la imagen por defecto, crear la imagen en vez de guardarla
            $cliente = Cliente::findOne($_SESSION['id'], [Cliente::CORREO, Cliente::RUTA_IMAGEN_PERFIL]);
            if ($cliente -> ruta_imagen_perfil === DefaultPath::DEFAULT_IMAGE_PROFILE) {
                $imagePath = ImageHelper::createImage($_FILES[Cliente::RUTA_IMAGEN_PERFIL], new ImageFolder($cliente -> correo, TypeImage::PROFILE_CUSTOMER));
            } else {
                $imagePath = ImageHelper::saveImage($_FILES[Cliente::RUTA_IMAGEN_PERFIL], DefaultPath::DEFAULT_IMAGE_CUSTOMER_DIR . '/' . $cliente -> correo);
            }
            if (!$imagePath) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::NO_UPLOAD_IMAGE);
                return;
            }
            unset($_POST[Cliente::RUTA_IMAGEN_PERFIL]);
        }
        if ($imagePath) {
            $_POST[Cliente::RUTA_IMAGEN_PERFIL] = $imagePath;
        }
        // Si se ha subido nueva contraseña, encriptarla
        if (isset($_POST[Cliente::CONTRASENIA])) {
            $_POST[Cliente::CONTRASENIA] = password_hash($_POST[Cliente::CONTRASENIA], PASSWORD_DEFAULT);
        }
        // Si no se ha enviado ningún dato, no realizar nada
        if (!$_POST) {
            Response::sendResponse(HttpStatusCode::OK);
            return;
        }
        $clienteFormulario = new Cliente($_POST);
        $clienteFormulario -> id = $_SESSION['id'];
        if (!$clienteFormulario -> save()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
                return;
            }
        }
        Response::sendResponse(HttpStatusCode::OK, null, [
            'imagenNueva' => $imagePath
        ]);
    }

    /**
     * Publica un {@see Comentario} sobre un {@see Producto}
     * @return void
     */
    public static function comment(): void {
        session_start();
        $_POST[Comentario::CLIENTE_ID] = $_SESSION['id'];
        $_POST[Comentario::FECHA_HORA_COMENTARIO] = date('Y-m-d H:i:s');
        $comentarioFormulario = new Comentario($_POST);
        if (!$comentarioFormulario -> create()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::NOT_FOUND, HttpErrorMessages::NO_ROWS);
            }
            return;
        }
        Response::sendResponse(HttpStatusCode::OK, null, [
            'cliente' => VComentarioClienteProducto::lastCustomerCommentInProduct($_POST[Comentario::PRODUCTO_ID], [
                VComentarioClienteProducto::NOMBRE_CLIENTE,
                VComentarioClienteProducto::APELLIDOS_CLIENTE,
                VComentarioClienteProducto::RUTA_IMAGEN_PERFIL,
                VComentarioClienteProducto::COMENTARIO,
                VComentarioClienteProducto::NUM_ESTRELLAS
            ])
        ]);
    }

    /**
     * Obtiene todos los {@see Cliente clientes} de la base de datos
     * @return void
     */
    public static function getAll(): void {
        AdminHelper::getAll(Cliente::class, [
            Cliente::ID,
            Cliente::NOMBRE,
            Cliente::APELLIDOS,
            Cliente::TELEFONO,
            Cliente::DIRECCION,
            Cliente::CORREO,
            Cliente::RUTA_IMAGEN_PERFIL
        ], VUsuarioRol::PERMISO_USUARIO);
    }

    /**
     * Crea un {@see Cliente} nuevo en la base de datos
     * @return void
     */
    public static function create(): void {
        $_POST[Cliente::CONTRASENIA] = password_hash($_POST[Cliente::CONTRASENIA], PASSWORD_DEFAULT);
        if ($_FILES) {
            $_POST[Cliente::RUTA_IMAGEN_PERFIL] = ImageHelper::createImage($_FILES[Cliente::RUTA_IMAGEN_PERFIL], new ImageFolder($_POST[Cliente::CORREO], TypeImage::PROFILE_CUSTOMER));
        } else {
            // Si no tiene imagen de perfil, aplicarle la de por defecto
            $_POST[Cliente::RUTA_IMAGEN_PERFIL] = DefaultPath::DEFAULT_IMAGE_PROFILE;
        }
        $clienteFormulario = new Cliente($_POST);
        if (!$clienteFormulario -> create()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::EXISTS);
            }
            return;
        }
        Response::sendResponse(HttpStatusCode::OK, HttpSuccessMessages::CREATED, [
            'entidades' => Cliente::last([
                Cliente::ID,
                Cliente::RUTA_IMAGEN_PERFIL
            ])
        ]);
    }

    /**
     * Actualiza un {@see Cliente} en la base de datos
     * @return void
     */
    public static function update(): void {
        $_POST[Cliente::CONTRASENIA] = password_hash($_POST[Cliente::CONTRASENIA], PASSWORD_DEFAULT);
        AdminHelper::updateRow(Cliente::class);
    }

    /**
     * Elimina un {@see Cliente} en la base de datos
     * @return void
     */
    public static function delete(): void {
        AdminHelper::deleteRow(Cliente::class);
    }

    /**
     * Comprueba si el usuario de la página contiene una sesión. Este método se utiliza para saber si un cliente
     * puede añadir productos al carrito o no, ya que si no tiene sesión, no podrá y se le enviará un mensaje de error
     * @return void
     */
    public static function hasCustomerSession() {
        if (AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
            Response::sendResponse(HttpStatusCode::OK, null, [
                'hasSession' => true
            ]);
        } else {
            Response::sendResponse(HttpStatusCode::UNAUTHORIZED, HttpErrorMessages::NO_CUSTOMER_SESSION, [
                'hasSession' => false
            ]);
        }
    }
}