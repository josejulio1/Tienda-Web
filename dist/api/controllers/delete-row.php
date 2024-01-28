<?php
require_once __DIR__ . '/../utils/http-status-codes.php';
if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
    echo 'Acceso no autorizado';
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once '../../db/crud.php';
return deleteRow($_GET['tableName'], [
    'id' => $_GET['id']
]);
?>