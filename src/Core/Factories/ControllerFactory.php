<?php

namespace App\Core\Factories;

use App\Core\IAllControllersInterface;
use App\Core\Reflector\ClassReflector;
use App\HTTP\Controllers\AdminController;
use App\HTTP\Controllers\CalcWebController;
use App\HTTP\Controllers\ParsController;
use App\HTTP\Controllers\ShortUrlController;
use App\HTTP\Controllers\ShortUrlIndexController;
use App\SmartCalculator\CalculatorProcessor;
use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\Loggers\FileLogger;
use App\SmartCalculator\Notifiers\WebNotifier;
use App\SmartCalculator\Operations\AddOperation;
use App\SmartCalculator\Operations\DivideOperation;
use App\SmartCalculator\Operations\MultiplyOperation;
use App\SmartCalculator\Operations\SubtractOperation;
use App\SmartCalculator\ResultHandlers\WebResultHandler;
use ReflectionClass;

class ControllerFactory
{
    public function __construct(
        protected ?ClassReflector $reflector,
    ) {
    }

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function createController(string $controllerName, bool $performReflection = false): IAllControllersInterface
    {

        switch ($controllerName) {
            case CalcWebController::class:
                $operations = [
                    ECalcOperations::ADD->value => new AddOperation(),
                    ECalcOperations::SUBTRACT->value => new SubtractOperation(),
                    ECalcOperations::MULTIPLY->value => new MultiplyOperation(),
                    ECalcOperations::DIVIDE->value => new DivideOperation(),
                ];
                $calculatorProcessor = new CalculatorProcessor($operations);
                $resultHandler = new WebResultHandler(new WebNotifier(), new FileLogger($_ENV['WORKDIR'] . $_ENV['WEB_LOG_PATH']));
                $controller = new CalcWebController($calculatorProcessor, $resultHandler);
                break;
            case AdminController::class:
                $controller = new AdminController();
                break;
            case ParsController::class:
                $controller = new ParsController();
                break;
            case ShortUrlController::class:
                $controller = new ShortUrlController();
                break;
            case ShortUrlIndexController::class:
                $controller = new ShortUrlIndexController();
                break;

            default:
                throw new \Exception("Контроллер '$controllerName' не знайдено.");
        }

        if ($this->reflector != null && $performReflection) {
            $this->reflector->reflectClasses();
        }

        return $controller;
    }





}
