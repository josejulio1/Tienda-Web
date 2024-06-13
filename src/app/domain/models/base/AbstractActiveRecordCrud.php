<?php
namespace Model\Base;

use Database\Database;
use Exception;

/**
 * Clase base para implementar el patrón Active Record.
 *
 * Esta clase está pensada para los que tienen quieren heredar una clase que pueda realizar operaciones CRUD en la base de datos.
 *
 * Este patrón consiste en tratar a cada tabla de la base de datos como una clase y definir las propiedades
 * de la clase como las columnas respectivas a su tabla en la base de datos. Toda clase que quiera interactuar con
 * la base de datos debe heredar de esta clase o sus clases hermanas {@see AbstractActiveRecordAuth} o {@see AbstractActiveRecordCrud},
 * que {@see AbstractActiveRecordAuth} se utiliza en caso de que su clase esté pensada para realizar un inicio de sesión o registro y contenga
 *  un correo, y {@see AbstractActiveRecordCrud} se utiliza en caso de que su clase <b>NO SEA</b> una vista, es decir, que se puedan realizar
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
abstract class AbstractActiveRecordCrud extends AbstractActiveRecord {
    /**
     * @param array $data Datos para mapear las columnas de una base de datos o de un formulario con las propiedades de las clases hijas
     */
    public function __construct(array $data = []) {
        parent::__construct($data);
    }

    /**
     * Crea (CREATE) la información de este objeto en la base de datos.
     * @param bool $removePrimaryKeyColumn True si se desea eliminar la clave primaria de la tabla, ya que al ser
     * la base de datos con ID auto incremental, no es necesario crear un ID manualmente. False en caso de que no se quiera
     * eliminar la clave primaria.
     * @return bool True si se creó correctamente y false si no se pudo crear
     */
    public function create(bool $removePrimaryKeyColumn = true): bool {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return false;
        }
        // Eliminar campos vacíos
        $columns = array_filter($this -> getColumns());
        if ($removePrimaryKeyColumn) {
            unset($columns[static::$primaryKeyColumn]);
        }
        $numColumns = count($columns);
        $statement = $db -> getPdo() -> prepare('INSERT INTO ' . static::$tableName
            . ' (' . join(',', array_keys($columns))
            . ') VALUES (' . substr(str_repeat('?,', $numColumns), 0, $numColumns * 2 - 1) . ')');
        $ok = true;
        try {
            $statement -> execute(array_values($columns));
        } catch (Exception $e) {
            $ok = false;
        }
        return $ok;
    }

    /**
     * Guarda (UPDATE) la información del objeto en la base de datos.
     * @return bool True si se guardó correctamente y false si no se pudo guardar
     */
    public function save(): bool {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return false;
        }
        // Eliminar campos vacíos
        // Si la tabla es Rol, no eliminar valores 0, ya que significa que se quiere quitar todos los permisos a un rol
        if (static::$tableName === 'Rol') {
            $columns = array_filter($this -> getColumns(), function($column) {
                return $column !== '';
            });
        } else {
            $columns = array_filter($this -> getColumns());
        }
        // Mover el ID al final para coincidirlo con el UPDATE (los ID están siempre al principio)
        $id = array_shift($columns);
        $reservedFields = '';
        foreach ($columns as $key => $value) {
            $reservedFields .= "$key = ?,";
        }
        $columns[static::$primaryKeyColumn] = $id;
        $reservedFields = substr($reservedFields, 0, strlen($reservedFields) - 1);
        $statement = $db -> getPdo() -> prepare('UPDATE ' . static::$tableName . " SET $reservedFields WHERE " . static::$primaryKeyColumn . ' = ?');
        try {
            $statement -> execute(array_values($columns));
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * Elimina el elemento de esta clase en la base de datos
     * @return bool True si se eliminó correctamente y false si no se pudo eliminar
     */
    public function delete(): bool {
        $db = Database::connect();
        if (!Database::isConnected()) {
            return false;
        }
        $statement = $db -> getPdo() -> prepare('DELETE FROM ' . static::$tableName . ' WHERE ' . static::$primaryKeyColumn . ' = ?');
        $ok = true;
        try {
            $statement -> execute([static::getColumns()[static::$primaryKeyColumn]]);
        } catch (Exception $e) {
            $ok = false;
        }
        return $ok;
    }

    /**
     * Mapea los nombres de las columnas de la base de datos con sus respectivos valores.
     * Se utiliza para poder realizar las operaciones CRUD. Para mapearlo correctamente, vea
     * el ejemplo de a continuación.
     *
     * <b>IMPORTANTE</b> - La propiedad de la clave primaria de la tabla debe estar siempre en el primera índice del array
     *
     * Si el nombre de la tabla de la base de datos es "Usuario" y
     * tiene las columnas "id", "nombre" y "apellidos", debe quedar de la siguiente forma:
     * ``
     * function getColumns() {
     *     return [
     *         'id' => $this -> id,
     *         'nombre' => $this -> nombre,
     *         'apellidos' => $this -> apellidos
     *     ];
     * }
     * ``
     * @return array
     */
    abstract function getColumns(): array;
}