<?php
namespace Database;

use PDO;
use Exception;

/**
 * Clase que gestiona la conexión de la base de datos de la aplicación.
 *
 * Utiliza un patrón Singleton para solo guardar siempre una sola instancia de la base de datos.
 * @author josejulio1
 * @version 1.0
 */
class Database {
    private static ?Database $instance = null;
    private ?PDO $pdo;
    private static bool $isConnected;

    /**
     * Construye una clase Database en caso de que no exista una base de datos creada previamente
     */
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

    /**
     * Crea una instancia de esta clase si la base de datos no se creó previamente o devuelve una instancia
     * creada previamente si ya existe la base de datos
     * @return Database Devuelve la instancia creada de esta clase
     */
    public static function connect(): Database {
        if (Database::$instance === null) {
            Database::$instance = new Database();
        }
        return Database::$instance;
    }

    /**
     * Obtiene la instancia de conexión la base de datos
     * @return PDO Devuelve la instancia de conexión de la base de datos
     */
    public function getPdo(): PDO {
        return $this -> pdo;
    }

    /**
     * Comprueba si está conectado correctamente a la base de datos. Para que este método funcione,
     * debe usarse al menos el método {@see Database::connect()} una vez para poder crear la instancia
     * de la base de datos.
     * @return bool Devuelve true si está conectado a la base de datos y false si no lo está
     */
    public static function isConnected(): bool {
        return self::$isConnected;
    }
}
