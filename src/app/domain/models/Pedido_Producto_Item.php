<?php
namespace Model;

use Model\Base\AbstractActiveRecordCrud;

/**
 * Clase modelo que controla la tabla Pedido_Producto_Item de la base de datos
 * @author josejulio1
 * @version 1.0
 */
class Pedido_Producto_Item extends AbstractActiveRecordCrud {
    protected static string $tableName = 'Pedido_Producto_Item';
    protected static string $primaryKeyColumn = self::PEDIDO_ID;

    // Nombre de columnas
    public const ID = 'id';
    public const PEDIDO_ID = 'pedido_id';
    public const PRODUCTO_ID = 'producto_id';
    public const CANTIDAD_PRODUCTO = 'cantidad_producto';
    public const PRECIO_PRODUCTO = 'precio_producto';

    public int $id;
    public int $pedido_id;
    public int $producto_id;
    public int $cantidad_producto;
    public float $precio_producto;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data[self::ID] ?? 0;
        $this -> pedido_id = $data[self::PEDIDO_ID] ?? 0;
        $this -> producto_id = $data[self::PRODUCTO_ID] ?? 0;
        $this -> cantidad_producto = $data[self::CANTIDAD_PRODUCTO] ?? 0;
        $this -> precio_producto = $data[self::PRECIO_PRODUCTO] ?? 0.0;
    }

    function getColumns(): array {
        return [
            self::ID => $this -> id,
            self::PEDIDO_ID => $this -> pedido_id,
            self::PRODUCTO_ID => $this -> producto_id,
            self::CANTIDAD_PRODUCTO => $this -> cantidad_producto,
            self::PRECIO_PRODUCTO => $this -> precio_producto
        ];
    }
}