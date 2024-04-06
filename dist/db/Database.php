<?php
require_once __DIR__ . '/config/config.php';

/**
 * Clase para instanciar una única conexión a la base de datos, a través de un patrón Singleton.
 */
class Database {
    private static $instance = null;
    private PDO $database;

    /**
     * Construye una instancia PDO
     * @param PDO $database Conexión PDO de la base de datos
     */
    private function __construct(PDO $database) {
        $this -> database = $database;
    }

    /**
     * Crear una instancia de conexión a la base de datos o devuelve la conexión ya existente
     * @return false|Database|null Devuelve null o false si la instancia no se pudo crear correctamente,
     * y una instancia de Database en caso de que se cree correctamente o que ya exista
     */
    public static function connect(): false|Database|null {
        if (Database::$instance == null) {
            try {
                $database = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
                Database::$instance = new Database($database);
            } catch (Exception $e) {
                return false;
            }
        }
        return Database::$instance;
    }

    public function getDatabase(): PDO {
        return $this -> database;
    }
}