<?php
namespace Model;

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

    public int $pedidoId;
    public int $clienteId;
    public int $productoId;
    public string $nombreProducto;
    public int $cantidadProducto;
    public float $precioProducto;
    public string $rutaImagen;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> pedidoId = $data['pedido_id'] ?? 0;
        $this -> clienteId = $data['cliente_id'] ?? 0;
        $this -> productoId = $data['producto_id'] ?? 0;
        $this -> nombreProducto = $data['nombre_producto'] ?? '';
        $this -> cantidadProducto = $data['cantidad_producto'] ?? 0;
        $this -> precioProducto = $data['precio_producto'] ?? 0.0;
        $this -> rutaImagen = $data['ruta_imagen'] ?? '';
    }

    public function getColumns(): array {
        return [];
    }
}