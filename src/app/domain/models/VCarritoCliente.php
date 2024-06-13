<?php
namespace Model;

use Model\Base\AbstractActiveRecord;
use Database\Database;
use PDO;
use Exception;

/**
 * Clase modelo que controla la vista V_Carrito_Cliente de la base de datos
 * @author josejulio1
 * @version 1.0
 */
class VCarritoCliente extends AbstractActiveRecord {
    protected static string $tableName = 'V_Carrito_Cliente';
    protected static string $primaryKeyColumn = self::CLIENTE_ID;

    // Nombre de columnas
    public const CLIENTE_ID = 'cliente_id';
    public const PRODUCTO_ID = 'producto_id';
    public const NOMBRE_PRODUCTO = 'nombre_producto';
    public const PRECIO_PRODUCTO = 'precio_producto';
    public const STOCK_PRODUCTO = 'stock_producto';
    public const CANTIDAD = 'cantidad';
    public const RUTA_IMAGEN_PRODUCTO = 'ruta_imagen_producto';

    public int $cliente_id;
    public int $producto_id;
    public string $nombre_producto;
    public float $precio_producto;
    public int $stock_producto;
    public int $cantidad;
    public string $ruta_imagen_producto;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> cliente_id = $data[self::CLIENTE_ID] ?? 0;
        $this -> producto_id = $data[self::PRODUCTO_ID] ?? 0;
        $this -> nombre_producto = $data[self::NOMBRE_PRODUCTO] ?? '';
        $this -> precio_producto = $data[self::PRECIO_PRODUCTO] ?? 0.0;
        $this -> stock_producto = $data[self::STOCK_PRODUCTO] ?? 0;
        $this -> cantidad = $data[self::CANTIDAD] ?? 0;
        $this -> ruta_imagen_producto = $data[self::RUTA_IMAGEN_PRODUCTO] ?? '';
    }

    /**
     * Busca un {@see Producto} del {@see CarritoItem carrito} de un {@see Cliente}
     * @param int $productId ID del producto a buscar
     * @param array $columns Columnas que se desean obtener
     * @return VCarritoCliente|null Devolverá una instancia del objeto si encontró el producto y null en caso de que la
     * base de datos no funcione o no haya encontrado ningún resultado
     */
    public static function findByProductId(int $productId, array $columns = []): ?VCarritoCliente {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return null;
        }
        $statement = $db -> getPdo() -> prepare(
            'SELECT ' . ($columns ? join(',', $columns) : '*')
            . ' FROM ' . self::$tableName . ' WHERE ' . self::PRODUCTO_ID . ' = ? AND ' . self::CLIENTE_ID . ' = ?');
        try {
            $statement -> execute([$productId, $_SESSION['id']]);
        } catch (Exception $e) {
            return null;
        }
        $objects = self::mapResultToObject($statement -> fetchAll(PDO::FETCH_ASSOC));
        return $objects ? $objects[0] : null;
    }
}