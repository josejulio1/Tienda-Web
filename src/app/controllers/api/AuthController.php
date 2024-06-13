<?php
namespace API;

use Util\API\HttpStatusCode;
use Util\API\Response;
use Util\Auth\AuthHelper;

/**
 * Controlador de API exclusivamente para cerrar la sesión de un usuario
 * @author josejulio1
 * @version 1.0
 */
class AuthController {
    /**
     * Cierra la sesión de un usuario o cliente
     * @return void
     */
    public static function closeSession(): void {
        AuthHelper::closeSession();
        Response::sendResponse(HttpStatusCode::OK);
    }
}