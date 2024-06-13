<?php
namespace Model\Base;

use Database\Database;
use PDO;
use Util\SQL\TypeOrder;

/**
 * Clase base para implementar el patrón Active Record.
 *
 * <b>IMPORTANTE</b> - Si su clase <b>NO ES UNA VISTA</b>, es decir, si se pueden <b>realizar operaciones CRUD</b> con
 * su clase, vea {@see AbstractActiveRecordCrud}. Esta clase está pensada para las <b>vistas</b>.
 *
 * Este patrón consiste en tratar a cada tabla de la base de datos como una clase y definir las propiedades
 * de la clase como las columnas respectivas a su tabla en la base de datos. Toda clase que quiera interactuar con
 * la base de datos debe heredar de esta clase o sus clases hermanas {@see AbstractActiveRecordAuth} o {@see AbstractActiveRecordCrud},
 * que {@see AbstractActiveRecordAuth} se utiliza en caso de que su clase esté pensada para realizar un inicio de sesión o registro y contenga
 * un correo y {@see AbstractActiveRecordCrud} se utiliza en caso de que su clase <b>NO SEA</b> una vista, es decir, que se puedan realizar
 * operaciones CRUD.
 * Para que estas clases hijas funcionen correctamente se deben seguir los siguientes pasos:
 * - Se debe implementar la propiedad <b>"protected static string $tableName"</b> y se le debe asignar como valor al nombre de su respectiva
 * tabla en la base de datos. Por ejemplo, una tabla llamada "Usuario", su valor en esta propiedad deberá de ser "Usuario".
 * - Se debe implementar la propiedad <b>"protected static string $primaryKeyColumn"</b> y asignarle de valor el nombre de la columna
 * en la base de datos que se utilizará como clave primaria.
 * - Declarar como <b>public</b> las propiedades que vayan a recoger los valores de cada columna en la base de datos.
 * El nombre de las propiedades deben llamarse <b>EXACTAMENTE IGUAL</b> que en la base de datos. Por ejemplo, si en
 * una tabla "Usuario" se tiene el campo "id", "nombre" e "imagen_perfil", se debe realizar lo siguiente:
 * ``
 * public int $id;
 * public string $nombre;
 * public string $imagen_perfil;
 * ``
 * - Implementar en la clase hija el constructor con un parámetro de tipo {@see array} que será el array con los datos cuando se realice
 * una consulta. Se debe mapear cada índice del array con cada propiedad de la clase, que estas propiedades serán equivalentes a sus columnas
 * en la base de datos. Es <b>muy importante</b> que a la hora de mapear, si el valor de la columna vale {@see null}, se debe de asignar
 * un valor por defecto. En el caso de que la propiedad es de tipo int, <b>0</b>, si es un string, <b>''</b>, si es un bool, <b>false</b>
 * y si es un float <b>0.0</b>. Por ejemplo, una clase "Usuario" con columnas "id", "nombre" y "ruta_imagen", deberá de hacer lo siguiente:
 * ``
 * public int $id;
 * public string $nombre;
 * public string $ruta_imagen;
 *
 * public function __construct(array $data = []) {
 *     $this -> id = data['id'] ?? 0;
 *     $this -> nombre = data['nombre'] ?? '';
 *     $this -> ruta_imagen = data['ruta_imagen'] ?? '';
 * }
 * ``
 * Finalmente, si todos los pasos anteriores se realizaron correctamente, dada una tabla en la base de datos
 * llamada "Cliente" con columnas "id", "nombre", "apellidos", "edad", "tiene_contrasenia", "ruta_imagen" y "dinero", su clase
 * con Abstract Record sería la siguiente:
 * ``
 * class Cliente extends AbstractActiveRecordCrud {
 *     protected static string $tableName = 'Cliente';
 *     protected static string $primaryKeyColumn = 'id';
 *
 *     public int $id;
 *     public string $nombre;
 *     public string $apellidos;
 *     public int $edad;
 *     public bool $tiene_contrasenia;
 *     public string $ruta_imagen;
 *     public float $dinero;
 *
 *     public function __construct(array $data = []) {
 *         $this -> id = $data['id'] ?? 0;
 *         $this -> nombre = $data['nombre'] ?? '';
 *         $this -> apellidos = $data['apellidos'] ?? '';
 *         $this -> edad = $data['edad'] ?? 0;
 *         $this -> tiene_contrasenia = $data['tiene_contrasenia'] ?? false;
 *         $this -> ruta_imagen = $data['ruta_imagen'] ?? '';
 *         $this -> dinero = $data['dinero'] ?? 0.0;
 *     }
 * }
 * ``
 * @author josejulio1
 * @version 1.0
 */
abstract class AbstractActiveRecord {
    protected static string $tableName = '';
    protected static string $primaryKeyColumn = '';

    /**
     * @param array $data Datos para mapear las columnas de una base de datos o de un formulario con las propiedades de las clases hijas
     */
    public function __construct(array $data = []) {}

