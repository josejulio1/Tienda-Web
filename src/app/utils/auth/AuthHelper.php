<?php
namespace Util\Auth;

use Model\Cliente;
use Model\Usuario;

/**
 * Clase Helper utilizada para la autenticación de la aplicación
 * @author josejulio1
 * @version 1.0
 */
class AuthHelper {
    /**
     * Autentica si un usuario tiene una sesión iniciada o no. Se le puede pasar como parámetro
     * una constante de la clase {@see RoleAccess} para verificar si el que tiene la sesión iniciada
     * es un cliente o un usuario. En caso de no pasar nada como parámetro, validará solo si hay
     * una sesión iniciada.
     * @param int|null $typeRole Tipo de role con sesión iniciada. Usar constantes de {@see RoleAccess}. En caso de ser null, se validará si tiene alguna sesión iniciada
     * @return bool Devuelve true en caso de que exista una sesión iniciada o false si no la hay
     */
    public static function isAuthenticated(?int $typeRole = null): bool {
        if ($typeRole) {
            if ($typeRole !== RoleAccess::USER && $typeRole !== RoleAccess::CUSTOMER) {
                return false;
            }
        }
        // Comprobar si se tiene una sesión sin usar session_start ya que puede que en la página esté ya iniciada la sesión, y daría un Warning
        if (isset($_SESSION['rol'])) {
            // En caso de que se haya pasado por parámetro a verificar si tiene iniciada sesión un cliente o un usuario, está autenticado,
            // en caso contrario, no lo está
            return $typeRole && $_SESSION['rol'] === $typeRole;
        }

        session_start();
        if (!$_SESSION) {
            session_abort();
            return false;
        }
        if ($typeRole) {
            if ($_SESSION['rol'] === $typeRole) {
                session_abort();
                return true;
            }
            session_abort();
            return false;
        }
        session_abort();
        return true;
    }

    /**
     * Inicia una nueva sesión.
     * @param int $id ID del {@see Usuario}/{@see Cliente} a asignar la sesión
     * @param int $roleAccess Tipo de acceso de la sesión. Usar constantes de {@see RoleAccess}
     * @param bool $keepSession True si se quiere mantener la sesión iniciada o false si no
     * @return void
     */
    public static function startSession(int $id, int $roleAccess, bool $keepSession = false): void {
        if ($keepSession) {
            // Establecer ID de sesión aleatorio
            session_id(uniqid());
            // Establecer duración de la sesión durante 1 mes
            session_set_cookie_params($_SERVER['SESSION_TIME_SECONDS']);
        }
        session_start();
        $_SESSION['id'] = $id;
        $_SESSION['rol'] = $roleAccess;
    }

    /**
     * Cierra y destruye la sesión iniciada.
     * @return void
     */
    public static function closeSession(): void {
        session_start();
        $_SESSION = null;
        session_destroy();
    }
}