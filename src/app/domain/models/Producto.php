<?php
namespace Model;

class Producto extends AbstractActiveRecordCrud {
    protected static string $tableName = 'Producto';
    protected static string $primaryKeyColumn = self::ID;

    public const ID = 'id';
    public const NOMBRE = 'nombre';
    public const DESCRIPCION = 'descripcion';
    public const PRECIO = 'precio';
    public const STOCK = 'stock';
    public const RUTA_IMAGEN = 'ruta_imagen';
    public const MARCA_ID = 'marca_id';
    public const CATEGORIA_ID = 'categoria_id';

    public int $id;
    public string $nombre;
    public string $descripcion;
    public float $precio;
    public int $stock;
    public string $rutaImagen;
    public int $marcaId;
    public int $categoriaId;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data['id'] ?? 0;
        $this -> nombre = $data['nombre'] ?? '';
        $this -> descripcion = $data['descripcion'] ?? '';
        $this -> precio = $data['precio'] ?? 0.0;
        $this -> stock = $data['stock'] ?? 0;
        $this -> rutaImagen = $data['ruta_imagen'] ?? '';
        $this -> marcaId = $data['marca_id'] ?? 0;
        $this -> categoriaId = $data['categoria_id'] ?? 0;
    }

    public function getColumns(): array {
        return [
            self::ID => $this -> id,
            self::NOMBRE => $this -> nombre,
            self::DESCRIPCION => $this -> descripcion,
            self::PRECIO => $this -> precio,
            self::STOCK => $this -> stock,
            self::RUTA_IMAGEN => $this -> rutaImagen,
            self::MARCA_ID => $this -> marcaId,
            self::CATEGORIA_ID => $this -> categoriaId
        ];
    }
}