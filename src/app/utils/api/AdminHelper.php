<?php
namespace Util\API;

use Database\Database;
use Model\IContainsImage;
use Model\VUsuarioRol;
use Util\Auth\AuthHelper;
use Util\Auth\RoleAccess;
use Util\Image\DefaultPath;
use Util\Image\ImageHelper;
use Util\Permission\Permissions;

class AdminHelper {
    public static function getAll($model, array $columns, string $permission): void {
        $models = $model::all($columns);
        if (!$models) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::NOT_FOUND, HttpErrorMessages::NO_ROWS);
            }
            return;
        }
        session_start();
        $permisoModelLogeado = VUsuarioRol::findOne($_SESSION['id'], [$permission]);
        Response::sendResponse(HttpStatusCode::OK, null, [
            'entidades' => $models,
            'hasUpdatePermissions' => $permisoModelLogeado -> $permission & Permissions::UPDATE,
            'hasDeletePermissions' => $permisoModelLogeado -> $permission & Permissions::DELETE
        ]);
    }

    public static function updateRow($model): void {
        $primarKeyColumn = array_shift($_POST);
        $modeloFormulario = $model::findOne($primarKeyColumn);
        $keys = array_keys($_POST);
        foreach ($keys as $key) {
            $modeloFormulario -> $key = $_POST[$key];
        }
        if (!$modeloFormulario -> save()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
                return;
            }
        }
        Response::sendResponse(HttpStatusCode::OK, HttpSuccessMessages::UPDATED);
    }

    public static function deleteRow($model): void {
        $id = $_GET['id'];
        if (!filter_var(FILTER_VALIDATE_INT)) {
            Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::UNKNOWN_ID);
            return;
        }
        $modeloIniciadoSesion = $model::findOne($id);
        if (!$modeloIniciadoSesion) {
            Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::UNKNOWN_ID);
            return;
        }
        // Saber si el usuario que se quiere eliminar es con el que se está iniciado sesión, ya que no se puede
        if ($model === 'Model\Usuario') {
            session_start();
            if ($modeloIniciadoSesion -> id === $_SESSION['id']) {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::NO_DELETE_LOGGED_USER);
                return;
            }
        }
        // Si el modelo contiene la interfaz IContainsImage, es porque contiene una imagen y se debe de eliminar del servidor (se elimina si se eliminó correctamente la entidad)
        $rutaImagenPerfil = null;
        if ($modeloIniciadoSesion instanceof IContainsImage) {
            $rutaImagenPerfil = $modeloIniciadoSesion -> getImagePath();
        }
        if (!$modeloIniciadoSesion -> delete()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
                return;
            }
        }
        if ($rutaImagenPerfil && $rutaImagenPerfil !== DefaultPath::DEFAULT_IMAGE_PROFILE) {
            ImageHelper::deleteImage($rutaImagenPerfil);
        }
        Response::sendResponse(HttpStatusCode::OK, HttpSuccessMessages::DELETED);
    }

    public static function validateAuth(string $typeMethodNotAllowed): int {
        if ($_SERVER['REQUEST_METHOD'] !== $typeMethodNotAllowed || !AuthHelper::isAuthenticated(RoleAccess::USER)) {
            return HttpStatusCode::METHOD_NOT_ALLOWED;
        }
        return HttpStatusCode::OK;
    }
}