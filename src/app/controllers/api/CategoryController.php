<?php
namespace API;

use Database\Database;
use Model\Categoria;
use Model\VUsuarioRol;
use Util\API\AdminHelper;
use Util\API\HttpErrorMessages;
use Util\API\HttpStatusCode;
use Util\API\HttpSuccessMessages;
use Util\API\Response;

/**
 * Controlador de API para la tabla {@see Categoria}
 * @author josejulio1
 * @version 1.0
 */
class CategoryController {
    public static function getAll(): void {
        AdminHelper::getAll(Categoria::class, [Categoria::ID, Categoria::NOMBRE], VUsuarioRol::PERMISO_CATEGORIA);
    }

    /**
     * Crea una {@see Categoria} nueva en la base de datos
     * @return void
     */
    public static function create(): void {
        $marcaFormulario = new Categoria($_POST);
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

    /**
     * Actualiza una {@see Categoria} en la base de datos
     * @return void
     */
    public static function update(): void {
        AdminHelper::updateRow(Categoria::class);
    }

    /**
     * Elimina una {@see Categoria} en la base de datos
     * @return void
     */
    public static function delete(): void {
        AdminHelper::deleteRow(Categoria::class);
    }
}