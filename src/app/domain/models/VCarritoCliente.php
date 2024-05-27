<?php
namespace Model;

use PDO;
use Exception;
use Database\Database;

class VCarritoCliente extends AbstractActiveRecord {
    protected static string $tableName = 'V_Carrito_Cliente';
    protected static string $primaryKeyColumn = self::CLIENTE_ID;

    public const CLIENTE_ID = 'cliente_id';
    public const PRODUCTO_ID = 'producto_id';
    public const NOMBRE_PRODUCTO = 'nombre_producto';
    public const PRECIO_PRODUCTO = 'precio_producto';
    public const CANTIDAD = 'cantidad';
    public const RUTA_IMAGEN_PRODUCTO = 'ruta_imagen_producto';

    public int $cliente_id;
    public int $producto_id;
    public string $nombre_producto;
    public float $precio_producto;
    public int $cantidad;
    public string $ruta_imagen_producto;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> cliente_id = $data['cliente_id'] ?? 0;
        $this -> producto_id = $data['producto_id'] ?? 0;
        $this -> nombre_producto = $data['nombre_producto'] ?? '';
        $this -> precio_producto = $data['precio_producto'] ?? 0.0;
        $this -> cantidad = $data['cantidad'] ?? 0;
        $this -> ruta_imagen_producto = $data['ruta_imagen_producto'] ?? '';
    }

    public static function findByProductId(int $productId, array $columns = []): ?VCarritoCliente {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return null;
        }
        $statement = $db -> getPdo() -> prepare(
            'SELECT ' . ($columns ? join(',', $columns) : '*')
            . ' FROM ' . self::$tableName . ' WHERE ' . self::PRODUCTO_ID . ' = ?');
        try {
            $statement -> execute([$productId]);
        } catch (\Exception $e) {
            return null;
        }
        $objects = self::mapResultToObject($statement -> fetchAll(PDO::FETCH_ASSOC));
        return $objects ? $objects[0] : null;
    }
}