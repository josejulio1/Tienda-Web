<?php
namespace Model;

use PDO;
use Exception;
use Database\Database;

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
        $this -> producto_id = $data['producto_id'] ?? 0;
        $this -> cliente_id = $data['cliente_id'] ?? 0;
        $this -> cantidad = $data['cantidad'] ?? 0;
    }

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

    public static function operationQuantity(int $productId, bool $increment): bool {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return false;
        }
        $cantidadProducto = CarritoItem::findOne($productId, [CarritoItem::CANTIDAD], CarritoItem::PRODUCTO_ID) -> cantidad;
        $statement = $db -> getPdo() -> prepare('UPDATE ' . self::$tableName . ' SET ' . self::CANTIDAD . ' = ? WHERE ' . self::PRODUCTO_ID . ' = ?');
        try {
            $statement -> execute([($increment ? $cantidadProducto + 1 : $cantidadProducto - 1), $productId]);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    public function deleteItem(): bool {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return false;
        }
        $statement = $db -> getPdo() -> prepare('DELETE FROM ' . self::$tableName . ' WHERE ' . self::PRODUCTO_ID . ' = ?');
        try {
            $statement -> execute([$this -> producto_id]);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

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

    public function getColumns(): array {
        return [
            self::PRODUCTO_ID => $this -> producto_id,
            self::CLIENTE_ID => $this -> cliente_id,
            self::CANTIDAD => $this -> cantidad
        ];
    }
}