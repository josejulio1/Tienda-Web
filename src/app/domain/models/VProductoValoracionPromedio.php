<?php
namespace Model;

use Model\Base\AbstractActiveRecord;
use Database\Database;
use Exception;
use PDO;

/**
 * Clase modelo que controla la vista V_Producto_Valoracion_Promedio de la base de datos
 * @author josejulio1
 * @version 1.0
 */
class VProductoValoracionPromedio extends AbstractActiveRecord {
    protected static string $tableName = 'V_Producto_Valoracion_Promedio';
    protected static string $primaryKeyColumn = self::ID;

    // Nombre de columnas
    public const ID = 'id';
    public const NOMBRE = 'nombre';
    public const DESCRIPCION = 'descripcion';
    public const RUTA_IMAGEN = 'ruta_imagen';
    public const PRECIO = 'precio';
    public const MARCA_ID = 'marca_id';
    public const MARCA = 'marca';
    public const CATEGORIA_ID = 'categoria_id';
    public const NOMBRE_CATEGORIA = 'nombre_categoria';
    public const VALORACION_PROMEDIO = 'valoracion_promedio';

    public int $id;
    public string $nombre;
    public string $descripcion;
    public string $ruta_imagen;
    public float $precio;
    public int $marca_id;
    public string $marca;
    public int $categoria_id;
    public string $nombre_categoria;
    public int $valoracion_promedio;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> id = $data[self::ID] ?? 0;
        $this -> nombre = $data[self::NOMBRE] ?? '';
        $this -> descripcion = $data[self::DESCRIPCION] ?? '';
        $this -> ruta_imagen = $data[self::RUTA_IMAGEN] ?? '';
        $this -> precio = $data[self::PRECIO] ?? 0.0;
        $this -> marca_id = $data[self::MARCA_ID] ?? 0;
        $this -> marca = $data[self::MARCA] ?? '';
        $this -> categoria_id = $data[self::CATEGORIA_ID] ?? 0;
        $this -> nombre_categoria = $data[self::NOMBRE_CATEGORIA] ?? '';
        $this -> valoracion_promedio = $data[self::VALORACION_PROMEDIO] ?? 0;
    }

    /**
     * Busca un {@see Producto} coincidiendo las primeras letras.
     * @param string $productName Nombre o coincidencias del producto a buscar
     * @param array $columns Columnas que se desean obtener
     * @return array|null Devuelve un array si la consulta se realizó correctamente o null si ocurrió un error en la base de datos
     */
    public static function findBeginWithName(string $productName, array $columns = []): ?array {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return null;
        }
        $statement = $db -> getPdo() -> prepare(
            'SELECT ' . ($columns ? join(',', $columns) : '*')
            . ' FROM ' . self::$tableName . ' WHERE ' . self::NOMBRE . ' LIKE ?');
        try {
            $statement -> execute([$productName . '%']);
        } catch (Exception $e) {
            return null;
        }
        return self::mapResultToObject($statement -> fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * Busca un {@see Producto} a través de la posible información que se puede pasar por un Query String
     * @param array $queryParameters Parámetros del Query String a filtrar
     * @param array $columns Columnas que se desean obtener
     * @return array|null Devuelve un array si la consulta se realizó correctamente o null si ocurrió un error en la base de datos
     */
    public static function findWithQueryString(array $queryParameters = [], array $columns = []): ?array {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return null;
        }
        $where = ' WHERE ';
        $values = [];
        $concatAnd = false;
        $validTokens = ['categoria_id', 'marca_id', 'precio', 'nombre'];
        foreach ($queryParameters as $queryParameterKey => $queryParameter) {
            // Prevenir inyección SQL
            if (!in_array($queryParameterKey, $validTokens)) {
                continue;
            }
            if ($concatAnd) {
                $where .= ' AND ';
            }
            if ($queryParameterKey === 'nombre') {
                $where .= self::NOMBRE . ' LIKE ?';
                $values[] = $queryParameter . '%';
                $concatAnd = true;
                continue;
            } else if ($queryParameterKey === 'precio') {
                $where .= self::PRECIO . ' BETWEEN ? AND ?';
                $values[] = $queryParameter[0];
                $values[] = $queryParameter[1];
                $concatAnd = true;
                continue;
            }
            $where .= "$queryParameterKey = ?";
            $values[] = $queryParameter;
            $concatAnd = true;
        }
        $statement = $db -> getPdo() -> prepare(
            'SELECT ' . ($columns ? join(',', $columns) : '*')
            . ' FROM ' . self::$tableName . $where);
        try {
            $statement -> execute($values);
        } catch (Exception $e) {
            return null;
        }
        return self::mapResultToObject($statement -> fetchAll(PDO::FETCH_ASSOC));
    }
}