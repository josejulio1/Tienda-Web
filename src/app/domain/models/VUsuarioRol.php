<?php
namespace Model;

use Model\Base\AbstractActiveRecordAuth;

/**
 * Clase modelo que controla la vista V_Usuario_Rol de la base de datos
 * @author josejulio1
 * @version 1.0
 */
class VUsuarioRol extends AbstractActiveRecordAuth {
    protected static string $tableName = 'V_Usuario_Rol';
    protected static string $primaryKeyColumn = self::USUARIO_ID;
    protected static string $emailColumn = self::CORREO;

    // Nombre de columnas
    public const USUARIO_ID = 'usuario_id';
    public const USUARIO = 'usuario';
    public const CORREO = 'correo';
    public const CONTRASENIA = 'contrasenia';
    public const ROL_ID = 'rol_id';
    public const NOMBRE_ROL = 'nombre_rol';
    public const COLOR_ROL = 'color_rol';
    public const RUTA_IMAGEN_PERFIL = 'ruta_imagen_perfil';
    public const PERMISO_CATEGORIA = 'permiso_categoria';
    public const PERMISO_PRODUCTO = 'permiso_producto';
    public const PERMISO_MARCA = 'permiso_marca';
    public const PERMISO_CLIENTE = 'permiso_cliente';
    public const PERMISO_USUARIO = 'permiso_usuario';
    public const PERMISO_ROL = 'permiso_rol';

    public int $usuario_id;
    public string $usuario;
    public string $correo;
    public string $contrasenia;
    public int $rol_id;
    public string $nombre_rol;
    public string $color_rol;
    public string $ruta_imagen_perfil;
    public int $permiso_categoria;
    public int $permiso_producto;
    public int $permiso_marca;
    public int $permiso_cliente;
    public int $permiso_usuario;
    public int $permiso_rol;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> usuario_id = $data[VUsuarioRol::USUARIO_ID] ?? 0;
        $this -> usuario = $data[VUsuarioRol::USUARIO] ?? '';
        $this -> correo = $data[VUsuarioRol::CORREO] ?? '';
        $this -> contrasenia = $data[VUsuarioRol::CONTRASENIA] ?? '';
        $this -> rol_id = $data[VUsuarioRol::ROL_ID] ?? 0;
        $this -> nombre_rol = $data[VUsuarioRol::NOMBRE_ROL] ?? '';
        $this -> color_rol = $data[VUsuarioRol::COLOR_ROL] ?? '';
        $this -> ruta_imagen_perfil = $data[VUsuarioRol::RUTA_IMAGEN_PERFIL] ?? '';
        $this -> permiso_categoria = $data[VUsuarioRol::PERMISO_CATEGORIA] ?? 0;
        $this -> permiso_producto = $data[VUsuarioRol::PERMISO_PRODUCTO] ?? 0;
        $this -> permiso_marca = $data[VUsuarioRol::PERMISO_MARCA] ?? 0;
        $this -> permiso_cliente = $data[VUsuarioRol::PERMISO_CLIENTE] ?? 0;
        $this -> permiso_usuario = $data[VUsuarioRol::PERMISO_USUARIO] ?? 0;
        $this -> permiso_rol = $data[VUsuarioRol::PERMISO_ROL] ?? 0;
    }

    function getColumns(): array {
        return [];
    }
}