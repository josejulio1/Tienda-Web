<?php
namespace API;

use Database\Database;
use Model\Pedido;
use Model\VPedido;
use Util\API\HttpErrorMessages;
use Util\API\HttpStatusCode;
use Util\API\JsonHelper;
use Util\API\Response;

class OrderController {
    public static function getAll() {
        Response::sendResponse(HttpStatusCode::OK, null, [
            'pedidos' => VPedido::find(JsonHelper::getPostInJson()[VPedido::CLIENTE_ID], [
                VPedido::ID,
                VPedido::NOMBRE_PRODUCTO,
                VPedido::METODO_PAGO,
                VPedido::ESTADO_PAGO,
                VPedido::DIRECCION_ENVIO
            ])
        ]);
    }

    public static function update() {
        $pedido = new Pedido(JsonHelper::getPostInJson());
        if (!$pedido -> save()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::UNKNOWN_ID);
            }
            return;
        }
        Response::sendResponse(HttpStatusCode::OK);
    }
}