<?php
namespace Controller;

use Core\Router;
use Model\Categoria;
use Model\Marca;
use Model\Rol;
use Model\VUsuarioRol;
use Util\API\HttpStatusCode;
use Util\Auth\AuthHelper;
use Util\Auth\RoleAccess;
use Util\Permission\Permissions;

class AdminController {
    public static function index(Router $router) {
        $userInfo = self::getUserInfo();
        if (($userInfo -> permiso_usuario & Permissions::READ) === Permissions::NO_PERMISSIONS) {
            return http_response_code(HttpStatusCode::UNAUTHORIZED);
        }

        $router -> render('admin/pages/user', [
            'css' => self::getCssImports(),
            'js' => self::getJsImports() . '<script src="/assets/js/app/pages/admin/sections/user/user.js" type="module" defer></script>',
            'userInfo' => $userInfo,
            'roles' => Rol::all([
                Rol::ID,
                Rol::NOMBRE,
                Rol::COLOR
            ])
        ]);
    }

    public static function product(Router $router) {
        $userInfo = self::getUserInfo();
        if (($userInfo -> permiso_producto & Permissions::READ) === Permissions::NO_PERMISSIONS) {
            return http_response_code(HttpStatusCode::UNAUTHORIZED);
        }

        $router -> render('admin/pages/product', [
            'css' => self::getCssImports(),
            'js' => self::getJsImports() . '<script src="/assets/js/app/pages/admin/sections/product/product.js" type="module" defer></script>',
            'userInfo' => self::getUserInfo(),
            'marcas' => Marca::all([Marca::ID, Marca::MARCA]),
            'categorias' => Categoria::all([Categoria::ID, Categoria::NOMBRE])
        ]);
    }

    public static function brand(Router $router) {
        $userInfo = self::getUserInfo();
        if (($userInfo -> permiso_marca & Permissions::READ) === Permissions::NO_PERMISSIONS) {
            return http_response_code(HttpStatusCode::UNAUTHORIZED);
        }

        $router -> render('admin/pages/brand', [
            'css' => self::getCssImports(),
            'js' => self::getJsImports() . '<script src="/assets/js/app/pages/admin/sections/brand/brand.js" type="module" defer></script>',
            'userInfo' => self::getUserInfo()
        ]);
    }

    public static function category(Router $router) {
        $userInfo = self::getUserInfo();
        if (($userInfo -> permiso_categoria & Permissions::READ) === Permissions::NO_PERMISSIONS) {
            return http_response_code(HttpStatusCode::UNAUTHORIZED);
        }

        $router -> render('admin/pages/category', [
            'css' => self::getCssImports(),
            'js' => self::getJsImports() . '<script src="/assets/js/app/pages/admin/sections/category/category.js" type="module" defer></script>',
            'userInfo' => self::getUserInfo()
        ]);
    }

    public static function customer(Router $router) {
        $userInfo = self::getUserInfo();
        if (($userInfo -> permiso_cliente & Permissions::READ) === Permissions::NO_PERMISSIONS) {
            return http_response_code(HttpStatusCode::UNAUTHORIZED);
        }

        $router -> render('admin/pages/customer', [
            'css' => self::getCssImports(),
            'js' => self::getJsImports() . '<script src="/assets/js/app/pages/admin/sections/customer/customer.js" type="module" defer></script>',
            'userInfo' => self::getUserInfo()
        ]);
    }

    public static function role(Router $router) {
        $userInfo = self::getUserInfo();
        if (($userInfo -> permiso_rol & Permissions::READ) === Permissions::NO_PERMISSIONS) {
            return http_response_code(HttpStatusCode::UNAUTHORIZED);
        }

        $router -> render('admin/pages/role', [
            'css' => self::getCssImports(),
            'js' => self::getJsImports() . '<script src="/assets/js/app/pages/admin/sections/role/role.js" type="module" defer></script>',
            'userInfo' => self::getUserInfo()
        ]);
    }

    public static function login(Router $router) {
        if (AuthHelper::isAuthenticated(RoleAccess::USER)) {
            header('Location: /admin/user');
        }
        if (AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
            header('Location: /');
        }

        $css = '<link rel="stylesheet" href="/assets/css/admin/auth.css">';
        $js = '<script src="/assets/js/app/pages/admin/auth/auth.js" type="module" defer></script>';

        $router -> render('admin/pages/auth', [
            'css' => $css,
            'js' => $js
        ]);
    }

    private static function getUserInfo(): VUsuarioRol {
        return VUsuarioRol::find($_SESSION['id'], [
            VUsuarioRol::USUARIO,
            VUsuarioRol::NOMBRE_ROL,
            VUsuarioRol::RUTA_IMAGEN_PERFIL,
            VUsuarioRol::PERMISO_CATEGORIA,
            VUsuarioRol::PERMISO_PRODUCTO,
            VUsuarioRol::PERMISO_MARCA,
            VUsuarioRol::PERMISO_CLIENTE,
            VUsuarioRol::PERMISO_USUARIO,
            VUsuarioRol::PERMISO_ROL
        ])[0];
    }

    private static function getCssImports() {
        return '<link rel="stylesheet" href="/assets/css/lib/bootstrap.min.css">
                <link rel="stylesheet" href="/assets/css/lib/jquery.dataTables.css">
                <link rel="stylesheet" href="/assets/css/admin/admin.css">
                <link rel="stylesheet" href="/assets/css/admin/modal.css">';
    }

    private static function getJsImports() {
        return '<script src="/assets/js/lib/bootstrap.bundle.min.js" defer></script>
                <script src="/assets/js/lib/jquery.dataTables.js" defer></script>
                <script src="/assets/js/app/pages/close-session.js" type="module" defer></script>
                <script src="/assets/js/app/pages/admin/responsive/open-close-panel.js" defer></script>
                <script src="/assets/js/app/pages/admin/general-settings.js" defer></script>';
    }
}