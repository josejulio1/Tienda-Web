<?php
namespace Model;

class Cliente extends AbstractActiveRecordAuth {
    protected static string $tableName = 'Cliente';
    protected static string $primaryKeyColumn = self::ID;
    protected static string $emailColumn = self::CORREO;

    // Nombre de columnas
    public const ID = 'id';
    public const NOMBRE = 'nombre';
    public const APELLIDOS = 'apellidos';
    public const TELEFONO = 'telefono';
    public const DIRECCION = 'direccion';
    public const CORREO = 'correo';
    public const CONTRASENIA = 'contrasenia';
    public const RUTA_IMAGEN_PERFIL = 'ruta_imagen_perfil';

    public int $id;
    public string $nombre;
    public string $apellidos;
    public string $telefono;
    public string $direccion;
    public string $correo;
    public string $contrasenia;
    public string $ruta_imagen_perfil;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data['id'] ?? 0;
        $this -> nombre = $data['nombre'] ?? '';
        $this -> apellidos = $data['apellidos'] ?? '';
        $this -> telefono = $data['telefono'] ?? '';
        $this -> direccion = $data['direccion'] ?? '';
        $this -> correo = $data['correo'] ?? '';
        $this -> contrasenia = $data['contrasenia'] ?? '';
        $this -> ruta_imagen_perfil = $data['ruta_imagen_perfil'] ?? '';
    }

    public function getColumns(): array {
        return [
            self::ID => $this -> id,
            self::NOMBRE => $this -> nombre,
            self::APELLIDOS => $this -> apellidos,
            self::TELEFONO => $this -> telefono,
            self::DIRECCION => $this -> direccion,
            self::CORREO => $this -> correo,
            self::CONTRASENIA => $this -> contrasenia,
            self::RUTA_IMAGEN_PERFIL => $this -> ruta_imagen_perfil
        ];
    }
}