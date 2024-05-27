<?php
namespace Core;

use Util\Auth\AuthHelper;
use Util\Auth\RoleAccess;

class Router {
    private array $routesGet = [];
    private array $routesPost = [];
    private array $routesPut = [];
    private array $routesDelete = [];
    private array $restrictedCustomerRoutesGet = [];
    private array $restrictedCustomerRoutesPost = [];
    private array $restrictedUserRoutesGet;
    private array $restrictedUserRoutesPost = [];

    public function __construct() {
        $this -> restrictedUserRoutesGet = [
            '/admin/user',
            '/admin/product',
            '/admin/brand',
            '/admin/category',
            '/admin/customer',
            '/admin/role',
        ];
    }

    public function get(string $route, array $controller) {
        $this -> routesGet[$route] = $controller;
    }
    
    public function post(string $route, array $controller) {
        $this -> routesPost[$route] = $controller;
    }

    public function put(string $route, array $controller) {
        $this -> routesPut[$route] = $controller;
    }

    public function delete(string $route, array $controller) {
        $this -> routesDelete[$route] = $controller;
    }

    public function listenRoute() {
        $route = $_SERVER['PATH_INFO'] ?? '/';
        $usedMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this -> restrictedUserRoutesGet as $routeGet) {
            if ($routeGet === $route) {
                if (AuthHelper::isAuthenticated(RoleAccess::CUSTOMER)) {
                    header('Location: /');
                }
                if (!AuthHelper::isAuthenticated(RoleAccess::USER)) {
                    header('Location: /admin/login');
                }
            }
        }

        $controller = null;
        if ($usedMethod === 'GET') {
            $controller = $this -> routesGet[$route];
        } else if ($usedMethod === 'POST') {
            $controller = $this -> routesPost[$route];
        } else if ($usedMethod === 'PUT') {
            $controller = $this -> routesPut[$route];
        } else if ($usedMethod === 'DELETE') {
            $controller = $this -> routesDelete[$route];
        }

        // Si el controlador existe, es porque la ruta está registrada
        if ($controller) {
            call_user_func($controller, $this); // Pasar como parámetro al método del controlador llamado el Router, para que el controlador pueda renderizar una vista
        } else {
            // En caso de que la ruta no exista, llevar a la página principal
            header('Location: /');
        }
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
}