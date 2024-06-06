<?php
namespace Model;

use PDO;
use Exception;
use Database\Database;

class VComentarioClienteProducto extends AbstractActiveRecord {
    protected static string $tableName = 'V_Comentario_Cliente_Producto';
    protected static string $primaryKeyColumn = self::PRODUCTO_ID;

    public const PRODUCTO_ID = 'producto_id';
    public const CLIENTE_ID = 'cliente_id';
    public const NOMBRE_CLIENTE = 'nombre_cliente';
    public const APELLIDOS_CLIENTE = 'apellidos_cliente';
    public const RUTA_IMAGEN_PERFIL = 'ruta_imagen_perfil';
    public const COMENTARIO = 'comentario';
    public const NUM_ESTRELLAS = 'num_estrellas';

    public int $producto_id;
    public int $cliente_id;
    public string $nombre_cliente;
    public string $apellidos_cliente;
    public string $ruta_imagen_perfil;
    public string $comentario;
    public int $num_estrellas;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> producto_id = $data[self::PRODUCTO_ID] ?? 0;
        $this -> cliente_id = $data[self::CLIENTE_ID] ?? 0;
        $this -> nombre_cliente = $data[self::NOMBRE_CLIENTE] ?? '';
        $this -> apellidos_cliente = $data[self::APELLIDOS_CLIENTE] ?? '';
        $this -> ruta_imagen_perfil = $data[self::RUTA_IMAGEN_PERFIL] ?? '';
        $this -> comentario = $data[self::COMENTARIO] ?? '';
        $this -> num_estrellas = $data[self::NUM_ESTRELLAS] ?? 0;
    }

    public static function customerHasCommentedInProduct(int $productId): bool {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return false;
        }
        $statement = $db -> getPdo() -> prepare(
            'SELECT ' . self::PRODUCTO_ID . ' FROM ' . self::$tableName
                . ' WHERE ' . self::CLIENTE_ID . ' = ? AND ' . self::PRODUCTO_ID . ' = ?');
        try {
            $statement -> execute([$_SESSION['id'], $productId]);
        } catch (Exception $e) {
            return false;
        }
        return !self::mapResultToObject($statement -> fetchAll(PDO::FETCH_ASSOC));
    }
}