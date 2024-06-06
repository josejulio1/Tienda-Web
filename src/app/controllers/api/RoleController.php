<?php
namespace API;

use Database\Database;
use Model\Rol;
use Model\VUsuarioRol;
use Util\API\AdminHelper;
use Util\API\HttpErrorMessages;
use Util\API\HttpStatusCode;
use Util\API\HttpSuccessMessages;
use Util\API\Response;

class RoleController {
    public static function getAll(): void {
        AdminHelper::getAll(Rol::class, [
            Rol::ID,
            Rol::NOMBRE,
            Rol::COLOR
        ], VUsuarioRol::PERMISO_ROL);
    }

    public static function getAllPermissions(): void {
        $rolPermisos = Rol::findOne($_POST[Rol::ID], [
            Rol::PERMISO_USUARIO,
            Rol::PERMISO_PRODUCTO,
            Rol::PERMISO_MARCA,
            Rol::PERMISO_CATEGORIA,
            Rol::PERMISO_CLIENTE,
            Rol::PERMISO_ROL
        ]);
        $permissions = [
            $rolPermisos -> permiso_usuario,
            $rolPermisos -> permiso_producto,
            $rolPermisos -> permiso_marca,
            $rolPermisos -> permiso_categoria,
            $rolPermisos -> permiso_cliente,
            $rolPermisos -> permiso_rol
        ];
        Response::sendResponse(HttpStatusCode::OK, null, [
            'permissions' => $permissions
        ]);
    }

    public static function create(): void {
        if (!AdminHelper::validateAuth('POST')) {
            return;
        }
        http_response_code(HttpStatusCode::OK);

        // Eliminar # del hexadecimal del color
        $_POST[Rol::COLOR] = substr($_POST[Rol::COLOR], 1);
        $rolFormulario = new Rol($_POST);
        if (!$rolFormulario -> create()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::EXISTS);
            }
            return;
        }
        Response::sendResponse(HttpStatusCode::OK, HttpSuccessMessages::CREATED, [
            'entidades' => Rol::last([
                Rol::ID
            ])
        ]);
    }

    public static function update(): void {
        // Eliminar # del hexadecimal del color
        $_POST[Rol::COLOR] = substr($_POST[Rol::COLOR], 1);
        AdminHelper::updateRow(Rol::class);
    }

    public static function delete(): void {
        AdminHelper::deleteRow(Rol::class);
    }
}