<?php
namespace Model\Base;

use Database\Database;
use Exception;
use PDO;

/**
 * Clase base para implementar el patrón Active Record.
 *
 * Esta clase está pensada para los que tienen una tabla que tenga un campo email o correo y quiera poder iniciar sesión
 * o registrarse, ya que trae un método llamado <b>findByEmail</b> que permite buscar por email o correo. También permite
 * realizar operaciones CRUD en la base de datos.
 *
 * Este patrón consiste en tratar a cada tabla de la base de datos como una clase y definir las propiedades
 * de la clase como las columnas respectivas a su tabla en la base de datos. Toda clase que quiera interactuar con
 * la base de datos debe heredar de esta clase o sus clases hermanas {@see AbstractActiveRecord} o {@see AbstractActiveRecordCrud},
 * que {@see AbstractActiveRecord} se utiliza en caso de que su clase <b>NO esté pensada</b> para realizar un inicio de sesión o registro y
 * <b>sea una vista</b>, y {@see AbstractActiveRecordCrud} se utiliza en caso de que su clase <b>NO SEA</b> una vista, es decir, que se puedan realizar
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
 * - Se debe implementar la propiedad <b>"protected static string $emailColumn"</b>, que contendrá de valor, el nombre de la
 * columna en la base de datos que se utiliza para guardar el email o el correo. Por ejemplo, si en una tabla "Usuario" la columna
 * del correo se llama "email", se debe realizar lo siguiente:
 * ``
 * protected static string $emailColumn = 'email';
 * ``
 * Finalmente, si todos los pasos anteriores se realizaron correctamente, dada una tabla en la base de datos
 * llamada "Cliente" con columnas "id", "nombre", "apellidos", "edad", "email", "tiene_contrasenia", "ruta_imagen" y "dinero", su clase
 * con Abstract Record sería la siguiente:
 * ``
 * class Cliente extends AbstractActiveRecordCrud {
 *     protected static string $tableName = 'Cliente';
 *     protected static string $primaryKeyColumn = 'id';
 *     protected static string $emailColumn = 'email';
 *
 *     public int $id;
 *     public string $nombre;
 *     public string $apellidos;
 *     public int $edad;
 *     public string $email;
 *     public bool $tiene_contrasenia;
 *     public string $ruta_imagen;
 *     public float $dinero;
 *
 *     public function __construct(array $data = []) {
 *         $this -> id = $data['id'] ?? 0;
 *         $this -> nombre = $data['nombre'] ?? '';
 *         $this -> apellidos = $data['apellidos'] ?? '';
 *         $this -> edad = $data['edad'] ?? 0;
 *         $this -> email = $data['email'] ?? '';
 *         $this -> tiene_contrasenia = $data['tiene_contrasenia'] ?? false;
 *         $this -> ruta_imagen = $data['ruta_imagen'] ?? '';
 *         $this -> dinero = $data['dinero'] ?? 0.0;
 *     }
 * }
 * ``
 * Se debe implementar el método <b>getColumns</b> y devolver un {@see array} vacío en el caso de que su clase {@see sea una vista},
 * ya que se quiso hacer que algunas vistas también pueden heredar la funcionalidad poder tener autenticación, pero al ser vistas,
 * no pueden realizar operaciones CRUD en la base de datos, y como no se puede realizar herencia múltiple, se tuvo que satisfacer el diseño
 * de esta forma, dejando el método getColumns sin implementar.
 * @author josejulio1
 * @version 1.0
 */
abstract class AbstractActiveRecordAuth extends AbstractActiveRecordCrud {
    protected static string $emailColumn = '';

    /**
     * Busca una fila de una tabla en la base de datos por <b>email o correo</b>.
     * @param string $email Email o correo por el que buscar
     * @param array $columns Columnas que se desean obtener de la consulta
     * @return static|null Devuelve un objeto de la clase donde se utiliza este método si la consulta se ejecutó correctamente
     * y null si no se pudo conectar con la base de datos o no encontró ninguna fila
     */
    public static function findByEmail(string $email, array $columns = []): ?static {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return null;
        }
        $statement = $db -> getPdo() -> prepare(
            'SELECT ' . ($columns ? join(',', $columns) : '*') . ' FROM ' . static::$tableName . ' WHERE ' . static::$emailColumn . ' = ?'
        );
        try {
            $statement -> execute([$email]);
        } catch (Exception $e) {
            return null;
        }
        $clientes = self::mapResultToObject($statement -> fetchAll(PDO::FETCH_ASSOC));
        return $clientes ? $clientes[0] : null;
    }
}