<?php
require_once __DIR__ . '/../utils/http-status-codes.php';
session_start();
$statusCode = NOT_FOUND;
if ($_SESSION) {
    $statusCode = OK;
}
return http_response_code($statusCode);
?>