<?php
namespace Model;

use Model\Base\AbstractActiveRecord;

/**
 * Clase modelo que controla la vista V_Chat_Cliente_Info de la base de datos
 * @author josejulio1
 * @version 1.0
 */
class VChatClienteInfo extends AbstractActiveRecord {
    protected static string $tableName = 'V_Chat_Cliente_Info';
    protected static string $primaryKeyColumn = self::CLIENTE_ID;

    // Nombre de columnas
    public const ID = 'id';
    public const CLIENTE_ID = 'cliente_id';
    public const CORREO = 'correo';
    public const RUTA_IMAGEN_PERFIL = 'ruta_imagen_perfil';
    public const MENSAJE = 'mensaje';
    public const FECHA = 'fecha';
    public const ES_CLIENTE = 'es_cliente';

    public int $id;
    public int $cliente_id;
    public string $correo;
    public string $ruta_imagen_perfil;
    public string $mensaje;
    public string $fecha;
    public bool $es_cliente;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data[self::ID] ?? 0;
        $this -> cliente_id = $data[self::CLIENTE_ID] ?? 0;
        $this -> correo = $data[self::CORREO] ?? '';
        $this -> ruta_imagen_perfil = $data[self::RUTA_IMAGEN_PERFIL] ?? '';
        $this -> mensaje = $data[self::MENSAJE] ?? '';
        $this -> fecha = $data[self::FECHA] ?? '';
        $this -> es_cliente = $data[self::ES_CLIENTE] ?? false;
    }
}