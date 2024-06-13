<?php
namespace API;

use Database\Database;
use Model\Usuario;
use Model\VUsuarioRol;
use Util\API\AdminHelper;
use Util\API\HttpErrorMessages;
use Util\API\HttpStatusCode;
use Util\API\HttpSuccessMessages;
use Util\API\Response;
use Util\Auth\AuthHelper;
use Util\Auth\RoleAccess;
use Util\Image\DefaultPath;
use Util\Image\ImageFolder;
use Util\Image\ImageHelper;
use Util\Image\TypeImage;

/**
 * Controlador de API para la tabla {@see Usuario}
 * @author josejulio1
 * @version 1.0
 */
class UserController {
    /**
     * Obtiene todos los {@see Usuario usuarios} de la base de datos
     * @return void
     */
    public static function getAll(): void {
        AdminHelper::getAll(VUsuarioRol::class, [
            VUsuarioRol::USUARIO_ID,
            VUsuarioRol::USUARIO,
            VUsuarioRol::CORREO,
            VUsuarioRol::NOMBRE_ROL,
            VUsuarioRol::COLOR_ROL,
            VUsuarioRol::RUTA_IMAGEN_PERFIL
            ], VUsuarioRol::PERMISO_USUARIO);
    }

    /**
     * Crea un {@see Usuario} nueva en la base de datos
     * @return void
     */
    public static function create(): void {
        $_POST[Usuario::CONTRASENIA] = password_hash($_POST[Usuario::CONTRASENIA], PASSWORD_DEFAULT);
        if ($_FILES) {
            $_POST[Usuario::RUTA_IMAGEN_PERFIL] = ImageHelper::createImage($_FILES[Usuario::RUTA_IMAGEN_PERFIL], new ImageFolder($_POST[Usuario::CORREO], TypeImage::PROFILE_USER));
        } else {
            // Si no tiene imagen de perfil, aplicarle la de por defecto
            $_POST[Usuario::RUTA_IMAGEN_PERFIL] = DefaultPath::DEFAULT_IMAGE_PROFILE;
        }
        $usuarioFormulario = new Usuario($_POST);
        if (!$usuarioFormulario -> create()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::EXISTS);
            }
            return;
        }
        Response::sendResponse(HttpStatusCode::OK, HttpSuccessMessages::CREATED, [
            'entidades' => VUsuarioRol::findByEmail($usuarioFormulario -> correo, [
                VUsuarioRol::USUARIO_ID,
                VUsuarioRol::RUTA_IMAGEN_PERFIL
            ])
        ]);
    }

    /**
     * Actualiza un {@see Usuario} en la base de datos
     * @return void
     */
    public static function update(): void {
        AdminHelper::updateRow(Usuario::class);
    }

    /**
     * Elimina un {@see Usuario} en la base de datos
     * @return void
     */
    public static function delete(): void {
        AdminHelper::deleteRow(Usuario::class);
    }

    /**
     * Inicia sesión con un {@see Usuario} en el panel de administración
     * @return void
     */
    public static function login(): void {
        $usuarioDb = Usuario::findByEmail($_POST[Usuario::CORREO], [
            Usuario::ID,
            Usuario::CONTRASENIA
        ]);
        // Verificar si el usuario existe o la base de datos no funciona
        if (!$usuarioDb) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::NOT_FOUND, HttpErrorMessages::INCORRECT_USER_OR_PASSWORD);
            }
            return;
        }
        $usuarioFormulario = new Usuario($_POST);
        // Verificar si la contraseña es incorrecta
        if (!password_verify($usuarioFormulario -> contrasenia, $usuarioDb -> contrasenia)) {
            Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::INCORRECT_USER_OR_PASSWORD);
            return;
        }
        // En caso de que el usuario sea correcto, ofrecer sesión
        AuthHelper::startSession($usuarioDb -> id, RoleAccess::USER, $_POST['mantener-sesion'] === 'true');
        Response::sendResponse(HttpStatusCode::OK);
    }
}