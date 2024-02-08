<?php
require_once __DIR__ . '/../utils/http-status-codes.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once __DIR__ . '/../../db/crud.php';

$correo = $_POST['correo'];
$mantenerSesion = $_POST['mantener-sesion'];

$rows = select($_GET['table-name'], ['id', 'contrasenia'], [
    TypesFilters::EQUALS => [
        'correo' => $correo
    ]
]);
// Si las filas contienen un número, ha fallado la consulta
if (is_numeric($rows)) {
    return http_response_code($rows);
}

if (count($rows) == 0) {
    return http_response_code(NOT_FOUND);
}
if (!password_verify($_POST['contrasenia'], $rows[0]['contrasenia'])) {
    return http_response_code(INCORRECT_DATA);
}
// Si el login fue extioso, crear la sesión
/* if ($mantenerSesion == 'true') {
    // Mantener sesión iniciada por 2 semanas
    session_set_cookie_params(60 * 60 * 24 * 14);
} */
session_start();
$_SESSION['id'] = $rows[0]['id'];
$_SESSION['correo'] = $correo;
return http_response_code(OK);
?>