<?php
namespace Database;

use PDO;
use Exception;

class Database {
    private static ?Database $instance = null;
    private ?PDO $pdo;
    private static bool $isConnected;

    private function __construct() {
        try {
            $this -> pdo = new PDO(
                'mysql:host=' . $_SERVER['DB_HOST'] . ';port=' . $_SERVER['DB_PORT'] . ';dbname=' . $_SERVER['DB_NAME'],
                $_SERVER['DB_USER'],
                $_SERVER['DB_PASSWORD']
            );
            self::$isConnected = true;
        } catch (Exception $e) {
            self::$isConnected = false;
        }
    }

    public static function connect(): Database {
        if (Database::$instance === null) {
            Database::$instance = new Database();
        }
        return Database::$instance;
    }

    public function close() {
        $this -> pdo = null;
        Database::$instance = null;
        self::$isConnected = false;
    }

    public function getPdo(): PDO {
        return $this -> pdo;
    }

    public static function isConnected(): bool {
        return self::$isConnected;
    }
}