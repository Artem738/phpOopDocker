<?php

namespace App\Core\Router;

use App\Core\Factories\ControllerFactory;
use ReflectionClass;

class RoutesController
{

    /**
     * @param array<string> $routes
     */
    public function __construct(
        protected array             $routes,
        protected ControllerFactory $factory,
    ) {
    }

    public function dispatch(RouteResultDTO $routeResult):void
    {
        $uri = $routeResult->uri;

        foreach ($this->routes as $pattern => $controllerName) {
            if (preg_match($pattern, $uri)) {
                $controller = $this->factory->createController($controllerName, (bool)$routeResult->reflection);
                $controller->handle($routeResult);
                exit(); // end
            }
        }

        echo "404: Не може існувати";
    }
}