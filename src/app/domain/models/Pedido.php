<?php
namespace Model;

use Model\Base\AbstractActiveRecordCrud;

/**
 * Clase modelo que controla la tabla Pedido de la base de datos
 * @author josejulio1
 * @version 1.0
 */
class Pedido extends AbstractActiveRecordCrud {
    protected static string $tableName = 'Pedido';
    protected static string $primaryKeyColumn = self::ID;

    // Nombre de columnas
    public const ID = 'id';
    public const CLIENTE_ID = 'cliente_id';
    public const METODO_PAGO_ID = 'metodo_pago_id';
    public const ESTADO_PAGO_ID = 'estado_pago_id';
    public const DIRECCION_ENVIO = 'direccion_envio';

    public int $id;
    public int $cliente_id;
    public int $metodo_pago_id;
    public int $estado_pago_id;
    public string $direccion_envio;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data[self::ID] ?? 0;
        $this -> cliente_id = $data[self::CLIENTE_ID] ?? 0;
        $this -> metodo_pago_id = $data[self::METODO_PAGO_ID] ?? 0;
        $this -> estado_pago_id = $data[self::ESTADO_PAGO_ID] ?? 0;
        $this -> direccion_envio = $data[self::DIRECCION_ENVIO] ?? '';
    }

    function getColumns(): array {
        return [
            self::ID => $this -> id,
            self::CLIENTE_ID => $this -> cliente_id,
            self::METODO_PAGO_ID => $this -> metodo_pago_id,
            self::ESTADO_PAGO_ID => $this -> estado_pago_id,
            self::DIRECCION_ENVIO => $this -> direccion_envio
        ];
    }
}