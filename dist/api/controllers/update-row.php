<?php
require_once __DIR__ . '/../utils/http-status-codes.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

$json = json_decode(file_get_contents('php://input'), true);
$fields = $json['fields'];
foreach ($fields as $field) {
    if ($field == '') {
        return http_response_code(INCORRECT_DATA);
    }
}
require_once __DIR__ . '/../../db/crud.php';
require_once __DIR__ . '/../../db/models/cliente.php';
$tableName = $json['tableName'];
$fields = $json['fields'];
// Si se va a actualizar un cliente y va a cambiar la contraseña, hashearla
if ($tableName == cliente::class && isset($fields[cliente::CONTRASENIA])) {
    $fields[cliente::CONTRASENIA] = password_hash($fields[cliente::CONTRASENIA], PASSWORD_DEFAULT);
}
return update($tableName, $fields, $json['filters']);
?>