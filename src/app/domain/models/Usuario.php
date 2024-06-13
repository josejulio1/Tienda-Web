<?php
namespace Model;

use Model\Base\AbstractActiveRecordAuth;
use Model\Base\IContainsImage;

/**
 * Clase modelo que controla la tabla Usuario de la base de datos
 * @author josejulio1
 * @version 1.0
 */
class Usuario extends AbstractActiveRecordAuth implements IContainsImage {
    protected static string $tableName = 'Usuario';
    protected static string $primaryKeyColumn = self::ID;
    protected static string $emailColumn = self::CORREO;

    // Nombre de columnas
    public const ID = 'id';
    public const USUARIO = 'usuario';
    public const CORREO = 'correo';
    public const CONTRASENIA = 'contrasenia';
    public const ROL_ID = 'rol_id';
    public const RUTA_IMAGEN_PERFIL = 'ruta_imagen_perfil';

    public int $id;
    public string $usuario;
    public string $correo;
    public string $contrasenia;
    public int $rol_id;
    public string $ruta_imagen_perfil;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data[self::ID] ?? 0;
        $this -> usuario = $data[self::USUARIO] ?? '';
        $this -> correo = $data[self::CORREO] ?? '';
        $this -> contrasenia = $data[self::CONTRASENIA] ?? '';
        $this -> rol_id = $data[self::ROL_ID] ?? 0;
        $this -> ruta_imagen_perfil = $data[self::RUTA_IMAGEN_PERFIL] ?? '';
    }

    public function getColumns(): array {
        return [
            self::ID => $this -> id,
            self::USUARIO => $this -> usuario,
            self::CORREO => $this -> correo,
            self::CONTRASENIA => $this -> contrasenia,
            self::ROL_ID => $this -> rol_id,
            self::RUTA_IMAGEN_PERFIL => $this -> ruta_imagen_perfil
        ];
    }

    function getImagePath(): string {
        return $this -> ruta_imagen_perfil;
    }
}