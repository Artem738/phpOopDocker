<?php

namespace App\Core\Router;

use App\HTTP\IControllerInterface;

class RoutesController
{

    public function __construct(
        protected array           $routes,
        protected IControllerInterface $commandHandler
    ) {
    }

    public function dispatch(RouteResultDTO $routeResult)
    {
        $uri = $routeResult->uri;

        foreach ($this->routes as $pattern => $controllerName) {
            if (preg_match($pattern, $uri)) {

                $this->commandHandler->handle($routeResult->uriParts);
                return;
            }
        }

        echo "404: Не може існувати";
    }
}