<?php
namespace Model;

use Model\Base\AbstractActiveRecord;
use Database\Database;
use Exception;
use PDO;

/**
 * Clase modelo que controla la vista V_Comentario_Cliente_Producto de la base de datos
 * @author josejulio1
 * @version 1.0
 */
class VComentarioClienteProducto extends AbstractActiveRecord {
    protected static string $tableName = 'V_Comentario_Cliente_Producto';
    protected static string $primaryKeyColumn = self::PRODUCTO_ID;

    // Nombre de columnas
    public const PRODUCTO_ID = 'producto_id';
    public const CLIENTE_ID = 'cliente_id';
    public const NOMBRE_CLIENTE = 'nombre_cliente';
    public const APELLIDOS_CLIENTE = 'apellidos_cliente';
    public const RUTA_IMAGEN_PERFIL = 'ruta_imagen_perfil';
    public const COMENTARIO = 'comentario';
    public const NUM_ESTRELLAS = 'num_estrellas';
    public const FECHA_HORA_COMENTARIO = 'fecha_hora_comentario';

    public int $producto_id;
    public int $cliente_id;
    public string $nombre_cliente;
    public string $apellidos_cliente;
    public string $ruta_imagen_perfil;
    public string $comentario;
    public int $num_estrellas;
    public string $fecha_hora_comentario;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this -> producto_id = $data[self::PRODUCTO_ID] ?? 0;
        $this -> cliente_id = $data[self::CLIENTE_ID] ?? 0;
        $this -> nombre_cliente = $data[self::NOMBRE_CLIENTE] ?? '';
        $this -> apellidos_cliente = $data[self::APELLIDOS_CLIENTE] ?? '';
        $this -> ruta_imagen_perfil = $data[self::RUTA_IMAGEN_PERFIL] ?? '';
        $this -> comentario = $data[self::COMENTARIO] ?? '';
        $this -> num_estrellas = $data[self::NUM_ESTRELLAS] ?? 0;
        $this -> fecha_hora_comentario = $data[self::FECHA_HORA_COMENTARIO] ?? '';
    }

    /**
     * Comprueba si un {@see Cliente} ha realizado un comentario sobre un {@see Producto}, ya que un cliente
     * solo podrá comentar una vez en un producto
     * @param int $productId ID del producto donde comprobar
     * @return bool True si ha comentado y false si no
     */
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

    /**
     * Obtiene el último comentario que ha realizado el {@see Cliente} con el que se tiene iniciado sesión sobre un {@see Producto}.
     * @param int $productId ID del producto donde comprobar
     * @param array $columns Columnas que se desean obtener
     * @return VComentarioClienteProducto|null Devuelve una instancia del objeto si se ha encontrado comentario y null si la base
     * de datos no funciona o no ha encontrado nada
     */
    public static function lastCustomerCommentInProduct(int $productId, array $columns = []): ?VComentarioClienteProducto {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return null;
        }
        $statement = $db -> getPdo() -> prepare(
            'SELECT ' . ($columns ? join(',', $columns) : '*')
            . ' FROM ' . self::$tableName
            . ' WHERE ' . self::CLIENTE_ID . ' = ? AND ' . self::PRODUCTO_ID . ' = ? ORDER BY ' . self::FECHA_HORA_COMENTARIO . ' DESC');
        try {
            $statement -> execute([$_SESSION['id'], $productId]);
        } catch (Exception $e) {
            return null;
        }
        $entities = self::mapResultToObject($statement -> fetchAll(PDO::FETCH_ASSOC));
        return $entities ? $entities[0] : null;
    }
}