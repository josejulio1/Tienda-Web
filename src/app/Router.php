<?php
namespace Core;

use Util\API\HttpStatusCode;

/**
 * Clase que se encarga de enrutar una ruta con un controlador, para que cuando se acceda
 * a través de una API REST o el navegador a una parte de la página, se llame a un controlador.
 * Los controladores son los que definen la lógica de la aplicación, indicando qué hay que hacer cuando
 * se llama a una ruta registrada y a la vez dependiendo del tipo de método HTTP usado.
 *
 * El enrutador principalmente registra tres tipos de llamadas HTTP:
 * - GET: Se utiliza para obtener un recurso.
 * - POST: Se utiliza para enviar datos a un controlador y que este realice una operación con estos datos. Usado solo con la API REST.
 * - DELETE: Se utiliza para eliminar un recurso de la base de datos, a través de la URL (GET). Usado solo con la API REST.
 * @author josejulio1
 * @version 1.0
 */
class Router {
    private array $routesGet = [];
    private array $routesPost = [];
    private array $routesDelete = [];
    private array $mapRoutes;
    private array $allowedEmptyPostRoutes;

    /**
     * Construye un enrutador asignado un array que mapea cada método HTTP con su respectivo array
     */
    public function __construct() {
        $this -> mapRoutes = [
            'GET' => $this -> routesGet,
            'POST' => $this -> routesPost,
            'DELETE' => $this -> routesDelete
        ];
    }

    /**
     * Registra una ruta de método HTTP de tipo GET.
     * @param string $route Ruta que registrar
     * @param array $controller Controlador que asignar al llamar a la ruta
     * @param callable|null $validator Validación que aplicar antes de utilizar un controlador. Por ejemplo, si el usuario no tiene sesión, que no pueda acceder a un recurso
     * @return void
     */
    public function get(string $route, array $controller, ?callable $validator = null): void {
        $this -> routesGet[$route] = [
            'controller' => $controller,
            'validator' => $validator
        ];
        $this -> mapRoutes['GET'][$route] = [
            'controller' => $controller,
            'validator' => $validator
        ];
    }

    /**
     * Registra una ruta de método HTTP de tipo POST.
     * @param string $route Ruta que registrar
     * @param array $controller Controlador que asignar al llamar a la ruta
     * @param callable|null $validator Validación que aplicar antes de utilizar un controlador. Por ejemplo, si el usuario no tiene sesión, que no pueda acceder a un recurso
     * @param bool $allowEmpty Indica si se pueden enviar datos vacíos a esta ruta, es decir, si la superglobal $_POST está vacía. True si se permite vacía y false si no
     * @return void
     */
    public function post(string $route, array $controller, ?callable $validator = null, bool $allowEmpty = false): void {
        $this -> routesPost[$route] = [
            'controller' => $controller,
            'validator' => $validator
        ];
        $this -> mapRoutes['POST'][$route] = [
            'controller' => $controller,
            'validator' => $validator
        ];
        if ($allowEmpty) {
            $this -> allowedEmptyPostRoutes[] = $route;
        }
    }

    /**
     * Registra una ruta de método HTTP de tipo DELETE.
     * @param string $route Ruta que registrar
     * @param array $controller Controlador que asignar al llamar a la ruta
     * @param callable|null $validator Validación que aplicar antes de utilizar un controlador. Por ejemplo, si el usuario no tiene sesión, que no pueda acceder a un recurso
     * @return void
     */
    public function delete(string $route, array $controller, ?callable $validator = null) {
        $this -> routesDelete[$route] = [
            'controller' => $controller,
            'validator' => $validator
        ];
        $this -> mapRoutes['DELETE'][$route] = [
            'controller' => $controller,
            'validator' => $validator
        ];
    }

    /**
     * Escucha la ruta usada por el navegador y ejecuta el controlador de la ruta en caso de que exista.
     * @return bool|int|void
     */
    public function listenRoute() {
        $route = $_SERVER['PATH_INFO'] ?? '/';
        $usedMethod = $_SERVER['REQUEST_METHOD'];

        $mapRoutes = $this -> mapRoutes;
        // En caso de que la ruta tenga un validador, ejecutarlo antes
        if (array_key_exists($route, $mapRoutes[$usedMethod]) && $mapRoutes[$usedMethod][$route]['validator']) {
            // En caso de que el validador devuelva un número, será un código de estado HTTP, ya que los únicos validadores que
            // devolverán números son los de API
            $statusCode = $mapRoutes[$usedMethod][$route]['validator']();
            if ($statusCode && $statusCode !== HttpStatusCode::OK) {
                return http_response_code($statusCode);
            }
        }

        // Si se han enviado datos y la superglobal $_POST está vacía, es incorrecto porque $_POST
        // siempre debe tener datos (excepto rutas que estén en el array $allowedEmptyPostRoutes)
        if ($usedMethod === 'POST' && !$_POST && !in_array($route, $this -> allowedEmptyPostRoutes)) {
            return http_response_code(HttpStatusCode::INCORRECT_DATA);
        }

        // Si existe la ruta, coger el controlador, si no, devolver un código de respuesta 404
        if (array_key_exists($route, $this -> mapRoutes[$usedMethod])) {
            $this -> mapRoutes[$usedMethod][$route]['controller']($this); // Pasar como parámetro al método del controlador llamado el Router, para que el controlador pueda renderizar una vista
        } else {
            return http_response_code(HttpStatusCode::NOT_FOUND);
        }
    }

    /**
     * Renderiza una vista en el navegador.
     * @param string $viewPath Ruta absoluta de la vista
     * @param array $data Datos que se quieran pasar a la vista. Debe ser un array asociativo con clave-valor, y la clave será el nombre
     * de la variable que se usará en la vista. Por ejemplo, si se pasa por parámetro [ 'cliente' => 'Mi Cliente' ], en la vista que se
     * envíe este parámetro se podrá realizar "echo $cliente" y el resultado será "Mi Cliente"
     * @return void
     */
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