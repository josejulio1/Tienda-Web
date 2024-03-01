<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/utils/utils.php';
/**
 * Introduce un registro en la base de datos
 * @param string $tableName Nombre de la tabla que se desea realizar una inserción. Usar los modelos de la carpeta db. Por ejemplo:
 * insert(Usuario::class).
 * @param array $fields Columnas en el que se insertarán información. Ejemplo: [Usuario::NOMBRE => 'Pepito'].
 * @return bool|int
 */
function insert(string $tableName, array $fields): bool|int {
    $dbConnector = Database::connect();
    if (!$dbConnector) {
        return SERVICE_UNAVAILABLE;
    }
    $db = $dbConnector -> getDatabase();
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

/**
 * Obtiene consultas de la base de datos.
 * @param string $tableName Nombre de la tabla que se desea realizar una consulta. Usar los modelos de la carpeta db. Por ejemplo:
 * select(Usuario::class).
 * @param array|null $fields Opcional. Si no se usa esta opción, buscará por defecto todas las columnas. Para usarlo, hay que pasar
 * un array asociativo. Por ejemplo: [ Usuario::ID, Usuario::NOMBRE, Usuario::APELLIDOS ], para filtrar que devuelva esas 3 columnas.
 * @param array|null $filters Opcional. Permite realizar filtros WHERE en la consulta. Se puede usar de dos formas.
 * La primera forma es sin usar los TypeFilters, que contiene los operadores = o <>. Para ello, pasar directamente lo que se quiere
 * filtrar. Por ejemplo: [ Usuario::CORREO => 'micorreo@gmail.com'. En este caso, se compara si el correo es micorreo@gmail.com.
 * La segunda forma, es usando la clase TypeFilters. Por ejemplo: [ TypeFilters::DISTINCT => [ Usuario::CORREO => 'micorreo@gmail.com' ]].
 * Se compara si el correo es distinto de micorreo@gmail.com.
 * @param array|null $orders
 * @param int|null $limit
 * @return array|int Devuelve un array asociativo (FETCH_ASSOC) con las consultas en caso de que se realice correctamente.
 * En caso de que la base de datos no funcione, realizará una respuesta HTTP con código 503
 */
function select(string $tableName, array $fields = null, array $filters = null, array $orders = null, int $limit = null): array|int {
    $dbConnector = Database::connect();
    if (!$dbConnector) {
        return SERVICE_UNAVAILABLE;
    }
    $db = $dbConnector -> getDatabase();
    $sentence = 'SELECT ';
    if ($fields) {
        foreach ($fields as $field) {
            $sentence .= "$field,";
        }
        $sentence = substr($sentence, 0, strlen($sentence) - 1);
    } else {
        $sentence .= '*';
    }
    $sentence .= ' FROM ' . $tableName;
    $preparedValues = [];
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
                    $sentence .= "$column " . $typeFilters[$i] . ' ?';
                    if ($typeFilters[$i++] != TypesFilters::BEGIN) {
                        $preparedValues[] .= "$value";
                    } else {
                        $preparedValues[] .= "$value%";
                    }
                }
            }
        } else {
            // Si no se usan TypeFilters, es porque se da por hecho que el usuario quiere filtrar por =
            foreach ($filters as $filter) {
                $sentence .= $typeFilters[$i++] . " = ?";
                $preparedValues[] = $filter;
            }
        }
    }
    if ($orders) {
        $sentence .= ' ORDER BY ';
        foreach ($orders as $order => $value) {
            $sentence .= "$value $order";
        }
    }
    if ($limit) {
        $sentence .= ' LIMIT ?';
        $preparedValues[] = $limit;
    }
    $statement = $db -> prepare($sentence);
    $i = 0;
    foreach ($preparedValues as $value) {
        $dataType = PDO::PARAM_STR;
        if (gettype($value) == 'integer') {
            $dataType = PDO::PARAM_INT;
        }
        $statement -> bindValue(++$i, $value, $dataType);
    }
    $statement -> execute();
    return $statement -> fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Actualiza un registro de la base de datos
 * @param string $tableName Nombre de la tabla que se desea realizar una actualización. Usar los modelos de la carpeta db. Por ejemplo:
 * update(Usuario::class).
 * @param array $fields Columnas que se desea actualizar la información. Ejemplo: [Usuario::NOMBRE => 'Pepito'].
 * @param array $filters Filtro para indicar las filas que se desea que afecte esta actualización.
 * Ejemplo: [ TypeFilters::EQUALS => [ Usuario::ID => 4 ] ] actualizará las columnas indicadas de una fila en el que el ID del
 * usuario sea igual a 4.
 * @return bool|int
 */
function update(string $tableName, array $fields, array $filters): bool|int {
    $dbConnector = Database::connect();
    if (!$dbConnector) {
        return SERVICE_UNAVAILABLE;
    }
    $db = $dbConnector -> getDatabase();
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

/**
 * Elimina una o varias filas de la base de datos
 * @param string $tableName Nombre de la tabla que se desea realizar una eliminación. Usar los modelos de la carpeta db. Por ejemplo:
 * deleteRow(Usuario::class).
 * @param array $keys Filtro a aplicar a las filas que se quieran eliminar. Ejemplo: [ Usuario::ID => 3 ] elimina el usuario con ID 3.
 * En caso de poner más elementos en los filtros, se aplicará un AND para separar cada filtro.
 * @return bool|int
 */
function deleteRow(string $tableName, array $keys): bool|int {
    $dbConnector = Database::connect();
    if (!$dbConnector) {
        return SERVICE_UNAVAILABLE;
    }
    $db = $dbConnector -> getDatabase();
    $sentence = "DELETE FROM $tableName WHERE ";
    $fieldsKeys = array_keys($keys);
    $preparedValues = [];
    foreach ($fieldsKeys as $fieldKey) {
        $sentence .= " $fieldKey = :$fieldKey AND";
        $preparedValues[] = ":$fieldKey";
    }
    $sentence = substr($sentence, 0, strlen($sentence) - 4);
    $statement = $db -> prepare($sentence);
    $i = 0;
    foreach ($keys as $key) {
        $statement -> bindValue($preparedValues[$i++], $key);
        var_dump($key);
    }
    var_dump($preparedValues);
    var_dump($sentence);
    $statement -> execute();
    return http_response_code($statement -> rowCount() > 0 ? OK : NOT_FOUND);
}