<?php
namespace API;

use Database\Database;
use http\Client;
use Model\Cliente;
use Model\Usuario;
use Model\VUsuarioRol;
use Util\API\AdminHelper;
use Util\API\HttpErrorMessages;
use Util\API\HttpStatusCode;
use Util\API\HttpSuccessMessages;
use Util\API\JsonHelper;
use Util\API\Response;
use Util\Auth\AuthHelper;
use Util\Auth\RoleAccess;
use Util\Constant\DefaultPath;

class CustomerController {
    public static function login(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(HttpStatusCode::METHOD_NOT_ALLOWED);
            return;
        }
        if (AuthHelper::isAuthenticated()) {
            http_response_code(HttpStatusCode::UNAUTHORIZED);
            return;
        }
        http_response_code(HttpStatusCode::OK);

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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(HttpStatusCode::UNAUTHORIZED);
            return;
        }
        if (!AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
            header('Location: /');
        }
        http_response_code(HttpStatusCode::OK);

        $clienteFormulario = new Cliente(JsonHelper::getPostInJson());
        $clienteFormulario -> id = $_SESSION['id'];
        if (!$clienteFormulario -> save()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
                return;
            }
        }
        Response::sendResponse(HttpStatusCode::OK, null, [
            'entidades' => Cliente::find($_SESSION['id'], [Cliente::RUTA_IMAGEN_PERFIL])
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

        $json = JsonHelper::getPostInJson();
        $json[Usuario::CONTRASENIA] = password_hash($json[Usuario::CONTRASENIA], PASSWORD_DEFAULT);
        $clienteFormulario = new Cliente($json);
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