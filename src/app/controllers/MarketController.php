<?php
namespace Controller;

use Model\CarritoItem;
use Model\Cliente;
use Model\Producto;
use Model\VCarritoCliente;
use Model\VComentarioClienteProducto;
use Model\VPedidoProductoItemDetallado;
use Model\VProductoValoracionPromedio;
use Core\Router;
use Util\Auth\AuthHelper;
use Util\Auth\RoleAccess;
use Util\SQL\TypeOrder;

class MarketController {
    public static function index(Router $router) {
        $router -> render('index', [
            'css' => self::getCssImports(),
            'js' => self::getJsImports(),
            ...self::loadNav(),
            'productos' => VProductoValoracionPromedio::all([
                VProductoValoracionPromedio::ID,
                VProductoValoracionPromedio::NOMBRE,
                VProductoValoracionPromedio::PRECIO,
                VProductoValoracionPromedio::RUTA_IMAGEN,
                VProductoValoracionPromedio::VALORACION_PROMEDIO
            ], 10),
            'productosPorPrecio' => VProductoValoracionPromedio::all([
                VProductoValoracionPromedio::ID,
                VProductoValoracionPromedio::NOMBRE,
                VProductoValoracionPromedio::PRECIO,
                VProductoValoracionPromedio::RUTA_IMAGEN,
                VProductoValoracionPromedio::VALORACION_PROMEDIO
            ], 10, [
                TypeOrder::ASC => VProductoValoracionPromedio::PRECIO
            ]),
            'productosPorValoracion' => VProductoValoracionPromedio::all([
                VProductoValoracionPromedio::ID,
                VProductoValoracionPromedio::NOMBRE,
                VProductoValoracionPromedio::PRECIO,
                VProductoValoracionPromedio::RUTA_IMAGEN,
                VProductoValoracionPromedio::VALORACION_PROMEDIO
            ], 10, [
                TypeOrder::DESC => VProductoValoracionPromedio::VALORACION_PROMEDIO
            ])
        ]);
    }

    public static function login(Router $router) {
        $router -> render('market/pages/login', [
            'css' => '<link rel="stylesheet" href="/assets/css/market/auth.css">',
            'js' => '<script src="/assets/js/app/pages/market/auth/auth.js" defer type="module"></script>'
        ]);
    }

    public static function product(Router $router) {
        $productId = $_GET['id'];
        if (!filter_var($productId, FILTER_VALIDATE_INT) || $productId < 1) {
            header('Location: /');
        }
        $ultimoIdProducto = Producto::last([Producto::ID]) -> id;
        if ($productId > $ultimoIdProducto) {
            header('Location: /');
        }

        $isAuthenticated = AuthHelper::isAuthenticated(RoleAccess::CUSTOMER);
        $router -> render('market/pages/product', [
            'css' => self::getCssImports() . '<link rel="stylesheet" href="/assets/css/market/product.css">',
            'js' => self::getJsImports() . '<script src="/assets/js/app/pages/market/product.js" type="module" defer></script>',
            'puedeComentar' => $isAuthenticated
                ? VComentarioClienteProducto::customerHasCommentedInProduct($productId)
                : null,
            'cliente' => $isAuthenticated
                ? Cliente::findOne($_SESSION['id'], [Cliente::NOMBRE, Cliente::APELLIDOS, Cliente::RUTA_IMAGEN_PERFIL])
                : null,
            'producto' => VProductoValoracionPromedio::findOne($productId, [
                VProductoValoracionPromedio::NOMBRE,
                VProductoValoracionPromedio::DESCRIPCION,
                VProductoValoracionPromedio::RUTA_IMAGEN,
                VProductoValoracionPromedio::PRECIO,
                VProductoValoracionPromedio::MARCA,
                VProductoValoracionPromedio::VALORACION_PROMEDIO
            ]),
            'comentarios' => VComentarioClienteProducto::find($productId, [
                VComentarioClienteProducto::NOMBRE_CLIENTE,
                VComentarioClienteProducto::APELLIDOS_CLIENTE,
                VComentarioClienteProducto::RUTA_IMAGEN_PERFIL,
                VComentarioClienteProducto::COMENTARIO,
                VComentarioClienteProducto::NUM_ESTRELLAS
            ]),
            ...self::loadNav()
        ]);
    }

