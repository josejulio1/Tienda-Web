<?php
require_once __DIR__ . '/http-status-codes.php';
require_once __DIR__ . '/../../db/crud.php';
require_once __DIR__ . '/../../db/utils/utils.php';
function login($tableName, $correo, $contrasenia, $mantenerSesion) {
    $rows = select($tableName, null, [
        TypesFilters::EQUALS => [
            'correo' => $correo
        ]
    ]);
    /* $db = $dbConnector -> getDatabase();
    $statement = $db -> prepare("SELECT * FROM $tableName WHERE correo = :correo");
    $statement -> bindParam(':correo', $correo);
    $statement -> execute(); */    
    if (count($rows) == 0) {
        return http_response_code(NOT_FOUND);
    }
    if (!password_verify($contrasenia, $rows[0]['contrasenia'])) {
        return http_response_code(INCORRECT_DATA);
    }
    // Si el login fue extioso, crear la sesión
    /* if ($mantenerSesion == 'true') {
        // Mantener sesión iniciada por 2 semanas
        session_set_cookie_params(60 * 60 * 24 * 14);
    } */
    /* session_start(); */
    /* $_SESSION['usuario'] = $result['usuario'];
    $_SESSION['correo'] = $result['correo'];
    $_SESSION['nombre_rol'] = $result['nombre_rol'];
    $_SESSION['color_rol'] = $result['color_rol'];
    $_SESSION['ruta_imagen_perfil'] = $result['ruta_imagen_perfil']; */
    return http_response_code(OK);
}
?>