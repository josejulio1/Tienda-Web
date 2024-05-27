<?php
namespace Model;

use Database\Database;
use PDO;

abstract class AbstractActiveRecord {
    protected static string $tableName = '';
    protected static string $primaryKeyColumn = '';

    /**
     * @param array $data Datos para mapear las columnas de una base de datos o de un formulario con las propiedades de las clases hijas
     */
    public function __construct(array $data = []) {}

    public static function all(?array $columns = null, ?int $limit = null, ?array $order = null): ?array {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return null;
        }
        $objects = self::mapResultToObject(
            $db -> getPdo() -> query(
                'SELECT ' . ($columns ? join(',', $columns) : '*')
                    . ' FROM ' . static::$tableName . ($order ? ' ORDER BY ' . array_values($order)[0] . ' ' . array_keys($order)[0] : '')
                    . ($limit ? " LIMIT $limit" : '')) -> fetchAll(PDO::FETCH_ASSOC)
        );
        return $objects;
    }

    public static function find(int $id, array $columns = [], ?string $otherPrimaryKey = null): ?array {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return null;
        }
        $statement = $db -> getPdo() -> prepare(
            'SELECT ' . ($columns ? join(',', $columns) : '*')
                . ' FROM '. static::$tableName . ' WHERE ' . ($otherPrimaryKey ?: static::$primaryKeyColumn) . ' = ?'
        );
        $statement -> execute([$id]);
        return self::mapResultToObject($statement -> fetchAll(PDO::FETCH_ASSOC));
    }

    public static function findOne(int $id, array $columns = [], ?string $otherPrimaryKey = null): ?static {
        $objects = self::find($id, $columns, $otherPrimaryKey);
        return $objects ? $objects[0] : null;
    }

    public static function last(array $columns = []): ?static {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return null;
        }
        $objects = self::mapResultToObject($db -> getPdo() -> query(
            'SELECT ' . ($columns ? join(',', $columns) : '*')
                . ' FROM ' . static::$tableName . ' ORDER BY ' . static::$primaryKeyColumn . ' DESC') -> fetchAll(PDO::FETCH_ASSOC)
        );
        return $objects ? $objects[0] : null;
    }

    protected static function mapResultToObject(array $result): array {
        $objects = [];
        foreach ($result as $row) {
            $objects[] = new static($row); // Crear una instancia de la clase donde se ejecuta este método
        }
        return $objects;
    }
}