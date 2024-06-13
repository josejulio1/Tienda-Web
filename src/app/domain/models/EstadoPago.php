<?php
namespace Model;

use Model\Base\AbstractActiveRecordCrud;

/**
 * Clase modelo que controla la tabla Estado_Pago de la base de datos
 * @author josejulio1
 * @version 1.0
 */
class EstadoPago extends AbstractActiveRecordCrud {
    protected static string $tableName = 'Estado_Pago';
    protected static string $primaryKeyColumn = self::ID;

    // Nombre de columnas
    public const ID = 'id';
    public const NOMBRE = 'nombre';

    public int $id;
    public string $nombre;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data[self::ID] ?? 0;
        $this -> nombre = $data[self::NOMBRE] ?? '';
    }

    function getColumns(): array {
        return [
            self::ID => $this -> id,
            self::NOMBRE => $this -> nombre
        ];
    }
}