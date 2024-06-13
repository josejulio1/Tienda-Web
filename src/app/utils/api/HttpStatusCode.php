<?php
namespace Util\API;

/**
 * Clase con constantes donde se reúnen todos los códigos de respuesta HTTP utilizados en la aplicación
 * @author josejulio1
 * @version 1.0
 */
class HttpStatusCode {
    public const OK = 200;

    // Client
    public const UNAUTHORIZED = 401;
    public const NOT_FOUND = 404;
    public const INCORRECT_DATA = 400;

    // Server
    public const SERVICE_UNAVAILABLE = 503;
}