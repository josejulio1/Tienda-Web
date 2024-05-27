<?php
namespace Model;

class Rol extends AbstractActiveRecordAuth {
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
    public int $permisoCategoria;
    public int $permisoProducto;
    public int $permisoMarca;
    public int $permisoCliente;
    public int $permisoUsuario;
    public int $permisoRol;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data[Rol::ID] ?? 0;
        $this -> nombre = $data[Rol::NOMBRE] ?? '';
        $this -> color = $data[Rol::COLOR] ?? '';
        $this -> permisoCategoria = $data[Rol::PERMISO_CATEGORIA] ?? 0;
        $this -> permisoProducto = $data[Rol::PERMISO_PRODUCTO] ?? 0;
        $this -> permisoMarca = $data[Rol::PERMISO_MARCA] ?? 0;
        $this -> permisoCliente = $data[Rol::PERMISO_CLIENTE] ?? 0;
        $this -> permisoUsuario = $data[Rol::PERMISO_USUARIO] ?? 0;
        $this -> permisoRol = $data[Rol::PERMISO_ROL] ?? 0;
    }

    public function getColumns(): array {
        return [];
    }
}