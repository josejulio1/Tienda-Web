<?php
namespace API;

use Database\Database;
use Model\Chat;
use Model\Cliente;
use Util\API\HttpErrorMessages;
use Util\API\HttpStatusCode;
use Util\API\JsonHelper;
use Util\API\Response;
use Util\Auth\RoleAccess;
use WebSocket\Client;

class ChatController {
    public static function sendMessage() {
        $json = JsonHelper::getPostInJson();
        $json[Chat::FECHA] = date('Y-m-d');
        $esCliente = $_SESSION['rol'] === RoleAccess::CUSTOMER;
        if ($esCliente) {
            $json[Chat::CLIENTE_ID] = $_SESSION['id']; // Si el mensaje lo ha enviado un cliente, asignar el id de sesión del cliente
        }
        $chat = new Chat($json);
        if (!$chat -> create()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            }
            return;
        }
        $messageData = null;
        if ($esCliente) {
            $messageData = Cliente::findOne($_SESSION['id'], [Cliente::RUTA_IMAGEN_PERFIL]);
        }
        Response::sendResponse(HttpStatusCode::OK, null, [
            'ruta-imagen-perfil' =>
        ]);
    }
}