<?php
namespace Model;

use PDO;
use Exception;
use Database\Database;

abstract class AbstractActiveRecordAuth extends AbstractActiveRecordCrud {
    protected static string $emailColumn = '';

    public static function findByEmail(string $email, array $columns = []): ?static {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return null;
        }
        $statement = $db -> getPdo() -> prepare(
            'SELECT ' . ($columns ? join(',', $columns) : '*') . ' FROM ' . static::$tableName . ' WHERE ' . static::$emailColumn . ' = ?'
        );
        try {
            $statement -> execute([$email]);
        } catch (Exception $e) {
            return null;
        }
        $clientes = self::mapResultToObject($statement -> fetchAll(PDO::FETCH_ASSOC));
        return $clientes ? $clientes[0] : null;
    }
}