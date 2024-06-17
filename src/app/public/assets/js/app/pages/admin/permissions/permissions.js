/**
 * Define el número de cada permiso de la aplicación. Importante para realizar una operación AND al permiso del usuario
 * y de esa forma si un usuario se sabe si tiene un permiso o no
 * @type {{READ: number, DELETE: number, NO_PERMISSIONS: number, CREATE: number, UPDATE: number}}
 * @author josejulio1
 * @version 1.0
 */
export const PERMISSIONS = {
    NO_PERMISSIONS: 0,
    CREATE: 1,
    READ: 2,
    UPDATE: 4,
    DELETE: 8
}