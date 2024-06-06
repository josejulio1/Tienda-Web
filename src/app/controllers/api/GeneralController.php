<?php
namespace API;

use Util\API\HttpStatusCode;
use Util\API\Response;

class GeneralController {
    public static function getSessionId() {
        session_start();
        Response::sendResponse(HttpStatusCode::OK, null, [
            'sessionId' => $_SESSION['id']
        ]);
    }
}