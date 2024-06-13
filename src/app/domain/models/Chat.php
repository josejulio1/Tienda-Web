<?php
namespace Model;

use Model\Base\AbstractActiveRecordCrud;

/**
 * Clase modelo que controla la tabla Chat de la base de datos
 * @author josejulio1
 * @version 1.0
 */
class Chat extends AbstractActiveRecordCrud {
    protected static string $tableName = 'Chat';
    protected static string $primaryKeyColumn = self::CLIENTE_ID;

    // Nombre de columnas
    public const ID = 'id';
    public const CLIENTE_ID = 'cliente_id';
    public const MENSAJE = 'mensaje';
    public const FECHA = 'fecha';
    public const ES_CLIENTE = 'es_cliente';

    public int $id;
    public int $cliente_id;
    public string $mensaje;
    public string $fecha;
    public bool $es_cliente;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data[self::ID] ?? 0;
        $this -> cliente_id = $data[self::CLIENTE_ID] ?? 0;
        $this -> mensaje = $data[self::MENSAJE] ?? '';
        $this -> fecha = $data[self::FECHA] ?? '';
        $this -> es_cliente = $data[self::ES_CLIENTE] ?? false;
    }

    function getColumns(): array {
        return [
            self::ID => $this -> id,
            self::CLIENTE_ID => $this -> cliente_id,
            self::MENSAJE => $this -> mensaje,
            self::FECHA => $this -> fecha,
            self::ES_CLIENTE => $this -> es_cliente
        ];
    }
}