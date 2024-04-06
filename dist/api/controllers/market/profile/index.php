<?php
require_once __DIR__ . '/../../../utils/http-status-codes.php';
require_once __DIR__ . '/../../../utils/RolAccess.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !$_SESSION || $_SESSION['rol'] != RolAccess::CUSTOMER) {
    return http_response_code(METHOD_NOT_ALLOWED);
}

require_once __DIR__ . '/../../../../db/crud.php';
require_once __DIR__ . '/../../../../db/utils/utils.php';
require_once __DIR__ . '/../../../../db/models/Cliente.php';
require_once __DIR__ . '/../../../utils/utils.php';
$statusCode = OK;
$completedPath = USER_DEFAULT_IMAGE_PATH;
$dataReturn = [];
if ($_FILES) {
    $customerImage = select(Cliente::class, [Cliente::RUTA_IMAGEN_PERFIL], [
        TypesFilters::EQUALS => [
            Cliente::ID => $_SESSION['id']
        ]
    ])[0][Cliente::RUTA_IMAGEN_PERFIL];
    $fileName = $_FILES[Cliente::RUTA_IMAGEN_PERFIL]['name'];
    $fileNameFormatted = uniqid() . substr($fileName, strpos($fileName, '.'));
    // Si tiene una foto de perfil personalizada, eliminar y colocar la nueva
    if ($customerImage != USER_DEFAULT_IMAGE_PATH) {
        unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $customerImage);
        $customerPath = array_slice(explode('/', $customerImage), 0, -1);
        $completedPath = join('/', $customerPath) . '/' . $fileNameFormatted;
    } else {
        // En caso de que el cliente no tenga una foto personalizada, crearle una carpeta antes
        $customerPath = '/assets/img/internal/customers/' . $_SESSION['correo'] . '/';
        mkdir($_SERVER['DOCUMENT_ROOT'] . $customerPath);
        $completedPath = $customerPath . $fileNameFormatted;
    }
    move_uploaded_file($_FILES[Cliente::RUTA_IMAGEN_PERFIL]['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $completedPath);
    $statusCode = update(Cliente::class, [Cliente::RUTA_IMAGEN_PERFIL => $completedPath], [
        Cliente::ID => $_SESSION['id']
    ]);
}
if ($statusCode != OK) {
    $dataReturn['status'] = $statusCode;
    echo json_encode($dataReturn);
    return;
} else if ($_FILES) {
    $dataReturn[Cliente::RUTA_IMAGEN_PERFIL] = $completedPath;
}

if (isset($_POST[Cliente::NOMBRE])) {
    $statusCode = update(Cliente::class, [
        Cliente::NOMBRE => $_POST[Cliente::NOMBRE]
    ], [
        Cliente::ID => $_SESSION['id']
    ]);
}
if ($statusCode != OK) {
    $dataReturn['status'] = $statusCode;
    echo json_encode($dataReturn);
    return;
}

if (isset($_POST[Cliente::APELLIDOS])) {
    $statusCode = update(Cliente::class, [
        Cliente::APELLIDOS => $_POST[Cliente::APELLIDOS]
    ], [
        Cliente::ID => $_SESSION['id']
    ]);
}
if ($statusCode != OK) {
    $dataReturn['status'] = $statusCode;
    echo json_encode($dataReturn);
    return;
}

if (isset($_POST[Cliente::TELEFONO])) {
    $statusCode = update(Cliente::class, [
        Cliente::TELEFONO => $_POST[Cliente::TELEFONO]
    ], [
        Cliente::ID => $_SESSION['id']
    ]);
}
if ($statusCode != OK) {
    $dataReturn['status'] = $statusCode;
    echo json_encode($dataReturn);
    return;
}

if (isset($_POST[Cliente::CONTRASENIA])) {
    $statusCode = update(Cliente::class, [
        Cliente::CONTRASENIA => password_hash($_POST[Cliente::CONTRASENIA], PASSWORD_DEFAULT)
    ], [
        Cliente::ID => $_SESSION['id']
    ]);
}
$dataReturn['status'] = $statusCode;
echo json_encode($dataReturn);