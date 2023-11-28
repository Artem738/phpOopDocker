<?php

namespace App\Core\Router;

use App\Core\Factories\ControllerFactory;
use ReflectionException;

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

    /**
     * @throws ReflectionException
     */
    public function dispatch(RouteResultDTO $routeResultDTO):void
    {
        $uri = $routeResultDTO->uri;

        foreach ($this->routes as $pattern => $controllerName) {
            if (preg_match($pattern, $uri)) {
                $controller = $this->factory->createController($controllerName, (bool)$routeResultDTO->reflection);
                $controller->handle($routeResultDTO);
                exit(); // end
            }
        }

        echo "404: Не може існувати";
    }
}