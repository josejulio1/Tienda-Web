<?php
namespace Util\API;

class HttpStatusCode {
    public const OK = 200;

    // Client
    public const UNAUTHORIZED = 401;
    public const METHOD_NOT_ALLOWED = 405;
    public const NOT_FOUND = 404;
    public const INCORRECT_DATA = 422;

    // Server
    public const SERVICE_UNAVAILABLE = 503;
}