<?php
namespace API;

use Database\Database;
use Model\CarritoItem;
use Model\Producto;
use Model\VCarritoCliente;
use Util\API\HttpErrorMessages;
use Util\API\HttpStatusCode;
use Util\API\JsonHelper;
use Util\API\Response;
use Util\Auth\AuthHelper;
use Util\Auth\RoleAccess;

class CartController {
    public static function getAll() {
        http_response_code(HttpStatusCode::OK);

        Response::sendResponse(HttpStatusCode::OK, null, [
            'carritoItems' => AuthHelper::isAuthenticated(RoleAccess::CUSTOMER) ? VCarritoCliente::find($_SESSION['id'], [
                VCarritoCliente::CLIENTE_ID,
                VCarritoCliente::PRODUCTO_ID,
                VCarritoCliente::NOMBRE_PRODUCTO,
                VCarritoCliente::PRECIO_PRODUCTO,
                VCarritoCliente::CANTIDAD,
                VCarritoCliente::RUTA_IMAGEN_PRODUCTO
            ]) : null
        ]);
    }

    public static function add() {
        if (!AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
            header('Location: /');
        }

        $productoId = JsonHelper::getPostInJson()[CarritoItem::PRODUCTO_ID];
        $data[CarritoItem::PRODUCTO_ID] = $productoId;
        $data[CarritoItem::CLIENTE_ID] = $_SESSION['id'];
        $data[CarritoItem::CANTIDAD] = 1;
        $carritoItem = new CarritoItem($data);
        if (!$carritoItem -> create()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::NO_ADD_CART);
            }
            return;
        }
        Response::sendResponse(HttpStatusCode::OK, null, [
            'carritoItem' => VCarritoCliente::findByProductId($productoId, [
                VCarritoCliente::PRODUCTO_ID,
                VCarritoCliente::NOMBRE_PRODUCTO,
                VCarritoCliente::PRECIO_PRODUCTO,
                VCarritoCliente::RUTA_IMAGEN_PRODUCTO,
                VCarritoCliente::CANTIDAD
            ])
        ]);
    }

    public static function delete() {
        $productoId = $_GET[CarritoItem::PRODUCTO_ID];
        if (!filter_var($productoId, FILTER_VALIDATE_INT)) {
            Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::UNKNOWN_ID);
            return;
        }

        $data[CarritoItem::PRODUCTO_ID] = $productoId;
        $carritoItem = new CarritoItem($data);
        if (!$carritoItem -> deleteItem()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::INCORRECT_DATA);
            }
            return;
        }
        Response::sendResponse(HttpStatusCode::OK);
    }

    public static function setQuantity() {
        $json = JsonHelper::getPostInJson();
        $id = $json[VCarritoCliente::PRODUCTO_ID];
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::UNKNOWN_ID);
            return;
        }

        if (!CarritoItem::setQuantity($id, $json[VCarritoCliente::CANTIDAD])) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::INCORRECT_DATA);
            }
            return;
        }
        Response::sendResponse(HttpStatusCode::OK);
    }

    public static function incrementQuantity(): void {
        self::operationQuantity(true);
    }

    public static function decrementQuantity() {
        self::operationQuantity(false);
    }

    private static function operationQuantity(bool $increment) {
        $id = JsonHelper::getPostInJson()[VCarritoCliente::PRODUCTO_ID];
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::UNKNOWN_ID);
            return;
        }

        if (!CarritoItem::operationQuantity($id, $increment)) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::INCORRECT_DATA);
            }
            return;
        }
        Response::sendResponse(HttpStatusCode::OK);
    }
}