    /**
     * Obtiene todas las filas de una tabla en la base de datos
     * @param array $columns Nombre de las columnas que se desea obtener de la consulta. Opcional
     * @param int|null $limit Número de filas que se desea obtener
     * @param array $order Tipo de ordenación que se desea aplicar a una columna. Para usarlo, se debe aplicar un array asociativo
     * en el que la clave sea el tipo de orden (usar las constantes {@see TypeOrder}) y de valor el nombre de la columna del que se
     * quiere ordenar. Por ejemplo: [ {@see TypeOrder::DESC} => Usuario::NOMRBE ] ordenará la columna "nombre" en orden descendente
     * @return array|null Devuelve un array si la consulta se ejecutó correctamente y null si no se pudo conectar con la base de datos
     */
    public static function all(array $columns = [], ?int $limit = null, array $order = []): ?array {
	    $db = Database::connect();
        if (!Database::isConnected()) {
            return null;
        }
        return self::mapResultToObject(
            $db -> getPdo() -> query(
                'SELECT ' . ($columns ? join(',', $columns) : '*')
                . ' FROM ' . static::$tableName . ($order ? ' ORDER BY ' . array_values($order)[0] . ' ' . array_keys($order)[0] : '')
                . ($limit ? " LIMIT $limit" : '')) -> fetchAll(PDO::FETCH_ASSOC)
            );
    }

    /**
     * Busca un conjunto de filas de una tabla en la base de datos. Se buscará de manera automática por el ID establecido
     * en la clase hija en la que se use este método.
     * @param int $id ID por el que se quiere buscar
     * @param array $columns Columnas que se desean obtener de la consulta. Opcional
     * @param string|null $otherPrimaryKey En caso de que no se quiera buscar por la clave primaria establecida automáticamente
     * en la clase hija (propiedad $primaryKeyColumn), utilizar el nombre de la columna por la que se quiere filtrar en este
     * parámetro
     * @param array $order Tipo de ordenación que se desea aplicar a una columna. Para usarlo, se debe aplicar un array asociativo
     * en el que la clave sea el tipo de orden (usar las constantes {@see TypeOrder}) y de valor el nombre de la columna del que se
     * quiere ordenar. Por ejemplo: [ {@see TypeOrder::DESC} => Usuario::NOMRBE ] ordenará la columna "nombre" en orden descendente
     * @return array|null Devuelve un array si la consulta se ejecutó correctamente y null si no se pudo conectar con la base de datos
     */
    public static function find(int $id, array $columns = [], ?string $otherPrimaryKey = null, array $order = []): ?array {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return null;
        }
        $statement = $db -> getPdo() -> prepare(
            'SELECT ' . ($columns ? join(',', $columns) : '*')
                . ' FROM '. static::$tableName . ' WHERE ' . ($otherPrimaryKey ?: static::$primaryKeyColumn) . ' = ?'
                . ($order ? ' ORDER BY ' . array_values($order)[0] . ' ' . array_keys($order)[0] : '')
        );
        $statement -> execute([$id]);
        return self::mapResultToObject($statement -> fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * Busca una fila de una tabla en la base de datos. Se buscará de manera automática por el ID establecido
     * en la clase hija en la que se use este método.
     * @param int $id ID por el que se quiere buscar
     * @param array $columns Columnas que se desean obtener de la consulta. Opcional
     * @param string|null $otherPrimaryKey En caso de que no se quiera buscar por la clave primaria establecida automáticamente
     * en la clase hija (propiedad $primaryKeyColumn), utilizar el nombre de la columna por la que se quiere filtrar en este
     * parámetro
     * @param array $order Tipo de ordenación que se desea aplicar a una columna. Para usarlo, se debe aplicar un array asociativo
     * en el que la clave sea el tipo de orden (usar las constantes {@see TypeOrder}) y de valor el nombre de la columna del que se
     * quiere ordenar. Por ejemplo: [ {@see TypeOrder::DESC} => Usuario::NOMRBE ] ordenará la columna "nombre" en orden descendente
     * @return static|null Devuelve un objeto de la clase donde se utiliza este método si la consulta se ejecutó correctamente
     * y null si no se pudo conectar con la base de datos o no encontró ninguna fila
     */
    public static function findOne(int $id, array $columns = [], ?string $otherPrimaryKey = null, array $order = []): ?static {
        $objects = self::find($id, $columns, $otherPrimaryKey, $order);
        return $objects ? $objects[0] : null;
    }

    public static function last(array $columns = []): ?static {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return null;
        }
        $objects = self::mapResultToObject($db -> getPdo() -> query(
            'SELECT ' . ($columns ? join(',', $columns) : '*')
                . ' FROM ' . static::$tableName . ' ORDER BY ' . static::$primaryKeyColumn . ' DESC') -> fetchAll(PDO::FETCH_ASSOC)
        );
        return $objects ? $objects[0] : null;
    }

    /**
     * Mapea un array de consulta realizada a objetos
     * @param array $result Array con los datos de una consulta SQL
     * @return array Devuelve un array con los objetos mapeados de la clase donde se utilice este método
     */
    protected static function mapResultToObject(array $result): array {
        $objects = [];
        foreach ($result as $row) {
            $objects[] = new static($row); // Crear una instancia de la clase donde se ejecuta este método
        }
        return $objects;
    }
}
