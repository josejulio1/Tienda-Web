<?php
namespace API;

use Database\Database;
use Model\Cliente;
use Model\Rol;
use Model\Usuario;
use Model\VUsuarioRol;
use Util\API\AdminHelper;
use Util\API\HttpErrorMessages;
use Util\API\HttpStatusCode;
use Util\API\HttpSuccessMessages;
use Util\API\JsonHelper;
use Util\API\Response;
use Util\Constant\DefaultPath;

class RoleController {
    public static function getAll(): void {
        AdminHelper::getAll(Rol::class, [
            Rol::ID,
            Rol::NOMBRE,
            Rol::COLOR
        ], VUsuarioRol::PERMISO_ROL);
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
}