<?php
namespace Model;

use PDO;
use Database\Database;

abstract class AbstractActiveRecordAuth extends AbstractActiveRecordCrud {
    protected static string $emailColumn = '';

    public static function findByEmail(string $email, array $columns = []): ?static {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return null;
        }

        $db = Database::connect();
        if (!Database::isConnected()) {
            return null;
        }
        $statement = $db -> getPdo() -> prepare(
            'SELECT ' . ($columns ? join(',', $columns) : '*') . ' FROM ' . static::$tableName . ' WHERE ' . static::$emailColumn . ' = ?'
        );
        $statement -> execute([$email]);
        $clientes = self::mapResultToObject($statement -> fetchAll(PDO::FETCH_ASSOC));
        $db -> close();
        return $clientes ? $clientes[0] : null;
    }
}