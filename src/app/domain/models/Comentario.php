<?php
namespace Model;

class Comentario extends AbstractActiveRecordCrud {
    protected static string $tableName = 'Comentario';
    protected static string $primaryKeyColumn = self::ID;

    public const ID = 'id';
    public const CLIENTE_ID = 'cliente_id';
    public const PRODUCTO_ID = 'producto_id';
    public const COMENTARIO = 'comentario';
    public const NUM_ESTRELLAS = 'num_estrellas';

    public int $id;
    public string $cliente_id;
    public int $producto_id;
    public string $comentario;
    public int $num_estrellas;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data['id'] ?? 0;
        $this -> cliente_id = $data['cliente_id'] ?? '';
        $this -> producto_id = $data['producto_id'] ?? 0;
        $this -> comentario = $data['comentario'] ?? '';
        $this -> num_estrellas = $data['num_estrellas'] ?? 0;
    }

    public function getColumns(): array {
        return [
            self::ID => $this -> id,
            self::CLIENTE_ID => $this -> cliente_id,
            self::PRODUCTO_ID => $this -> producto_id,
            self::COMENTARIO => $this -> comentario,
            self::NUM_ESTRELLAS => $this -> num_estrellas
        ];
    }
}