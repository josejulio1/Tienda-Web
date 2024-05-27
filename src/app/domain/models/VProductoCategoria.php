<?php
namespace Model;

class VProductoCategoria extends AbstractActiveRecord {
    protected static string $tableName = 'V_Producto_Categoria';
    protected static string $primaryKeyColumn = self::PRODUCTO_ID;

    // Nombre de columnas
    public const PRODUCTO_ID = 'producto_id';
    public const NOMBRE = 'nombre';
    public const DESCRIPCION = 'descripcion';
    public const PRECIO = 'precio';
    public const MARCA = 'marca';
    public const STOCK = 'stock';
    public const RUTA_IMAGEN = 'ruta_imagen';
    public const NOMBRE_CATEGORIA = 'nombre_categoria';

    public int $producto_id;
    public string $nombre;
    public string $descripcion;
    public float $precio;
    public string $marca;
    public int $stock;
    public string $ruta_imagen;
    public string $nombre_categoria;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> producto_id = $data[VProductoCategoria::PRODUCTO_ID] ?? 0;
        $this -> nombre = $data[VProductoCategoria::NOMBRE] ?? '';
        $this -> descripcion = $data[VProductoCategoria::DESCRIPCION] ?? '';
        $this -> precio = $data[VProductoCategoria::PRECIO] ?? 0.0;
        $this -> marca = $data[VProductoCategoria::MARCA] ?? '';
        $this -> stock = $data[VProductoCategoria::STOCK] ?? 0;
        $this -> ruta_imagen = $data[VProductoCategoria::RUTA_IMAGEN] ?? '';
        $this -> nombre_categoria = $data[VProductoCategoria::NOMBRE_CATEGORIA] ?? '';
    }

    public function getColumns(): array {
        return [];
    }
}