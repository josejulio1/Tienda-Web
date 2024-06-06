<?php
namespace Core;

use Util\API\AdminHelper;
use Util\API\HttpErrorMessages;
use Util\API\HttpStatusCode;
use Util\API\Response;
use Util\Auth\AuthHelper;
use Util\Auth\RoleAccess;

class Router {
    private array $mapMethodToArray;
    private array $routesGet = [];
    private array $routesPost = [];
    private array $routesPut = [];
    private array $routesDelete = [];

    private array $restrictedCustomerRoutesGet;
    private array $restrictedCustomerRoutesPostApi;

    private array $restrictedUserRoutesGet;
    private array $restrictedUserRoutesGetApi;
    private array $restrictedUserRoutesPostApi;
    private array $restrictedUserRoutesPutApi;
    private array $restrictedUserRoutesDeleteApi;
    private array $allRestrictedRoutes;
    private array $allRestrictedCustomerRoutesApi;
    private array $allRestrictedUserRoutesApi;

    public function __construct() {
        $this -> prepareCustomerRoutes();
        $this -> prepareCustomerRoutesApi();

        $this -> prepareUserRoutes();
        $this -> prepareUserRoutesApi();

        // All Routes
        $this -> allRestrictedRoutes = [
            $this -> restrictedCustomerRoutesGet,
            $this -> restrictedUserRoutesGet
        ];

        // All Routes - API
        $this -> allRestrictedCustomerRoutesApi = [
            'POST' => $this -> restrictedCustomerRoutesPostApi
        ];

        $this -> allRestrictedUserRoutesApi = [
            'GET' => $this -> restrictedUserRoutesGetApi,
            'POST' => $this -> restrictedUserRoutesPostApi,
            'PUT' => $this -> restrictedUserRoutesPutApi,
            'DELETE' => $this -> restrictedUserRoutesDeleteApi
        ];

        $this -> mapMethodToArray = [
            'GET' => $this -> routesGet,
            'POST' => $this -> routesPost,
            'PUT' => $this -> routesPut,
            'DELETE' => $this -> routesDelete
        ];
    }

    public function get(string $route, array $controller) {
        $this -> routesGet[$route] = $controller;
        $this -> mapMethodToArray['GET'][$route] = $controller;
    }

    public function post(string $route, array $controller) {
        $this -> routesPost[$route] = $controller;
        $this -> mapMethodToArray['POST'][$route] = $controller;
    }

    public function put(string $route, array $controller) {
        $this -> routesPut[$route] = $controller;
        $this -> mapMethodToArray['PUT'][$route] = $controller;
    }

    public function delete(string $route, array $controller) {
        $this -> routesDelete[$route] = $controller;
        $this -> mapMethodToArray['DELETE'][$route] = $controller;
    }

    public function listenRoute() {
        $route = $_SERVER['PATH_INFO'] ?? '/';
        $usedMethod = $_SERVER['REQUEST_METHOD'];

        // Validar si la ruta introducida es restringida, y en caso de que lo sea, aplicar su respectiva validación
        $restrictedRoutes = $this -> allRestrictedRoutes;
        foreach ($restrictedRoutes as $restrictedRoute) {
            if (array_key_exists($route, $restrictedRoute)) {
                call_user_func($restrictedRoute[$route]);
                /*$statusCode = call_user_func($restrictedRoute[$route]) ?? null; // Si es una función de API, que devuelve un código de estado, devolver estado HTTP
                if ($statusCode && $statusCode !== HttpStatusCode::OK) {
                    return http_response_code($statusCode);
                }*/
                break;
            }
        }

        // Validar API - Cliente
        $allRestrictedCustomerRoutesApi = $this -> allRestrictedCustomerRoutesApi;
        foreach ($allRestrictedCustomerRoutesApi as $method => $restrictedCustomerRoutesApi) {
            if (array_key_exists($route, $restrictedCustomerRoutesApi)) {
                if ($usedMethod !== $method) {
                    return http_response_code(HttpStatusCode::METHOD_NOT_ALLOWED);
                }
                $statusCode = call_user_func($restrictedCustomerRoutesApi[$route]);
                if ($statusCode !== HttpStatusCode::OK) {
                    return http_response_code($statusCode);
                }
            }
        }

        // Validar API - Admin
        $allRestrictedUserRoutesApi = $this -> allRestrictedUserRoutesApi;
        foreach ($allRestrictedUserRoutesApi as $method => $restrictedUserRouteApi) {
            if ($restrictedUserRouteApi === $route) {
                if ($usedMethod !== $method) {
                    return http_response_code(AdminHelper::validateAuth($method));
                }
            }
        }

        $controller = null;
        // Si existe la ruta, coger el controlador, si no, devolver un código de respuesta 404
        if (array_key_exists($route, $this -> mapMethodToArray[$usedMethod])) {
            $controller = $this -> mapMethodToArray[$usedMethod][$route];
        } else {
            return http_response_code(HttpStatusCode::NOT_FOUND);
        }
        call_user_func($controller, $this); // Pasar como parámetro al método del controlador llamado el Router, para que el controlador pueda renderizar una vista
    }

