<?php
namespace API;

use Database\Database;
use Model\Marca;
use Model\VUsuarioRol;
use Util\API\AdminHelper;
use Util\API\HttpErrorMessages;
use Util\API\HttpStatusCode;
use Util\API\HttpSuccessMessages;
use Util\API\JsonHelper;
use Util\API\Response;

class BrandController {
    public static function getAll(): void {
        AdminHelper::getAll(Marca::class, [Marca::ID, Marca::MARCA], VUsuarioRol::PERMISO_MARCA);
    }

    public static function create(): void {
        $marcaFormulario = new Marca($_POST);
        if (!$marcaFormulario -> create()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::EXISTS);
            }
            return;
        }
        Response::sendResponse(HttpStatusCode::OK, HttpSuccessMessages::CREATED, [
            'entidades' => Marca::last([Marca::ID])
        ]);
    }

    public static function update(): void {
        AdminHelper::updateRow(Marca::class);
    }

    public static function delete(): void {
        AdminHelper::deleteRow(Marca::class);
    }
}