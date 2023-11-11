<?php

use App\SmartCalculator\CalculatorProcessor;
use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\Enums\EGreetings;
use App\SmartCalculator\InputHandlers\CliCommandHandler;
use App\SmartCalculator\Loggers\FileLogger;
use App\SmartCalculator\Notifiers\CliNotifier;
use App\SmartCalculator\Operations\AddOperation;
use App\SmartCalculator\Operations\DivideOperation;
use App\SmartCalculator\Operations\MultiplyOperation;
use App\SmartCalculator\Operations\SubtractOperation;
use App\SmartCalculator\ResultHandlers\CliResultHandler;


require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

echo EGreetings::bigAppNameCli->value;

// Реалізація

$logger = new FileLogger($_ENV['WORKDIR'].$_ENV['WEB_LOG_PATH']);
$notifier = new CliNotifier();

$resultHandler = new CliResultHandler($notifier, $logger);

$operations = [
    ECalcOperations::ADD->value => new AddOperation(),
    ECalcOperations::SUBTRACT->value => new SubtractOperation(),
    ECalcOperations::MULTIPLY->value => new MultiplyOperation(),
    ECalcOperations::DIVIDE->value => new DivideOperation(),
];

$calculatorProcessor = new CalculatorProcessor($resultHandler, $operations);

$commandHandler = new CliCommandHandler($calculatorProcessor);
$commandHandler->handle($argv);

exit();


































//$container = new Container();
//$configurator = new ContainerConfigurator();
//
//$configurator->setInputHandler($container, EInputTypes::CLI);
//$configurator->setLogger($container, ELogerTypes::FILE);
//$configurator->setNotifier($container, ENotifiersTypes::TELEGRAM);
//$configurator->setBasicCalculatorOperations($container);
//$configurator->setResultViewHandler($container, EResultViewTypes::WEB);
//
//
//
//
//try {
//    $processor = $container->get(InputInterface::class);
//    $processor->handle($argv);
//} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
//    echo "Error: " . $e->getMessage() . PHP_EOL;
//}


