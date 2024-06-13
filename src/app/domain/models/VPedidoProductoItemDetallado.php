<?php
namespace Model;

use Model\Base\AbstractActiveRecord;

/**
 * Clase modelo que controla la vista V_Pedido_Producto_Item_Detallado de la base de datos
 * @author josejulio1
 * @version 1.0
 */
class VPedidoProductoItemDetallado extends AbstractActiveRecord {
    protected static string $tableName = 'V_Pedido_Producto_Item_Detallado';
    protected static string $primaryKeyColumn = self::CLIENTE_ID;

    // Nombre de columnas
    public const PEDIDO_ID = 'pedido_id';
    public const CLIENTE_ID = 'cliente_id';
    public const PRODUCTO_ID = 'producto_id';
    public const NOMBRE_PRODUCTO = 'nombre_producto';
    public const CANTIDAD_PRODUCTO = 'cantidad_producto';
    public const PRECIO_PRODUCTO = 'precio_producto';
    public const RUTA_IMAGEN = 'ruta_imagen';

    public int $pedido_id;
    public int $cliente_id;
    public int $producto_id;
    public string $nombre_producto;
    public int $cantidad_producto;
    public float $precio_producto;
    public string $ruta_imagen;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> pedido_id = $data[self::PEDIDO_ID] ?? 0;
        $this -> cliente_id = $data[self::CLIENTE_ID] ?? 0;
        $this -> producto_id = $data[self::PRODUCTO_ID] ?? 0;
        $this -> nombre_producto = $data[self::NOMBRE_PRODUCTO] ?? '';
        $this -> cantidad_producto = $data[self::CANTIDAD_PRODUCTO] ?? 0;
        $this -> precio_producto = $data[self::PRECIO_PRODUCTO] ?? 0.0;
        $this -> ruta_imagen = $data[self::RUTA_IMAGEN] ?? '';
    }
}