<?php
namespace Model;

use Model\Base\AbstractActiveRecordCrud;

/**
 * Clase modelo que controla la tabla Comentario de la base de datos
 * @author josejulio1
 * @version 1.0
 */
class Comentario extends AbstractActiveRecordCrud {
    protected static string $tableName = 'Comentario';
    protected static string $primaryKeyColumn = self::ID;

    // Nombre de columnas
    public const ID = 'id';
    public const CLIENTE_ID = 'cliente_id';
    public const PRODUCTO_ID = 'producto_id';
    public const COMENTARIO = 'comentario';
    public const NUM_ESTRELLAS = 'num_estrellas';
    public const FECHA_HORA_COMENTARIO = 'fecha_hora_comentario';

    public int $id;
    public string $cliente_id;
    public int $producto_id;
    public string $comentario;
    public int $num_estrellas;
    public string $fecha_hora_comentario;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data[self::ID] ?? 0;
        $this -> cliente_id = $data[self::CLIENTE_ID] ?? '';
        $this -> producto_id = $data[self::PRODUCTO_ID] ?? 0;
        $this -> comentario = $data[self::COMENTARIO] ?? '';
        $this -> num_estrellas = $data[self::NUM_ESTRELLAS] ?? 0;
        $this -> fecha_hora_comentario = $data[self::FECHA_HORA_COMENTARIO] ?? '';
    }

    public function getColumns(): array {
        return [
            self::ID => $this -> id,
            self::CLIENTE_ID => $this -> cliente_id,
            self::PRODUCTO_ID => $this -> producto_id,
            self::COMENTARIO => $this -> comentario,
            self::NUM_ESTRELLAS => $this -> num_estrellas,
            self::FECHA_HORA_COMENTARIO => $this -> fecha_hora_comentario
        ];
    }
}