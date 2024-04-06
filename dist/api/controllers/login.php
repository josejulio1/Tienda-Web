<?php
require_once __DIR__ . '/../utils/http-status-codes.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once __DIR__ . '/../../db/crud.php';

$correo = $_POST['correo'];
$mantenerSesion = $_POST['mantener-sesion'];
$tableName = $_GET['table-name'];

$rows = select($tableName, ['id', 'contrasenia'], [
    TypesFilters::EQUALS => [
        'correo' => $correo
    ]
]);
// Si las filas contiene el código de estado 503, ha fallado la consulta
if (is_numeric($rows)) {
    return http_response_code($rows);
}

if (count($rows) == 0) {
    return http_response_code(NOT_FOUND);
}
if (!password_verify($_POST['contrasenia'], $rows[0]['contrasenia'])) {
    return http_response_code(INCORRECT_DATA);
}
require_once __DIR__ . '/../utils/RolAccess.php';
require_once __DIR__ . '/../../db/models/Usuario.php';
require_once __DIR__ . '/../../db/models/Cliente.php';
session_start();
$_SESSION['id'] = $rows[0]['id'];
if ($tableName == Usuario::class) {
    $_SESSION['rol'] = RolAccess::USER;
} else {
    $_SESSION['rol'] = RolAccess::CUSTOMER;
}
$_SESSION['correo'] = $correo;
return http_response_code(OK);