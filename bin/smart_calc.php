<?php

use App\Core\Di\Container;
use App\SmartCalculator\ContainerConfigurator;
use App\SmartCalculator\Enums\EGreetings;
use App\SmartCalculator\Enums\EInputTypes;
use App\SmartCalculator\Enums\ELogerTypes;
use App\SmartCalculator\Enums\ENotifiersTypes;
use App\SmartCalculator\Enums\EResultViewTypes;
use App\SmartCalculator\Interfaces\InputInterface;
use App\SmartCalculator\Notifiers\TelegramNotifier;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;


require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

echo EGreetings::bigAppNameCli->value;

// Реалізація

$container = new Container();
$configurator = new ContainerConfigurator();

$configurator->setInputHandler($container, EInputTypes::CLI);
$configurator->setLogger($container, ELogerTypes::FILE);
$configurator->setNotifier($container, ENotifiersTypes::TELEGRAM);
$configurator->setBasicCalculatorOperations($container);
$configurator->setResultViewHandler($container, EResultViewTypes::WEB);




try {
    $processor = $container->get(InputInterface::class);
    $processor->handle($argv);
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}


exit();






























//// Без контейнеру
///
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

