<?php
namespace API;

use Database\Database;
use Model\Chat;
use Model\Cliente;
use Model\VChatClienteInfo;
use Util\API\HttpErrorMessages;
use Util\API\HttpStatusCode;
use Util\API\Response;

/**
 * Controlador de API que maneja el {@see Chat} de la tienda
 * @author josejulio1
 * @version 1.0
 */
class ChatController {
    /**
     * Obtiene los {@see Cliente clientes} que han enviado un mensaje al panel de admin, para que pueda
     * verlos y hablar los empleados de la tienda
     * @return void
     */
    public static function getCustomers() {
        Response::sendResponse(HttpStatusCode::OK, null, [
            'clientes' => VChatClienteInfo::all([
                VChatClienteInfo::CLIENTE_ID,
                VChatClienteInfo::RUTA_IMAGEN_PERFIL,
                VChatClienteInfo::CORREO
            ])
        ]);
    }

    /**
     * Recupera todos los mensajes de un {@see Cliente} en el panel de admin
     * @return void
     */
    public static function openCustomerChat() {
        session_start();
        $id = $_GET['id'] ?? $_SESSION['id'];
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::INCORRECT_DATA);
            return;
        }
        Response::sendResponse(HttpStatusCode::OK, null, [
            'mensajes' => VChatClienteInfo::find($id, [
                VChatClienteInfo::RUTA_IMAGEN_PERFIL,
                VChatClienteInfo::MENSAJE,
                VChatClienteInfo::ES_CLIENTE
            ])
        ]);
    }

    /**
     * Guarda un mensaje de un {@see Cliente} en la base de datos
     * @return void
     */
    public static function sendMessage() {
        session_start();
        $_POST[Chat::FECHA] = date('Y-m-d');
        // Si contiene un ID de cliente, es un administrador, en caso contrario, el mensaje lo envía un cliente
        $_POST[Chat::CLIENTE_ID] = $_POST[Chat::CLIENTE_ID] ?? $_SESSION['id'];
        $chat = new Chat($_POST);
        if (!$chat -> create(false)) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            }
            return;
        }
        Response::sendResponse(HttpStatusCode::OK);
    }
}