    public static function profile(Router $router) {
        $router -> render('market/pages/profile', [
            'css' => self::getCssImports() . '<link rel="stylesheet" href="/assets/css/market/profile.css">',
            'js' => self::getJsImports() . '<script src="/assets/js/app/pages/market/profile.js" type="module" defer></script>',
            'cliente' => Cliente::findOne($_SESSION['id'], [
                Cliente::NOMBRE,
                Cliente::APELLIDOS,
                Cliente::TELEFONO,
                Cliente::CORREO,
                Cliente::RUTA_IMAGEN_PERFIL
            ]),
            ...self::loadNav(),
        ]);
    }

    public static function orders(Router $router) {
        $router -> render('market/pages/orders', [
            'css' => self::getCssImports() . '<link rel="stylesheet" href="/assets/css/market/orders.css">',
            'js' => self::getJsImports(),
            'pedidosCliente' => VPedidoProductoItemDetallado::find($_SESSION['id'], [
                VPedidoProductoItemDetallado::PEDIDO_ID,
                VPedidoProductoItemDetallado::CLIENTE_ID,
                VPedidoProductoItemDetallado::PRODUCTO_ID,
                VPedidoProductoItemDetallado::NOMBRE_PRODUCTO,
                VPedidoProductoItemDetallado::CANTIDAD_PRODUCTO,
                VPedidoProductoItemDetallado::PRECIO_PRODUCTO,
                VPedidoProductoItemDetallado::RUTA_IMAGEN
            ]),
            ...self::loadNav()
        ]);
    }

    public static function checkout(Router $router) {
        $hasCartItems = count(CarritoItem::find($_SESSION['id'], [CarritoItem::PRODUCTO_ID])) > 0;
        // Si no tiene productos en el carrito, volver a la página principal
        if (!$hasCartItems) {
            header('Location: /');
        }

        $router -> render('market/pages/checkout', [
            'css' => self::getCssImports() . '<link rel="stylesheet" href="/assets/css/market/checkout.css">',
            'js' => self::getJsImports() . '<script src="/assets/js/market/checkout.js" defer type="module"></script>',
            'cartItems' => VCarritoCliente::find($_SESSION['id'], [
                VCarritoCliente::NOMBRE_PRODUCTO,
                VCarritoCliente::PRECIO_PRODUCTO,
                VCarritoCliente::CANTIDAD,
                VCarritoCliente::RUTA_IMAGEN_PRODUCTO
            ]),
            ...self::loadNav()
        ]);
    }

    public static function getCssImports(): string {
        return '<link rel="stylesheet" href="/assets/css/market/market.css">' . (AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)
            ? '<link rel="stylesheet" href="/assets/css/market/chat.css">' : '');
    }

    public static function getJsImports(): string {
        $js = '<script src="/assets/js/app/pages/market/search-bar.js" type="module" defer></script>
        <script src="/assets/js/app/pages/market/cart.js" type="module" defer></script>';
        if (AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
            $js .= '<script src="/assets/js/app/pages/close-session.js" type="module" defer></script>
                    <script src="/assets/js/app/pages/market/chat/open-close.js" type="module" defer></script>
                    <script src="/assets/js/app/pages/market/chat/chat.js" type="module" defer></script>';
        }
        return $js;
    }

    private static function loadNav(): array {
        $isAuthenticated = AuthHelper::isAuthenticated(RoleAccess::CUSTOMER);
        $customerId = $isAuthenticated ? $_SESSION['id'] : 0;
        $infoClienteNav = $isAuthenticated ? Cliente::findOne($customerId, [
            Cliente::NOMBRE,
            Cliente::APELLIDOS,
            Cliente::RUTA_IMAGEN_PERFIL
        ]) : null;
        $carritoItems = $isAuthenticated ? VCarritoCliente::find($customerId, [
            VCarritoCliente::PRODUCTO_ID,
            VCarritoCliente::NOMBRE_PRODUCTO,
            VCarritoCliente::PRECIO_PRODUCTO,
            VCarritoCliente::RUTA_IMAGEN_PRODUCTO,
            VCarritoCliente::CANTIDAD
        ]) : null;
        return [
            'isAuthenticated' => $isAuthenticated,
            'infoClienteNav' => $infoClienteNav,
            'carritoItems' => $carritoItems,
            'numCarritoItems' => $carritoItems ? count($carritoItems) : null,
        ];
    }
}