<?php
require_once __DIR__ . '/../utils/http-status-codes.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

session_start();
$_SESSION = [];
return http_response_code(OK);
?>