<?php
namespace API;

use Database\Database;
use Model\CarritoItem;
use Model\Cliente;
use Model\Pedido;
use Model\Pedido_Producto_Item;
use Model\Producto;
use Model\VPedido;
use Util\API\AdminHelper;
use Util\API\HttpErrorMessages;
use Util\API\HttpStatusCode;
use Util\API\Response;

/**
 * Controlador de API para la tabla {@see Pedido}
 * @author josejulio1
 * @version 1.0
 */
class OrderController {
    /**
     * Obtiene todos los {@see Pedido pedidos} de un {@see Cliente} en la base de datos
     * @return void
     */
    public static function getAll(): void {
        Response::sendResponse(HttpStatusCode::OK, null, [
            'pedidos' => VPedido::find($_POST[VPedido::CLIENTE_ID], [
                VPedido::ID,
                VPedido::NOMBRE_PRODUCTO,
                VPedido::METODO_PAGO,
                VPedido::ESTADO_PAGO,
                VPedido::DIRECCION_ENVIO
            ])
        ]);
    }

    /**
     * Crea un {@see Pedido} nueva en la base de datos
     * @return void
     */
    public static function create(): void {
        $_POST[Pedido::CLIENTE_ID] = $_SESSION['id'];
        // El estado de pago con ID 3 es Pendiente
        $_POST[Pedido::ESTADO_PAGO_ID] = 3;
        $pedidoFormulario = new Pedido($_POST);
        if (!$pedidoFormulario -> create()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::INCORRECT_DATA);
            }
            return;
        }
        // Guardar productos del carrito del cliente
        $pedidoId = Pedido::last([Pedido::ID]) -> id;
        $productosCarrito = CarritoItem::find($_SESSION['id'], [
            CarritoItem::PRODUCTO_ID,
            CarritoItem::CLIENTE_ID,
            CarritoItem::CANTIDAD,
        ]);
        foreach ($productosCarrito as $productoCarrito) {
            $pedidoProductoItem = [
                Pedido_Producto_Item::PEDIDO_ID => $pedidoId,
                Pedido_Producto_Item::PRODUCTO_ID => $productoCarrito -> { CarritoItem::PRODUCTO_ID },
                Pedido_Producto_Item::CANTIDAD_PRODUCTO => $productoCarrito -> { CarritoItem::CANTIDAD },
                Pedido_Producto_Item::PRECIO_PRODUCTO => Producto::findOne($productoCarrito -> { CarritoItem::PRODUCTO_ID }, [Producto::PRECIO]) -> precio
            ];
            if (!((new Pedido_Producto_Item($pedidoProductoItem)) -> create(false))) {
                if (!Database::isConnected()) {
                    Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
                } else {
                    Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::INCORRECT_DATA);
                }
                return;
            }
        }
        // En caso de que todo se haya insertado correctamente, eliminar el carrito del cliente
        if (!CarritoItem::emptyCart($_SESSION['id'])) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
                return;
            }
        }
        Response::sendResponse(HttpStatusCode::OK);
    }

    /**
     * Actualiza un {@see Pedido} en la base de datos
     * @return void
     */
    public static function update(): void {
        AdminHelper::updateRow(Pedido::class);
    }
}