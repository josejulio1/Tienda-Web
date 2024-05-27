<?php
namespace API;

use Database\Database;
use Model\Categoria;
use Model\Marca;use Model\VUsuarioRol;
use Util\API\AdminHelper;
use Util\API\HttpErrorMessages;
use Util\API\HttpStatusCode;
use Util\API\HttpSuccessMessages;
use Util\API\JsonHelper;
use Util\API\Response;

class CategoryController {
    public static function getAll(): void {
        AdminHelper::getAll(Categoria::class, [Categoria::ID, Categoria::NOMBRE], VUsuarioRol::PERMISO_CATEGORIA);
    }

    public static function create(): void {
        if (!AdminHelper::validateAuth('POST')) {
            return;
        }
        http_response_code(HttpStatusCode::OK);

        $marcaFormulario = new Categoria(JsonHelper::getPostInJson());
        if (!$marcaFormulario -> create()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::EXISTS);
            }
            return;
        }
        Response::sendResponse(HttpStatusCode::OK, HttpSuccessMessages::CREATED, [
            'entidades' => Categoria::last([Categoria::ID])
        ]);
    }

    public static function update(): void {
        AdminHelper::updateRow(Categoria::class);
    }

    public static function delete(): void {
        AdminHelper::deleteRow(Categoria::class);
    }
}