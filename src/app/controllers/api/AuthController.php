<?php
namespace API;

use Util\API\HttpStatusCode;
use Util\API\Response;
use Util\Auth\AuthHelper;

class AuthController {
    public static function closeSession(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(HttpStatusCode::METHOD_NOT_ALLOWED);
            return;
        }
        http_response_code(HttpStatusCode::OK);
        AuthHelper::closeSession();
        Response::sendResponse(HttpStatusCode::OK);
    }
}