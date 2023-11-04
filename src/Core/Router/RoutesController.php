<?php

namespace App\Core\Router;

use App\Core\Di\Container;

class RoutesController
{
    public function __construct(
        protected array $routes,
    ) {
    }

    public function dispatch(RouteResult $routeResult)
    {
        $route = $routeResult->uriParts[0] ?? null;

        if (isset($this->routes[$route])) {
            $controllerName = $this->routes[$route];
            $controller = new $controllerName();
            $controller->handle($routeResult);
        } else {
            echo "404: Не найдено";
        }
    }
}
