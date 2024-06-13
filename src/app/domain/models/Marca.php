<?php
namespace Model;

use Model\Base\AbstractActiveRecordCrud;

/**
 * Clase modelo que controla la tabla Marca de la base de datos
 * @author josejulio1
 * @version 1.0
 */
class Marca extends AbstractActiveRecordCrud {
    protected static string $tableName = 'Marca';
    protected static string $primaryKeyColumn = self::ID;

    // Nombre de columnas
    public const ID = 'id';
    public const MARCA = 'marca';

    public int $id;
    public string $marca;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data[self::ID] ?? 0;
        $this -> marca = $data[self::MARCA] ?? '';
    }

    public function getColumns(): array {
        return [
            self::ID => $this -> id,
            self::MARCA => $this -> marca
        ];
    }
}