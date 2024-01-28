<?php
require_once __DIR__ . '/../utils/http-status-codes.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

$json = json_decode(file_get_contents('php://input'), true);
$fields = $json['fields'];
foreach ($fields as $field) {
    if (!$field) {
        return http_response_code(INCORRECT_DATA);
    }
}
require_once '../../db/crud.php';
return update($json['tableName'], $json['fields'], $json['filters']);
?>