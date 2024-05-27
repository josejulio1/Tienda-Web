<?php
namespace API;

use Database\Database;
use Model\Producto;
use Model\VProductoCategoria;
use Model\VProductoValoracionPromedio;
use Model\VUsuarioRol;
use Util\API\AdminHelper;
use Util\API\HttpErrorMessages;
use Util\API\HttpStatusCode;
use Util\API\HttpSuccessMessages;
use Util\API\JsonHelper;
use Util\API\Response;
use Util\Permission\Permissions;

class ProductController {
    public static function getAll(): void {
        if (!AdminHelper::validateAuth('GET')) {
            return;
        }
        http_response_code(HttpStatusCode::OK);

        $productos = VProductoCategoria::all([
            VProductoCategoria::PRODUCTO_ID,
            VProductoCategoria::NOMBRE,
            VProductoCategoria::PRECIO,
            VProductoCategoria::MARCA,
            VProductoCategoria::STOCK,
            VProductoCategoria::RUTA_IMAGEN,
            VProductoCategoria::NOMBRE_CATEGORIA
        ]);
        if (!$productos) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::NOT_FOUND, HttpErrorMessages::NO_ROWS);
            }
            return;
        }
        $permisoUsuarioLogeado = VUsuarioRol::find($_SESSION['id'], [VUsuarioRol::PERMISO_PRODUCTO]);
        Response::sendResponse(HttpStatusCode::OK, null, [
            'entidades' => $productos,
            'hasUpdatePermissions' => $permisoUsuarioLogeado -> permiso_producto & Permissions::UPDATE,
            'hasDeletePermissions' => $permisoUsuarioLogeado -> permiso_producto & Permissions::DELETE
        ]);
    }

    public static function getProductDescription() {
        if (!AdminHelper::validateAuth('GET')) {
            return;
        }
        http_response_code(HttpStatusCode::OK);

        $id = $_GET['id'];
        if (!filter_var(intval($id), FILTER_VALIDATE_INT)) {
            Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::UNKNOWN_ID);
            return;
        }
        $producto = Producto::find($id, [Producto::DESCRIPCION]);
        if (!$producto) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            }
            return;
        }
        Response::sendResponse(HttpStatusCode::OK, null, [
            'entidades' => $producto
        ]);
    }

    public static function searchBar() {
        $searchBarItems = VProductoValoracionPromedio::findBeginWithName(
            JsonHelper::getPostInJson()[VProductoValoracionPromedio::NOMBRE],
            [
                VProductoValoracionPromedio::ID,
                VProductoValoracionPromedio::NOMBRE,
                VProductoValoracionPromedio::PRECIO,
                VProductoValoracionPromedio::RUTA_IMAGEN,
                VProductoValoracionPromedio::VALORACION_PROMEDIO
            ]
        );
        if (!$searchBarItems) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
                return;
            }
        }
        Response::sendResponse(HttpStatusCode::OK, null, [
            'searchBarItems' => $searchBarItems
        ]);
    }

    public static function create() {
        if (!AdminHelper::validateAuth('POST')) {
            return;
        }
        http_response_code(HttpStatusCode::OK);

        $productoFormulario = new Producto(JsonHelper::getPostInJson());
        if (!$productoFormulario -> create()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::EXISTS);
            }
            return;
        }
        Response::sendResponse(HttpStatusCode::OK, HttpSuccessMessages::CREATED, [
            'entidades' => Producto::last([Producto::ID])
        ]);
    }

    public static function update(): void {
        if (!AdminHelper::validateAuth('PUT')) {
            return;
        }
        http_response_code(HttpStatusCode::OK);

        $json = JsonHelper::getPostInJson();
        $productoFormulario = Producto::find($json[Producto::ID]);
        $productoFormulario -> nombre = $json[Producto::NOMBRE];
        $productoFormulario -> precio = $json[Producto::PRECIO];
        $productoFormulario -> descripcion = $json[Producto::DESCRIPCION];
        if (!$productoFormulario -> save()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
                return;
            }
        }
        Response::sendResponse(HttpStatusCode::OK, HttpSuccessMessages::UPDATED);
    }

    public static function delete(): void {
       AdminHelper::deleteRow(Producto::class);
    }
}