<?php
namespace Model;

class Categoria extends AbstractActiveRecordCrud {
    protected static string $tableName = 'Categoria';
    protected static string $primaryKeyColumn = self::ID;

    public const ID = 'id';
    public const NOMBRE = 'nombre';

    public int $id;
    public string $nombre;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data['id'] ?? 0;
        $this -> nombre = $data['nombre'] ?? '';
    }

    public function getColumns(): array {
        return [
            self::ID => $this -> id,
            self::NOMBRE => $this -> nombre
        ];
    }
}