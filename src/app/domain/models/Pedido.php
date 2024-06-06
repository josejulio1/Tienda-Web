<?php
namespace Model;

class Pedido extends AbstractActiveRecordCrud {
    protected static string $tableName = 'Pedido';
    protected static string $primaryKeyColumn = self::ID;

    public const ID = 'id';
    public const CLIENTE_ID = 'cliente_id';
    public const METODO_PAGO_ID = 'metodo_pago_id';
    public const ESTADO_PAGO_ID = 'estado_pago_id';
    public const DIRECCION_ENVIO = 'direccion_envio';

    public int $id;
    public int $cliente_id;
    public string $metodo_pago_id;
    public string $estado_pago_id;
    public string $direccion_envio;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data['id'] ?? 0;
        $this -> cliente_id = $data['cliente_id'] ?? 0;
        $this -> metodo_pago_id = $data['metodo_pago_id'] ?? '';
        $this -> estado_pago_id = $data['estado_pago_id'] ?? '';
        $this -> direccion_envio = $data['direccion_envio'] ?? '';
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