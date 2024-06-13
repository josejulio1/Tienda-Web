<?php
namespace API;

use Model\EstadoPago;
use Util\API\HttpStatusCode;
use Util\API\Response;

/**
 * Controlador de API para la tabla {@see EstadoPago}
 * @author josejulio1
 * @version 1.0
 */
class PaymentStatusController {
    /**
     * Obtiene todos los {@see EstadoPago estados de pago} de la base de datos.
     * Se utiliza exclusivamente en el panel de admin para modificar el estado de un pago
     * @return void
     */
    public static function getAll(): void {
        Response::sendResponse(HttpStatusCode::OK, null, [
            'estadosPago' => EstadoPago::all([EstadoPago::ID, EstadoPago::NOMBRE])
        ]);
    }
}