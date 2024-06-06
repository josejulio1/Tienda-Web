<?php
namespace Model;

class VPedido extends AbstractActiveRecord {
    protected static string $tableName = 'V_Pedido';
    protected static string $primaryKeyColumn = self::CLIENTE_ID;

    public const ID = 'id';
    public const CLIENTE_ID = 'cliente_id';
    public const NOMBRE_PRODUCTO = 'nombre_producto';
    public const METODO_PAGO = 'metodo_pago';
    public const ESTADO_PAGO = 'estado_pago';
    public const DIRECCION_ENVIO = 'direccion_envio';

    public int $id;
    public int $cliente_id;
    public string $nombre_producto;
    public string $metodo_pago;
    public string $estado_pago;
    public string $direccion_envio;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data['id'] ?? 0;
        $this -> cliente_id = $data['cliente_id'] ?? 0;
        $this -> nombre_producto = $data['nombre_producto'] ?? '';
        $this -> metodo_pago = $data['metodo_pago'] ?? '';
        $this -> estado_pago = $data['estado_pago'] ?? '';
        $this -> direccion_envio = $data['direccion_envio'] ?? '';
    }
}