<?php

namespace App\Core\Router;

use App\Core\IAllControllersInterface;
use ReflectionClass;

class RoutesController
{

    public function __construct(
        protected array                    $routes,
        protected IAllControllersInterface $commandHandler
    ) {
       // $this->reflect("App\\");
    }


    /**
     * @throws \ReflectionException
     */
    private function reflect(string $namespaceName): void
    {
        $classes = get_declared_classes();

        foreach ($classes as $class) {
            if (strpos($class, $namespaceName) === 0) {
                // Создание ReflectionClass для каждого класса
                $reflector = new ReflectionClass($class);

                // Вывод информации о классе
                echo "Клас: " . $class . "<br>";
                echo "Файл: " . $reflector->getFileName() . "<br>";
                echo "Методы:" . "<br>";

                // Получение и вывод информации о методах класса
                foreach ($reflector->getMethods() as $method) {
                    echo " - " . $method->name . "<br>";
                }

                echo "<br>";
            }
        }

        die();
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