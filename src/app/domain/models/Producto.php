<?php
namespace Model;

use Model\Base\AbstractActiveRecordCrud;
use Model\Base\IContainsImage;

/**
 * Clase modelo que controla la tabla Producto de la base de datos
 * @author josejulio1
 * @version 1.0
 */
class Producto extends AbstractActiveRecordCrud implements IContainsImage {
    protected static string $tableName = 'Producto';
    protected static string $primaryKeyColumn = self::ID;

    // Nombre de columnas
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
    public string $ruta_imagen;
    public int $marca_id;
    public int $categoria_id;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data[self::ID] ?? 0;
        $this -> nombre = $data[self::NOMBRE] ?? '';
        $this -> descripcion = $data[self::DESCRIPCION] ?? '';
        $this -> precio = $data[self::PRECIO] ?? 0.0;
        $this -> stock = $data[self::STOCK] ?? 0;
        $this -> ruta_imagen = $data[self::RUTA_IMAGEN] ?? '';
        $this -> marca_id = $data[self::MARCA_ID] ?? 0;
        $this -> categoria_id = $data[self::CATEGORIA_ID] ?? 0;
    }

    public function getColumns(): array {
        return [
            self::ID => $this -> id,
            self::NOMBRE => $this -> nombre,
            self::DESCRIPCION => $this -> descripcion,
            self::PRECIO => $this -> precio,
            self::STOCK => $this -> stock,
            self::RUTA_IMAGEN => $this -> ruta_imagen,
            self::MARCA_ID => $this -> marca_id,
            self::CATEGORIA_ID => $this -> categoria_id
        ];
    }

    function getImagePath(): string {
        return $this -> ruta_imagen;
    }
}