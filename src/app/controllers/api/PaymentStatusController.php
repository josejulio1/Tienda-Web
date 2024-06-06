<?php
namespace API;

use Model\EstadoPago;
use Util\API\HttpStatusCode;
use Util\API\Response;

class PaymentStatusController {
    public static function getAll(): void {
        Response::sendResponse(HttpStatusCode::OK, null, [
            'estadosPago' => EstadoPago::all([EstadoPago::ID, EstadoPago::NOMBRE])
        ]);
    }
}