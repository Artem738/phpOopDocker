<?php

namespace App\Core\Router;

use App\Core\Factories\ControllerFactory;
use ReflectionClass;

class RoutesController
{

    public function __construct(
        protected array             $routes,
        protected ControllerFactory $factory,
    ) {
    }

    public function dispatch(RouteResultDTO $routeResult)
    {
        $uri = $routeResult->uri;

        foreach ($this->routes as $pattern => $controllerName) {
            if (preg_match($pattern, $uri)) {
                $controller = $this->factory->createController($controllerName);
                $controller->handle($routeResult);
                return;
            }
        }

        echo "404: Не може існувати";
    }
}