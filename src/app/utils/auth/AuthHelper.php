<?php
namespace Util\Auth;

class AuthHelper {
    /**
     * Autentica si un usuario tiene una sesión iniciada o no. Se le puede pasar como parámetro
     * una constante de la clase {@see RoleAccess} para verificar si el que tiene la sesión iniciada
     * es un cliente o un usuario. En caso de no pasar nada como parámetro, validará solo si hay
     * una sesión iniciada.
     * @param int|null $typeRole Tipo de role con sesión iniciada. Usar constantes de {@see RoleAccess}
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

    public static function startSession(int $id, int $roleAccess, bool $keepSession = false) {
        if ($keepSession) {
            // Establecer ID de sesión aleatorio
            session_id(uniqid());
            // Establecer duración de la sesión durante 1 mes
            session_set_cookie_params(30 * 24 * 60 * 60);
        }
        session_start();
        $_SESSION['id'] = $id;
        $_SESSION['rol'] = $roleAccess;
    }

    public static function closeSession() {
        session_start();
        $_SESSION = null;
        session_destroy();
    }
}