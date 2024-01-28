<?php
require_once __DIR__ . '/config/config.php';

class Database {
    private static $instance = null;
    private $database;

    private function __construct($database) {
        $this -> database = $database;
    }

    public static function connect() {
        if (Database::$instance == null) {
            try {
                $database = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
                Database::$instance = new Database($database);
            } catch (PDOException $e) {
                return false;
            }
        }
        return Database::$instance;
    }

    public function close() {
        $this -> database = null;
        Database::$instance = null;
    }

    public function getDatabase() {
        return $this -> database;
    }
}
?>