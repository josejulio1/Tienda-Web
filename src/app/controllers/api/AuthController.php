<?php
namespace API;

use Util\API\HttpStatusCode;
use Util\API\Response;
use Util\Auth\AuthHelper;

class AuthController {
    public static function closeSession(): void {
        AuthHelper::closeSession();
        Response::sendResponse(HttpStatusCode::OK);
    }
}