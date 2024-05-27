<?php
namespace Model;

use Exception;
use Database\Database;

abstract class AbstractActiveRecordCrud extends AbstractActiveRecord {
    /**
     * @param array $data Datos para mapear las columnas de una base de datos o de un formulario con las propiedades de las clases hijas
     */
    public function __construct(array $data = []) {
        parent::__construct($data);
    }

    public function create(bool $removePrimaryKeyColumn = false): bool {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return false;
        }
        // Eliminar campos vacíos
        $columns = array_filter($this -> getColumns());
        if ($removePrimaryKeyColumn) {
            unset($columns[static::$primaryKeyColumn]);
        }
        $numColumns = count($columns);
        $statement = $db -> getPdo() -> prepare('INSERT INTO ' . static::$tableName
            . ' (' . join(',', array_keys($columns))
            . ') VALUES (' . substr(str_repeat('?,', $numColumns), 0, $numColumns * 2 - 1) . ')');
        $ok = true;
        try {
            $statement -> execute(array_values($columns));
        } catch (Exception $e) {
            $ok = false;
        }
        return $ok;
    }

    public function save(): bool {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return false;
        }
        // Eliminar campos vacíos
        $columns = array_filter($this -> getColumns());
        // Mover el ID al final para coincidirlo con el UPDATE (los ID están siempre al principio)
        $id = array_shift($columns);
        $reservedFields = '';
        foreach ($columns as $key => $value) {
            $reservedFields .= "$key = ?,";
        }
        $columns[static::$primaryKeyColumn] = $id;
        $reservedFields = substr($reservedFields, 0, strlen($reservedFields) - 1);
        $statement = $db -> getPdo() -> prepare('UPDATE ' . static::$tableName . " SET $reservedFields WHERE " . static::$primaryKeyColumn . ' = ?');
        $ok = true;
        try {
            $statement -> execute(array_values($columns));
        } catch (Exception $e) {
            $ok = false;
        }
        return $ok;
    }

    public function delete(): bool {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return false;
        }
        $statement = $db -> getPdo() -> prepare('DELETE FROM ' . static::$tableName . ' WHERE ' . static::$primaryKeyColumn . ' = ?');
        $ok = true;
        try {
            $statement -> execute([static::getColumns()[static::$primaryKeyColumn]]);
        } catch (Exception $e) {
            $ok = false;
        }
        return $ok;
    }

    protected static function mapResultToObject(array $result): array {
        $objects = [];
        foreach ($result as $row) {
            $objects[] = new static($row); // Crear una instancia de la clase donde se ejecuta este método
        }
        return $objects;
    }

    abstract function getColumns(): array;
}