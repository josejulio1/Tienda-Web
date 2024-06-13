<?php
namespace API;

use Database\Database;
use Model\Cliente;
use Model\Producto;
use Model\VProductoCategoria;
use Model\VProductoValoracionPromedio;
use Model\VUsuarioRol;
use Util\API\AdminHelper;
use Util\API\HttpErrorMessages;
use Util\API\HttpStatusCode;
use Util\API\HttpSuccessMessages;
use Util\API\Response;
use Util\Image\ImageFolder;
use Util\Image\ImageHelper;
use Util\Image\TypeImage;

/**
 * Controlador de API para la tabla {@see Producto}
 * @author josejulio1
 * @version 1.0
 */
class ProductController {
    /**
     * Obtiene todos los {@see Producto productos} de la base de datos
     * @return void
     */
    public static function getAll(): void {
        AdminHelper::getAll(VProductoCategoria::class, [
            VProductoCategoria::PRODUCTO_ID,
            VProductoCategoria::NOMBRE,
            VProductoCategoria::PRECIO,
            VProductoCategoria::MARCA,
            VProductoCategoria::STOCK,
            VProductoCategoria::RUTA_IMAGEN,
            VProductoCategoria::NOMBRE_CATEGORIA
        ], VUsuarioRol::PERMISO_PRODUCTO);
    }

    /**
     * Obtiene las 3 primeras fotos de los {@see Producto productos} para mostrarlos en la página de
     * autenticación del {@see Cliente}
     * @return void
     */
    public static function getCarrousel(): void {
        Response::sendResponse(HttpStatusCode::OK, null, [
            'imagenes' => array_map(function(Producto $producto) {
                return $producto -> { Producto::RUTA_IMAGEN };
            }, Producto::all([Producto::RUTA_IMAGEN], 3))
        ]);
    }

    /**
     * Obtiene la descripción de un {@see Producto}
     * @return void
     */
    public static function getProductDescription(): void {
        $id = $_GET['id'];
        if (!filter_var(intval($id), FILTER_VALIDATE_INT)) {
            Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::UNKNOWN_ID);
            return;
        }
        $producto = Producto::findOne($id, [Producto::DESCRIPCION]);
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

    /**
     * Muestra {@see Producto productos} buscados en la barra de búsqueda del nav la tienda
     * @return void
     */
    public static function searchBar() {
        $searchBarItems = VProductoValoracionPromedio::findBeginWithName(
            $_POST[VProductoValoracionPromedio::NOMBRE],
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

    /**
     * Crea un {@see Producto} nuevo en la base de datos
     * @return void
     */
    public static function create(): void {
        $_POST[Producto::RUTA_IMAGEN] = ImageHelper::createImage($_FILES[Producto::RUTA_IMAGEN], new ImageFolder($_POST[Producto::NOMBRE], TypeImage::PRODUCT));

        $productoFormulario = new Producto($_POST);
        if (!$productoFormulario -> create()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
            } else {
                Response::sendResponse(HttpStatusCode::INCORRECT_DATA, HttpErrorMessages::EXISTS);
            }
            return;
        }
        Response::sendResponse(HttpStatusCode::OK, HttpSuccessMessages::CREATED, [
            'entidades' => Producto::last([Producto::ID, Producto::RUTA_IMAGEN])
        ]);
    }

    /**
     * Actualiza un {@see Producto} en la base de datos
     * @return void
     */
    public static function update(): void {
        $productoFormulario = Producto::findOne($_POST[Producto::ID]);
        $productoFormulario -> nombre = $_POST[Producto::NOMBRE];
        $productoFormulario -> precio = $_POST[Producto::PRECIO];
        $productoFormulario -> descripcion = $_POST[Producto::DESCRIPCION];
        if (!$productoFormulario -> save()) {
            if (!Database::isConnected()) {
                Response::sendResponse(HttpStatusCode::SERVICE_UNAVAILABLE, HttpErrorMessages::SERVICE_UNAVAILABLE);
                return;
            }
        }
        Response::sendResponse(HttpStatusCode::OK, HttpSuccessMessages::UPDATED);
    }

    /**
     * Elimina un {@see Producto} en la base de datos
     * @return void
     */
    public static function delete(): void {
       AdminHelper::deleteRow(Producto::class);
    }
}