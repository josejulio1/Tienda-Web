<?php
namespace API;

use Database\Database;
use Model\CarritoItem;
use Model\Cliente;
use Model\Producto;
use Model\VCarritoCliente;
use Util\API\HttpErrorMessages;
use Util\API\HttpStatusCode;
use Util\API\Response;
use Util\Auth\AuthHelper;
use Util\Auth\RoleAccess;

/**
 * Controlador de API que maneja el {@see CarritoItem carrito} del {@see Cliente}
 * @author josejulio1
 * @version 1.0
 */
class CartController {
    /**
     * Obtiene todos los {@see Producto productos} del carrito de un {@see Cliente}
     * @return void
     */
    public static function getAll() {
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

    /**
     * Añade un {@see Producto} nuevo al {@see CarritoItem carrito} del {@see Cliente}
     * @return void
     */
    public static function add() {
        $productoId = $_POST[CarritoItem::PRODUCTO_ID];
        $data[CarritoItem::PRODUCTO_ID] = $productoId;
        $data[CarritoItem::CLIENTE_ID] = $_SESSION['id'];
        $data[CarritoItem::CANTIDAD] = 1;
        $carritoItem = new CarritoItem($data);
        if (!$carritoItem -> create(false)) {
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

    /**
     * Elimina un {@see Producto} del {@see CarritoItem carrito} de un {@see Cliente}
     * @return void
     */
    public static function delete() {
        $productoId = $_GET[CarritoItem::PRODUCTO_ID];
        if (!filter_var($productoId, FILTER_VALIDATE_INT)) {
            Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::UNKNOWN_ID);
            return;
        }

        $data[CarritoItem::PRODUCTO_ID] = $productoId;
        $data[CarritoItem::CLIENTE_ID] = $_SESSION['id'];
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

    /**
     * Establece la cantidad de un {@see Producto} perteneciente al {@see CarritoItem carrito}
     * @return void
     */
    public static function setQuantity() {
        $json = $_POST;
        $productoId = $json[VCarritoCliente::PRODUCTO_ID];
        if (!filter_var($productoId, FILTER_VALIDATE_INT)) {
            Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::UNKNOWN_ID);
            return;
        }

        if (Producto::findOne($productoId, [Producto::STOCK]) -> stock < intval($json[VCarritoCliente::CANTIDAD])) {
            Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::NO_STOCK);
            return;
        }

        if (!CarritoItem::setQuantity($productoId, $json[VCarritoCliente::CANTIDAD])) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::INCORRECT_DATA);
            }
            return;
        }
        Response::sendResponse(HttpStatusCode::OK);
    }

    /**
     * Incrementa la cantidad en +1 de un {@see Producto} en un {@see CarritoItem carrito}
     * @return void
     */
    public static function incrementQuantity(): void {
        self::operationQuantity(true);
    }

    /**
     * Incrementa la cantidad en -1 de un {@see Producto} en un {@see CarritoItem carrito}
     * @return void
     */
    public static function decrementQuantity() {
        self::operationQuantity(false);
    }

    /**
     * Incrementa o decrementa en 1 la cantidad de un {@see Producto} en un {@see CarritoItem carrito}
     * @param bool $isIncrement True si se desea incrementar la cantidad y false si se quiere decrementar
     * @return void
     */
    private static function operationQuantity(bool $isIncrement): void {
        $productoId = $_POST[VCarritoCliente::PRODUCTO_ID];
        if (!filter_var($productoId, FILTER_VALIDATE_INT)) {
            Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::UNKNOWN_ID);
            return;
        }

        $stock = Producto::findOne($productoId, [Producto::STOCK]) -> stock;
        session_start();
        if ($isIncrement) {
            if ($stock < CarritoItem::findQuantityByProductIdAndCustomer($productoId, $_SESSION['id'], [CarritoItem::CANTIDAD]) -> cantidad + 1) {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::NO_STOCK);
                return;
            }
        } else {
            if ($stock < 1) {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::NO_STOCK);
                return;
            }
        }

        if (!CarritoItem::operationQuantity($productoId, $isIncrement)) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::INCORRECT_DATA);
            }
            return;
        }
        Response::sendResponse(HttpStatusCode::OK, null, [
            'cantidad' => CarritoItem::findQuantityByProductIdAndCustomer($productoId, $_SESSION['id'], [CarritoItem::CANTIDAD]) -> cantidad
        ]);
    }
}