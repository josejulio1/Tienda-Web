<?php
require_once __DIR__ . '/../../utils/http-status-codes.php';
require_once __DIR__ . '/../../utils/RolAccess.php';
session_start();
$statusCode = NOT_FOUND;
if ($_SESSION && $_SESSION['rol'] == RolAccess::CUSTOMER) {
    $statusCode = OK;
}
return http_response_code($statusCode);