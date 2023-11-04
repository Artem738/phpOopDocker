<?php

namespace App\HTTP\Controllers;

use App\Core\Di\Container;
use App\Core\Router\RouteResultDTO;
use App\SmartCalculator\CalculatorProcessor;
use App\SmartCalculator\ContainerConfigurator;
use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\Enums\EInputTypes;
use App\SmartCalculator\Enums\ELogerTypes;
use App\SmartCalculator\Enums\ENotifiersTypes;
use App\SmartCalculator\Enums\EResultViewTypes;
use App\SmartCalculator\InputHandlers\WebCommandHandler;
use App\SmartCalculator\Interfaces\InputInterface;
use App\SmartCalculator\Loggers\FileLogger;
use App\SmartCalculator\Notifiers\WebNotifier;
use App\SmartCalculator\Operations\AddOperation;
use App\SmartCalculator\Operations\DivideOperation;
use App\SmartCalculator\Operations\MultiplyOperation;
use App\SmartCalculator\Operations\SubtractOperation;
use App\SmartCalculator\ResultHandlers\WebResultHandler;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CalculatorController
{
    public function handle(RouteResultDTO $routeResult): void
    {

        // Без контейнеру

        $logger = new FileLogger($_ENV['WORKDIR'].$_ENV['WEB_LOG_PATH']);
        $notifier = new WebNotifier();

        $resultHandler = new WebResultHandler($notifier, $logger);

        $operations = [
            ECalcOperations::ADD->value => new AddOperation(),
            ECalcOperations::SUBTRACT->value => new SubtractOperation(),
            ECalcOperations::MULTIPLY->value => new MultiplyOperation(),
            ECalcOperations::DIVIDE->value => new DivideOperation(),
        ];

        $calculatorProcessor = new CalculatorProcessor($resultHandler, $operations);

        $commandHandler = new WebCommandHandler($calculatorProcessor);
        $commandHandler->handle($routeResult->uriParts);
//        $container = new Container();
//        $configurator = new ContainerConfigurator();
//
//        $configurator->setInputHandler($container, EInputTypes::WEB);
//        $configurator->setLogger($container, ELogerTypes::NO);
//        $configurator->setNotifier($container, ENotifiersTypes::WEB);
//        $configurator->setBasicCalculatorOperations($container);
//        $configurator->setResultViewHandler($container, EResultViewTypes::WEB);

//        try {
//            $processor = $container->get(InputInterface::class);
//            $processor->handle($routeResult->uriParts);
//        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
//            echo "Помилка: " . $e->getMessage() . PHP_EOL;
//        }

    }
}
