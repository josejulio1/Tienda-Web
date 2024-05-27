<?php
namespace Util\API;

use Database\Database;
use Model\VUsuarioRol;
use Util\Auth\AuthHelper;
use Util\Auth\RoleAccess;
use Util\Permission\Permissions;

class AdminHelper {
    public static function getAll($model, array $columns, string $permission): void {
        if (!AdminHelper::validateAuth('GET')) {
            return;
        }
        http_response_code(HttpStatusCode::OK);

        $models = $model::all($columns);
        if (!$models) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::NOT_FOUND, HttpErrorMessages::NO_ROWS);
            }
            return;
        }
        $permisoModelLogeado = VUsuarioRol::find($_SESSION['id'], [$permission])[0];
        Response::sendResponse(HttpStatusCode::OK, null, [
            'entidades' => $models,
            'hasUpdatePermissions' => $permisoModelLogeado -> $permission & Permissions::UPDATE,
            'hasDeletePermissions' => $permisoModelLogeado -> $permission & Permissions::DELETE
        ]);
    }

    public static function updateRow($model): void {
        if (!AdminHelper::validateAuth('PUT')) {
            return;
        }
        http_response_code(HttpStatusCode::OK);

        $json = JsonHelper::getPostInJson();
        $primarKeyColumn = array_shift($json);
        $modeloFormulario = $model::find($primarKeyColumn);
        $keys = array_keys($json);
        foreach ($keys as $key) {
            $modeloFormulario -> $key = $json[$key];
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
        if (!AdminHelper::validateAuth('DELETE')) {
            return;
        }
        http_response_code(HttpStatusCode::OK);

        $id = $_GET['id'];
        if (!filter_var(FILTER_VALIDATE_INT)) {
            Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::UNKNOWN_ID);
            return;
        }
        $modeloIniciadoSesion = $model::find($id);
        if (!$modeloIniciadoSesion) {
            Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::UNKNOWN_ID);
            return;
        }
        // Saber si el usuario que se quiere eliminar es con el que se está iniciado sesión, ya que no se puede
        if ($model === 'Model\Usuario') {
            if ($modeloIniciadoSesion -> id === $_SESSION['id']) {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::NO_DELETE_LOGGED_USER);
                return;
            }
        }
        if (!$modeloIniciadoSesion -> delete()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
                return;
            }
        }
        Response::sendResponse(HttpStatusCode::OK, HttpSuccessMessages::DELETED);
    }

    public static function validateAuth(string $typeMethodNotAllowed): bool {
        if ($_SERVER['REQUEST_METHOD'] !== $typeMethodNotAllowed) {
            http_response_code(HttpStatusCode::METHOD_NOT_ALLOWED);
            return false;
        }
        if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
            header('Location: /');
        }
        return true;
    }
}