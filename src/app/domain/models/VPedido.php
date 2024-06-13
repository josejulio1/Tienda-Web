<?php
namespace Model;

use Model\Base\AbstractActiveRecord;

/**
 * Clase modelo que controla la vista V_Pedido de la base de datos
 * @author josejulio1
 * @version 1.0
 */
class VPedido extends AbstractActiveRecord {
    protected static string $tableName = 'V_Pedido';
    protected static string $primaryKeyColumn = self::CLIENTE_ID;

    // Nombre de columnas
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
        $this -> id = $data[self::ID] ?? 0;
        $this -> cliente_id = $data[self::CLIENTE_ID] ?? 0;
        $this -> nombre_producto = $data[self::NOMBRE_PRODUCTO] ?? '';
        $this -> metodo_pago = $data[self::METODO_PAGO] ?? '';
        $this -> estado_pago = $data[self::ESTADO_PAGO] ?? '';
        $this -> direccion_envio = $data[self::DIRECCION_ENVIO] ?? '';
    }
}