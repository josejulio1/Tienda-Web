<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/utils/utils.php';
require_once __DIR__ . '/models/cliente.php';
function insert(string $tableName, array $fields) {
    $dbConnector = Database::connect();
    $db = $dbConnector -> getDatabase();
    if (!$db) {
        return http_response_code(SERVICE_UNAVAILABLE);
    }
    $sentence = "INSERT INTO $tableName (";
    $tableColums = array_keys($fields);
    $preparedValues = [];
    foreach ($tableColums as $column) {
        $sentence .= "$column,";
        $preparedValues[] = ":$column";
    }
    $sentence = substr($sentence, 0, strlen($sentence) - 1);
    $sentence .= ') VALUES (';
    foreach ($preparedValues as $value) {
        $sentence .= "$value,";
    }
    $sentence = substr($sentence, 0, strlen($sentence) - 1) . ')';
    $statement = $db -> prepare($sentence);
    $i = 0;
    foreach ($fields as $field) {
        $statement -> bindValue($preparedValues[$i++], $field);
    }
    try {
        $statement -> execute();
    } catch (Exception $e) {
        return NOT_FOUND;
    }
    return $statement -> rowCount() > 0 ? OK : NOT_FOUND;
}

// TODO: Solucionar SQL Injection
/**
 * Obtiene consultas de la base de datos.
 * @param string $tableName Nombre de la tabla que se desea realizar una consulta. Usar los modelos de la carpeta db. Por ejemplo:
 * select(usuario::class).
 * @param array $fields Opcional. Si no se usa esta opción, buscará por defecto todas las columnas. Para usarlo, hay que pasar
 * un array asociativo. Por ejemplo: [ usuario::ID, usuario::NOMBRE, usuario::APELLIDOS ], para filtrar que devuelva esas 3 columnas.
 * @param array $filters Opcional. Permite realizar filtros WHERE en la consulta. Se puede usar de dos formas.
 * La primera forma es sin usar los TypeFilters, que contiene los operadores = o <>. Para ello, pasar directamente lo que se quiere
 * filtrar. Por ejemplo: [ usuario::CORREO => 'micorreo@gmail.com'. En este caso, se compara si el correo es micorreo@gmail.com.
 * La segunda forma, es usando la clase TypeFilters. Por ejemplo: [ TypeFilters::DISTINCT => [ usuario::CORREO => 'micorreo@gmail.com' ]].
 * Se compara si el correo es distinto de micorreo@gmail.com.
 * @return array|int Devuelve un array asociativo (FETCH_ASSOC) con las consultas en caso de que se realice correctamente.
 * En caso de que la base de datos no funcione, realizará una respuesta HTTP con código 503
 */
function select(string $tableName, array $fields = null, array $filters = null, int $limit = null, int $offset = null, bool $count = false) {
    $dbConnector = Database::connect();
    if (!$dbConnector) {
        return SERVICE_UNAVAILABLE;
    }
    $db = $dbConnector -> getDatabase();
    $sentence = 'SELECT ';
    if ($count) {
        $sentence .= 'COUNT(*)';
    } else {
        if ($fields) {
            foreach ($fields as $field) {
                $sentence .= "$field,";
            }
            $sentence = substr($sentence, 0, strlen($sentence) - 1);
        } else {
            $sentence .= '*';
        }
    }
    $sentence .= ' FROM ' . $tableName;
    if ($filters) {
        $sentence .= ' WHERE ';
        $typeFilters = array_keys($filters);
        $i = 0;
        $containsTypeFilter = false;
        // foreach para verificar si los filtros pasados contienen TypeFilters o no
        foreach ($filters as $filter) {
            if (is_array($filter)) {
                $containsTypeFilter = true;
            }
            break;
        }
        if ($containsTypeFilter) {
            foreach ($filters as $filter) {
                foreach ($filter as $column => $value) {
                    $sentence .= "$column " . $typeFilters[$i++] . " '$value'";
                }
            }
        } else {
            foreach ($filters as $filter) {
                $sentence .= $typeFilters[$i++] . " = '$filter'";
            }
        }
    }
    if ($limit) {
        $sentence .= " LIMIT $limit";
    }
    if ($offset) {
        $sentence .= " OFFSET $offset";
    }
    $statement = $db -> query($sentence);
    return $statement -> fetchAll(PDO::FETCH_ASSOC);
}

function update(string $tableName, array $fields, array $filters) {
    $dbConnector = Database::connect();
    $db = $dbConnector -> getDatabase();
    if (!$db) {
        return http_response_code(SERVICE_UNAVAILABLE);
    }
    $sentence = "UPDATE $tableName SET ";
    $fieldsKeys = array_keys($fields);
    $preparedValues = [];
    foreach ($fieldsKeys as $fieldKey) {
        $sentence .= "$fieldKey = :$fieldKey,";
        $preparedValues[] = ":$fieldKey";
    }
    $sentence = substr($sentence, 0, strlen($sentence) - 1) . ' WHERE ';
    $filtersKeys = array_keys($filters);
    foreach ($filtersKeys as $filterKey) {
        $sentence .= "$filterKey = :$filterKey";
        $preparedValues[] = ":$filterKey";
    }
    $statement = $db -> prepare($sentence);
    $i = 0;
    foreach ($fields as $field) {
        $statement -> bindValue($preparedValues[$i++], $field);
    }
    foreach ($filters as $filter) {
        $statement -> bindValue($preparedValues[$i++], $filter);
    }
    return http_response_code($statement -> execute() ? OK : NOT_FOUND);
}

function deleteRow(string $tableName, array $keys) {
    $dbConnector = Database::connect();
    $db = $dbConnector -> getDatabase();
    if (!$db) {
        return http_response_code(SERVICE_UNAVAILABLE);
    }
    $sentence = "DELETE FROM $tableName WHERE ";
    $fieldsKeys = array_keys($keys);
    $preparedValues = [];
    foreach ($fieldsKeys as $fieldKey) {
        $sentence .= "$fieldKey = :$fieldKey,";
        $preparedValues[] = ":$fieldKey";
    }
    $sentence = substr($sentence, 0, strlen($sentence) - 1);
    $statement = $db -> prepare($sentence);
    $i = 0;
    foreach ($keys as $key) {
        $statement -> bindValue($preparedValues[$i++], $key);
    }
    $statement -> execute();
    return http_response_code($statement -> rowCount() > 0 ? OK : NOT_FOUND);
}
?>