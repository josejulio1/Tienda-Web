<?php
namespace Model;

use Model\Base\AbstractActiveRecordCrud;
use Database\Database;
use Exception;
use PDO;

/**
 * Clase modelo que controla la tabla Carrito_Item de la base de datos
 * @author josejulio1
 * @version 1.0
 */
class CarritoItem extends AbstractActiveRecordCrud {
    protected static string $tableName = 'Carrito_Item';
    protected static string $primaryKeyColumn = self::CLIENTE_ID;

    // Nombre de columnas
    public const PRODUCTO_ID = 'producto_id';
    public const CLIENTE_ID = 'cliente_id';
    public const CANTIDAD = 'cantidad';

    public int $producto_id;
    public int $cliente_id;
    public int $cantidad;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> producto_id = $data[self::PRODUCTO_ID] ?? 0;
        $this -> cliente_id = $data[self::CLIENTE_ID] ?? 0;
        $this -> cantidad = $data[self::CANTIDAD] ?? 0;
    }

    /**
     * Comprueba si el carrito de un {@see Cliente} está vacío
     * @param int $customerId ID del cliente
     * @return bool True si está vacío y false si no lo está
     */
    public static function emptyCart(int $customerId): bool {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return false;
        }
        $statement = $db -> getPdo() -> prepare('DELETE FROM ' . self::$tableName . ' WHERE ' . self::CLIENTE_ID . ' = ?');
        try {
            $statement -> execute([$customerId]);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * Establece la cantidad de un {@see Producto} en el carrito de un {@see Cliente}
     * @param int $productId ID del producto a cambiar la cantidad
     * @param int $quantity Cantidad a establecer
     * @return bool True si se cambió la cantidad correctamente y false si no
     */
    public static function setQuantity(int $productId, int $quantity): bool {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return false;
        }
        $statement = $db -> getPdo() -> prepare('UPDATE ' . self::$tableName . ' SET ' . self::CANTIDAD . ' = ? WHERE ' . self::PRODUCTO_ID . ' = ?');
        try {
            $statement -> execute([$quantity, $productId]);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * Incrementa o decrementa la cantidad de un {@see Producto} en 1 en el carrito del {@see Cliente} con el que tiene iniciado sesión
     * @param int $productId ID del producto a cambiar la cantidad
     * @param bool $increment True si se quiere aumentar la cantidad y false si se quiere decrementar
     * @return bool True si se realizó correctamente la operación o false si no
     */
    public static function operationQuantity(int $productId, bool $increment): bool {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return false;
        }
        $cantidadProducto = CarritoItem::findQuantityByProductIdAndCustomer($productId, $_SESSION['id'], [CarritoItem::CANTIDAD]) -> cantidad;
        $statement = $db -> getPdo() -> prepare('UPDATE ' . self::$tableName . ' SET ' . self::CANTIDAD . ' = ? WHERE ' . self::PRODUCTO_ID . ' = ? AND ' . self::CLIENTE_ID . ' = ?');
        try {
            $statement -> execute([($increment ? $cantidadProducto + 1 : $cantidadProducto - 1), $productId, $_SESSION['id']]);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * Busca la cantidad de un {@see Producto} que tiene un {@see Cliente} en su carrito
     * @param int $productId ID del producto a buscar su cantidad
     * @param int $customerId ID del cliente a buscar
     * @param array $columns Columnas que se desean obtener
     * @return CarritoItem|null Devuelve un objeto CarritoItem si se encontró correctamente y null si la base de datos no funciona
     * o si no se encontró
     */
    public static function findQuantityByProductIdAndCustomer(int $productId, int $customerId, array $columns = []): ?CarritoItem {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return null;
        }
        $statement = $db -> getPdo() -> prepare(
            'SELECT ' . ($columns ? join(',', $columns) : '*')
            . ' FROM ' . self::$tableName . ' WHERE ' . self::PRODUCTO_ID . ' = ? AND ' . self::CLIENTE_ID . ' = ?');
        try {
            $statement -> execute([$productId, $customerId]);
        } catch (Exception $e) {
            return null;
        }
        $objects = self::mapResultToObject($statement -> fetchAll(PDO::FETCH_ASSOC));
        return $objects ? $objects[0] : null;
    }

    /**
     * Elimina un {@see Producto} del carrito del {@see Cliente} que tiene actualmente iniciado sesión
     * @return bool True si se eliminó correctamente y false si no
     */
    public function deleteItem(): bool {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return false;
        }
        $statement = $db -> getPdo() -> prepare(
            'DELETE FROM ' . self::$tableName . ' WHERE ' . self::PRODUCTO_ID . ' = ? AND ' . self::CLIENTE_ID . ' = ?'
        );
        try {
            $statement -> execute([$this -> producto_id, $this -> cliente_id]);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    public function getColumns(): array {
        return [
            self::PRODUCTO_ID => $this -> producto_id,
            self::CLIENTE_ID => $this -> cliente_id,
            self::CANTIDAD => $this -> cantidad
        ];
    }
}