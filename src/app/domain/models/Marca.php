<?php
namespace Model;

class Marca extends AbstractActiveRecordCrud {
    protected static string $tableName = 'Marca';
    protected static string $primaryKeyColumn = self::ID;

    public const ID = 'id';
    public const MARCA = 'marca';

    public int $id;
    public string $marca;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data['id'] ?? 0;
        $this -> marca = $data['marca'] ?? '';
    }

    public function getColumns(): array {
        return [
            self::ID => $this -> id,
            self::MARCA => $this -> marca
        ];
    }
}