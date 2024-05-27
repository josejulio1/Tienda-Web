<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tienda principal">
    <title>BYTEMARKET - Inicio</title>
    <?php
    // Si se ha pasado CSS por la vista, incrustarlo
    if (isset($css)) {
        echo $css;
    }
    ?>
    <link rel="stylesheet" href="/assets/css/base/globals.css">
    <link rel="stylesheet" href="/assets/css/base/utils.css">
    <link rel="stylesheet" href="/assets/css/base/dark-mode.css">
    <script src="/assets/js/lib/jquery-3.7.1.min.js" defer></script>
    <?php
    // Si se ha pasado JavaScript por la vista, incrustarlo
    if (isset($js)) {
        echo $js;
    }
    ?>
    <script src="/assets/js/app/pages/dark-mode.js" defer></script>
</head>
<body>
    <?php
    echo $contenido;
    require_once __DIR__ . '/dark-mode.php';
    ?>
</body>
</html>