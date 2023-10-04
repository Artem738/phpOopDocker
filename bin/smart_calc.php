<?php

use App\SmartCalculator\CalculatorProcessor;
use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\Enums\EGreetings;
use App\SmartCalculator\InputHandlers\CliCommandHandler;
use App\SmartCalculator\Loggers\FileLogger;
use App\SmartCalculator\Notifiers\CliINotifier;
use App\SmartCalculator\Operations\AddOperation;
use App\SmartCalculator\Operations\DivideOperation;
use App\SmartCalculator\Operations\MultiplyOperation;
use App\SmartCalculator\Operations\SubtractOperation;
use App\SmartCalculator\ResultHandlers\ResultHandler;


require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

echo EGreetings::bigAppName->value;

$logger = new FileLogger($_ENV['LOG_PATH']);
$notifier = new CliINotifier();

$resultHandler = new ResultHandler($notifier, $logger);

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