    public function render(string $viewPath, array $data = []) {
        // Establecer todas las variables del controlador en memoria para pasárselas a la vista
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        // Iniciar buffer en el servidor, para que las vistas que se cargarán no se muestren todavía en el navegador, ya que antes se quiere
        // crear la variable contenido
        ob_start();
        // Cargar la vista respectiva de la URL introducida en el buffer
        require_once __DIR__ . "/views/$viewPath.php";
        $contenido = ob_get_clean(); // Guardar en la variable contenido todo lo que contiene el buffer, que es la vista cargada, y limpiar el buffer
        // Cargar el layout con el contenido de la variable $contenido listo para ser mostrado en el navegador
        require_once __DIR__ . '/views/templates/layout.php';
    }

    private function prepareCustomerRoutes() {
        $this -> restrictedCustomerRoutesGet = [
            '/' => function () {
                if (AuthHelper::isAuthenticated(RoleAccess::USER)) {
                    header('Location: /admin/user');
                }
            },
            '/login' => function () {
                if (AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
                    header('Location: /');
                }
            },
            '/profile' => function () {
                if (!AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
                    header('Location: /');
                }
            },
            '/orders' => function () {
                if (!AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
                    header('Location: /');
                }
            },
            '/checkout' => function () {
                if (!AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
                    header('Location: /');
                }
            }
        ];
    }

    private function prepareCustomerRoutesApi() {
        $this -> restrictedCustomerRoutesPostApi = [
            '/api/customer/login' => function (): int {
                if (AuthHelper::isAuthenticated()) {
                    return HttpStatusCode::UNAUTHORIZED;
                }
                return HttpStatusCode::OK;
            },
            '/api/save-profile' => function (): int {
                if (!AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
                    return HttpStatusCode::UNAUTHORIZED;
                }
                return HttpStatusCode::OK;
            }
        ];
    }

    private function prepareUserRoutes() {
        $this -> restrictedUserRoutesGet = [
            '/admin/user' => function () {
                if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
                    header('Location: /admin');
                }
            },
            '/admin/product' => function () {
                if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
                    header('Location: /admin');
                }
            },
            '/admin/brand' => function () {
                if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
                    header('Location: /admin');
                }
            },
            '/admin/category' => function () {
                if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
                    header('Location: /admin');
                }
            },
            '/admin/customer' => function () {
                if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
                    header('Location: /admin');
                }
            },
            '/admin/role' => function () {
                if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
                    header('Location: /admin');
                }
            },
            '/admin' => function () {
                if (AuthHelper::isAuthenticated(RoleAccess::USER)) {
                    header('Location: /admin/user');
                }
                if (AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
                    header('Location: /');
                }
            },
            '/admin/login' => function () {
                if (AuthHelper::isAuthenticated(RoleAccess::USER)) {
                    header('Location: /admin/user');
                }
                if (AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
                    header('Location: /');
                }
            }
        ];
    }

    private function prepareUserRoutesApi() {
        $this -> restrictedUserRoutesGetApi = [
            '/api/users' => function (): int {
                return AdminHelper::validateAuth('GET');
            },
            '/api/products' => function (): int {
                return AdminHelper::validateAuth('GET');
            },
            '/api/brands' => function (): int {
                return AdminHelper::validateAuth('GET');
            },
            '/api/categories' => function (): int {
                return AdminHelper::validateAuth('GET');
            },
            '/api/customers' => function (): int {
                return AdminHelper::validateAuth('GET');
            },
            '/api/roles' => function (): int {
                return AdminHelper::validateAuth('GET');
            }
        ];

        $this -> restrictedUserRoutesPostApi = [];

        $this -> restrictedUserRoutesPutApi = [
            '/api/user',
            '/api/product',
            '/api/brand',
            '/api/category',
            '/api/customer',
            '/api/role'
        ];

        $this -> restrictedUserRoutesDeleteApi = [
            '/api/user',
            '/api/product',
            '/api/brand',
            '/api/category',
            '/api/customer',
            '/api/role'
        ];
    }
}