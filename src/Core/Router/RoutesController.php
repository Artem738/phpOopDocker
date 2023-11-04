<?php

namespace App\Core\Router;

use App\Core\Di\Container;

class RoutesController
{
    protected array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function dispatch(RouteResultDTO $routeResult)
    {
        $uri = $routeResult->uri;

        foreach ($this->routes as $pattern => $controllerName) {
            //echo ($pattern .' - '. $uri. '<br>');
            if (preg_match($pattern, $uri)) {

                $controller = new $controllerName();
                $controller->handle($routeResult);
                return;
            }
        }

        echo "404: Не може існувати";
    }
}

