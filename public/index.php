<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router\WebUrlRouter;
use App\Core\Router\WebRouterValidator;
use App\Core\Router\RoutesController;
use App\SmartCalculator\CalculatorProcessor;
use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\InputHandlers\WebCommandHandler;
use App\SmartCalculator\Loggers\FileLogger;
use App\SmartCalculator\Notifiers\WebNotifier;
use App\SmartCalculator\Operations\AddOperation;
use App\SmartCalculator\Operations\DivideOperation;
use App\SmartCalculator\Operations\MultiplyOperation;
use App\SmartCalculator\Operations\SubtractOperation;
use App\SmartCalculator\ResultHandlers\WebResultHandler;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// calc
$operations = [
    ECalcOperations::ADD->value =>       new AddOperation(),
    ECalcOperations::SUBTRACT->value =>  new SubtractOperation(),
    ECalcOperations::MULTIPLY->value =>  new MultiplyOperation(),
    ECalcOperations::MULTI->value =>     new MultiplyOperation(),
    ECalcOperations::DIVIDE->value =>    new DivideOperation(),
];
$resultHandler = new WebResultHandler(new WebNotifier(), new FileLogger($_ENV['WORKDIR'].$_ENV['WEB_LOG_PATH']));
$commandHandler = new WebCommandHandler(new CalculatorProcessor($resultHandler, $operations));


$routes = require_once __DIR__ . '/../routes/web.php';
$controller = new RoutesController($routes, $commandHandler);
$webRouter = new WebUrlRouter(new WebRouterValidator());
try {
    $routeData = $webRouter->route();
    $controller->dispatch($routeData);
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
    echo "Помилка: " . $e->getMessage() . PHP_EOL;
}
