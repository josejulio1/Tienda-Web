<?php
namespace Model;

use PDO;
use Exception;
use Database\Database;

class VProductoValoracionPromedio extends AbstractActiveRecord {
    protected static string $tableName = 'V_Producto_Valoracion_Promedio';
    protected static string $primaryKeyColumn = self::ID;

    public const ID = 'id';
    public const NOMBRE = 'nombre';
    public const DESCRIPCION = 'descripcion';
    public const RUTA_IMAGEN = 'ruta_imagen';
    public const PRECIO = 'precio';
    public const MARCA = 'marca';
    public const VALORACION_PROMEDIO = 'valoracion_promedio';

    public int $id;
    public string $nombre;
    public string $descripcion;
    public string $ruta_imagen;
    public float $precio;
    public string $marca;
    public int $valoracion_promedio;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data['id'] ?? 0;
        $this -> nombre = $data['nombre'] ?? '';
        $this -> descripcion = $data['descripcion'] ?? '';
        $this -> ruta_imagen = $data['ruta_imagen'] ?? '';
        $this -> precio = $data['precio'] ?? 0.0;
        $this -> marca = $data['marca'] ?? '';
        $this -> valoracion_promedio = $data['valoracion_promedio'] ?? 0;
    }

    public static function findBeginWithName(string $productName, array $columns = []): ?array {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return null;
        }
        $statement = $db -> getPdo() -> prepare(
            'SELECT ' . ($columns ? join(',', $columns) : '*')
            . ' FROM ' . self::$tableName . ' WHERE ' . self::NOMBRE . ' LIKE ?');
        try {
            $statement -> execute([$productName . '%']);
        } catch (Exception $e) {
            return null;
        }
        return self::mapResultToObject($statement -> fetchAll(PDO::FETCH_ASSOC));
    }
}