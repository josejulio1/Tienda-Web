<?php
namespace Util\Permission;

/**
 * Define los permisos existentes en la aplicación. La forma de funcionar los permisos es aplicando
 * un AND lógico al permiso que contenga un usuario administrador, de forma que si devuelve un número <b>distinto de 0</b>,
 * es que no tiene permiso. Por ejemplo, si el usuario con permiso_marca es 7, y se quiere averiguar si puede crear marcas,
 * se debe hacer lo siguiente:
 * - Pasar el permiso_marca y el permiso (que el de crear es 1) a comprobar si lo tiene a binario y realizar una operación AND lógico
 * ``
 *     0111
 * AND 0001
 * --------
 *     0001
 * ``
 * - Pasar de nuevo el resultado a decimal: 0001 -> ((2^3) * 0) + ((2^2 * 0) + ((2^1) * 0) + ((2^0) * 1) = 1
 * - En el caso que el resultado en decimal sea un número <b>distinto de 0</b>, significará que <b>NO tendrá permiso</b>
 *
 * En el caso de que se quieran añadir más permisos, deben ser siempre <b>potencias de 2</b>
 * @author josejulio1
 * @version 1.0
 */
class Permissions {
    public const NO_PERMISSIONS = 0;
    public const CREATE = 1;
    public const READ = 2;
    public const UPDATE = 4;
    public const DELETE = 8;
}