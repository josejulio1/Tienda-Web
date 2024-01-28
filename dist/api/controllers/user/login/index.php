<?php
require_once __DIR__ . '/../../../utils/http-status-codes.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once __DIR__ . '/../../../../db/Database.php';
require_once __DIR__ . '/../../../../api/utils/login.php';

$correo = $_POST['correo'];
$contrasenia = $_POST['contrasenia'];
$mantenerSesion = 'false';

$dbConnector = Database::connect();
if (!$dbConnector) {
    return http_response_code(SERVICE_UNAVAILABLE);
}
$db = $dbConnector -> getDatabase();
$statement = $db -> prepare('SELECT * FROM v_usuario_rol WHERE correo = :correo');
$statement -> bindParam(':correo', $correo);
$statement -> execute();
if ($statement -> rowCount() == 0) {
    return http_response_code(NOT_FOUND);
}
$result = $statement -> fetch(PDO::FETCH_ASSOC);
if (!password_verify($contrasenia, $result['contrasenia'])) {
    return http_response_code(INCORRECT_DATA);
}
// Si el login fue extioso, crear la sesión
if ($mantenerSesion == 'true') {
    // Mantener sesión iniciada por 2 semanas
    session_set_cookie_params(60 * 60 * 24 * 14);
}
session_start();
$_SESSION['usuario'] = $result['usuario'];
$_SESSION['correo'] = $result['correo'];
$_SESSION['nombre_rol'] = $result['nombre_rol'];
$_SESSION['color_rol'] = $result['color_rol'];
$_SESSION['ruta_imagen_perfil'] = $result['ruta_imagen_perfil'];
return http_response_code(OK);

/* $statusCode = login($_POST['table-name'], $_POST['correo'], $_POST['contrasenia'], $_POST['mantener-sesion']);

if ($statusCode != OK) {
    return http_response_code($statusCode);
}
$_SESSION['usuario'] = $result['usuario'];
$_SESSION['correo'] = $result['correo'];
$_SESSION['nombre_rol'] = $result['nombre_rol'];
$_SESSION['color_rol'] = $result['color_rol'];
$_SESSION['ruta_imagen_perfil'] = $result['ruta_imagen_perfil']; */
?>