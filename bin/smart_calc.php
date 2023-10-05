<?php

use App\Core\Di\Container;
use App\SmartCalculator\ContainerConfigurator;
use App\SmartCalculator\Enums\EGreetings;
use App\SmartCalculator\Enums\EInputTypes;
use App\SmartCalculator\Interfaces\InputInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;


require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

echo EGreetings::bigAppName->value;

// Реализация

$container = new Container();
$configurator = new ContainerConfigurator();

$configurator->setLogger($container);
$configurator->setNotifier($container);
$configurator->bindProcessors($container);
$configurator->bindAdvancedServices($container);

$configurator->setInputHandler($container, EInputTypes::interactive);

// Реализация
try {
    $processor = $container->get(InputInterface::class);
    $processor->handle($argv);
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}


exit();

//$logger = new FileLogger($_ENV['LOG_PATH']);
//$notifier = new CliINotifier();
//
//$resultHandler = new ResultHandler($notifier, $logger);
//
//$operations = [
//    ECalcOperations::ADD->value => new AddOperation(),
//    ECalcOperations::SUBTRACT->value => new SubtractOperation(),
//    ECalcOperations::MULTIPLY->value => new MultiplyOperation(),
//    ECalcOperations::DIVIDE->value => new DivideOperation(),
//];
//
//$calculatorProcessor = new CalculatorProcessor($resultHandler, $operations);
//
//$commandHandler = new CliCommandHandler($calculatorProcessor);
//$commandHandler->handle($argv);
//
//exit();

