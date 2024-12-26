<?php

namespace Src\Core;

class Router
{
    private static array $routes = [];

    private static $container;

    /**
     * Define a GET route
     *
     * @param string $uri The URI for the route
     * @param array $controllerAction The controller and method to call for this route
     * @return void
     */
    public static function get(string $uri, array $controllerAction): void
    {
        static::$routes['GET'][$uri] = $controllerAction;
    }

    /**
     * Define a POST route
     *
     * @param string $uri The URI for the route
     * @param array $controllerAction The controller and method to call for this route
     * @return void
     */
    public static function post(string $uri, array $controllerAction): void
    {
        static::$routes['POST'][$uri] = $controllerAction;
    }

    /**
     * Define a PUT route
     *
     * @param string $uri The URI for the route
     * @param array $controllerAction The controller and method to call for this route
     * @return void
     */
    public static function put(string $uri, array $controllerAction): void
    {
        static::$routes['PUT'][$uri] = $controllerAction;
    }

    /**
     * Define a DELETE route
     *
     * @param string $uri The URI for the route
     * @param array $controllerAction The controller and method to call for this route
     * @return void
     */
    public static function delete(string $uri, array $controllerAction): void
    {
        static::$routes['DELETE'][$uri] = $controllerAction;
    }

    /**
     * Dispatch the request to the appropriate controller action
     *
     * @param string $requestUri The URI of the incoming request
     * @return void
     */
    /**
     * Dispatch the request to the appropriate controller action
     *
     * @param string $requestUri The URI of the incoming request
     * @return void
     */
    public static function dispatch(string $requestUri): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if (self::$container === null) {
            self::$container = require __DIR__ . '/../../bootstrap.php';
        }

        if (isset(self::$routes[$method])) {
            foreach (self::$routes[$method] as $route => $controllerAction) {
                $pattern = preg_replace('/\{(\w+)\}/', '(?P<\1>[^/]+)', $route);
                $pattern = '#^' . $pattern . '$#';

                if (preg_match($pattern, $requestUri, $matches)) {
                    [$controllerName, $actionName] = $controllerAction;

                    $controller = self::$container->resolve($controllerName);

                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                    if (method_exists($controller, $actionName)) {
                        $controller->{$actionName}(...array_values($params));
                    } elseif (method_exists($controller, '__invoke')) {
                        $controller($params);
                    } else {
                        throw new \Exception("Action {$actionName} not found in {$controllerName}");
                    }

                    return;
                }
            }
        }

        http_response_code(404);
        echo "Route not found: {$requestUri}";
    }

}
