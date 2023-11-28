<?php

namespace App\Core\Factories;

use App\Core\IAllControllersInterface;
use App\Core\Reflector\ClassReflector;
use Exception;
use ReflectionClass;

class ControllerFactory
{
    public function __construct(
        protected ?ClassReflector $reflector,
    ) {
    }

    /**
     * @throws \ReflectionException
     * @throws Exception
     */
    public function createController(string $controllerName, bool $performReflection = false): IAllControllersInterface
    {
        $functionName = 'create' . (new ReflectionClass($controllerName))->getShortName();

        if (function_exists($functionName)) {
            $controller = $functionName();
        } else {
            throw new Exception("<br> Функція для створення контролера >>> '$controllerName' <<< не знайдена. <br>");
        }

        if ($this->reflector && $performReflection) {
            $this->reflector->reflectClasses();
        }

        return $controller;
    }
}
