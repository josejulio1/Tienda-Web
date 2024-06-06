<?php
namespace API;

use Database\Database;
use Model\Cliente;
use Model\Comentario;
use Model\Usuario;
use Model\VComentarioClienteProducto;
use Model\VUsuarioRol;
use Util\API\AdminHelper;
use Util\API\HttpErrorMessages;
use Util\API\HttpStatusCode;
use Util\API\HttpSuccessMessages;
use Util\API\JsonHelper;
use Util\API\Response;
use Util\Auth\AuthHelper;
use Util\Auth\RoleAccess;
use Util\Image\ImageFolder;
use Util\Image\ImageHelper;
use Util\Image\DefaultPath;
use Util\Image\TypeImage;

class CustomerController {
    public static function login(): void {
        $json = JsonHelper::getPostInJson();
        $clienteDb = Cliente::findByEmail($json[Cliente::CORREO], [
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
        $clienteFormulario = new Cliente($json);
        // Verificar si la contraseña es incorrecta
        if (!password_verify($clienteFormulario -> contrasenia, $clienteDb -> contrasenia)) {
            Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::INCORRECT_USER_OR_PASSWORD);
            return;
        }
        // En caso de que el usuario sea correcto, ofrecer sesión
        AuthHelper::startSession($clienteDb -> id, RoleAccess::CUSTOMER);
        Response::sendResponse(HttpStatusCode::OK);
    }

    public static function register() {

    }

    public static function saveProfile(): void {
        $data = $_POST;
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
            unset($data[Cliente::RUTA_IMAGEN_PERFIL]);
        }
        if ($imagePath) {
            $data[Cliente::RUTA_IMAGEN_PERFIL] = $imagePath;
        }
        // Si se ha subido nueva contraseña, encriptarla
        if (isset($data[Cliente::CONTRASENIA])) {
            $data[Cliente::CONTRASENIA] = password_hash($data[Cliente::CONTRASENIA], PASSWORD_DEFAULT);
        }
        // Si no se ha enviado ningún dato, no realizar nada
        if (!$data) {
            Response::sendResponse(HttpStatusCode::OK);
            return;
        }
        $clienteFormulario = new Cliente($data);
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

    public static function comment(): void {
        session_start();
        $json = JsonHelper::getPostInJson();
        $json[Comentario::CLIENTE_ID] = $_SESSION['id'];
        $comentarioFormulario = new Comentario($json);
        if (!$comentarioFormulario -> create()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::NOT_FOUND, HttpErrorMessages::NO_ROWS);
            }
            return;
        }
        Response::sendResponse(HttpStatusCode::OK, null, [
            'cliente' => VComentarioClienteProducto::findOne($_SESSION['id'], [
                VComentarioClienteProducto::NOMBRE_CLIENTE,
                VComentarioClienteProducto::APELLIDOS_CLIENTE,
                VComentarioClienteProducto::RUTA_IMAGEN_PERFIL,
                VComentarioClienteProducto::COMENTARIO,
                VComentarioClienteProducto::NUM_ESTRELLAS
            ], VComentarioClienteProducto::CLIENTE_ID)
        ]);
    }

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

    public static function create(): void {
        if (!AdminHelper::validateAuth('POST')) {
            return;
        }
        http_response_code(HttpStatusCode::OK);

        $_POST[Usuario::CONTRASENIA] = password_hash($_POST[Usuario::CONTRASENIA], PASSWORD_DEFAULT);
        $clienteFormulario = new Cliente($_POST);
        // Si no tiene imagen de perfil, aplicarle la de por defecto
        if (!$clienteFormulario -> ruta_imagen_perfil) {
            $clienteFormulario -> ruta_imagen_perfil = DefaultPath::DEFAULT_IMAGE_PROFILE;
        }
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

    public static function update(): void {
        AdminHelper::updateRow(Cliente::class);
    }

    public static function delete(): void {
        AdminHelper::deleteRow(Cliente::class);
    }

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