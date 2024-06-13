<?php
namespace Model;

use Model\Base\AbstractActiveRecordCrud;

/**
 * Clase modelo que controla la tabla Rol de la base de datos
 * @author josejulio1
 * @version 1.0
 */
class Rol extends AbstractActiveRecordCrud {
    protected static string $tableName = 'Rol';
    protected static string $primaryKeyColumn = self::ID;

    // Nombre de columnas
    public const ID = 'id';
    public const NOMBRE = 'nombre';
    public const COLOR = 'color';
    public const PERMISO_CATEGORIA = 'permiso_categoria';
    public const PERMISO_PRODUCTO = 'permiso_producto';
    public const PERMISO_MARCA = 'permiso_marca';
    public const PERMISO_CLIENTE = 'permiso_cliente';
    public const PERMISO_USUARIO = 'permiso_usuario';
    public const PERMISO_ROL = 'permiso_rol';

    public int $id;
    public string $nombre;
    public string $color;
    public int $permiso_categoria;
    public int $permiso_producto;
    public int $permiso_marca;
    public int $permiso_cliente;
    public int $permiso_usuario;
    public int $permiso_rol;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data[Rol::ID] ?? 0;
        $this -> nombre = $data[Rol::NOMBRE] ?? '';
        $this -> color = $data[Rol::COLOR] ?? '';
        $this -> permiso_categoria = $data[Rol::PERMISO_CATEGORIA] ?? 0;
        $this -> permiso_producto = $data[Rol::PERMISO_PRODUCTO] ?? 0;
        $this -> permiso_marca = $data[Rol::PERMISO_MARCA] ?? 0;
        $this -> permiso_cliente = $data[Rol::PERMISO_CLIENTE] ?? 0;
        $this -> permiso_usuario = $data[Rol::PERMISO_USUARIO] ?? 0;
        $this -> permiso_rol = $data[Rol::PERMISO_ROL] ?? 0;
    }

    public function getColumns(): array {
        return [
            self::ID => $this -> id,
            self::NOMBRE => $this -> nombre,
            self::COLOR => $this -> color,
            self::PERMISO_CATEGORIA => $this -> permiso_categoria,
            self::PERMISO_PRODUCTO => $this -> permiso_producto,
            self::PERMISO_MARCA => $this -> permiso_marca,
            self::PERMISO_CLIENTE => $this -> permiso_cliente,
            self::PERMISO_USUARIO => $this -> permiso_usuario,
            self::PERMISO_ROL => $this -> permiso_rol
        ];
    }
}