<?php

namespace App\Core\Router;

use App\Core\Di\Container;

class RoutesController
{
    protected $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function dispatch(array $uriParts)
    {
        $route = $uriParts[0] ?? null;

        if (isset($this->routes[$route])) {
            $controllerName = 'App\\HTTP\\Controllers\\' . $this->routes[$route];
            $controller = new $controllerName();
            //array_shift($uriParts);
            $controller->handle($uriParts);
        } else {

            echo "404: Не знайдено";
        }
    }
}