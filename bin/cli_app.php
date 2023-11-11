<?php


use App\CLI\Controllers\CalcCliController;
use App\SmartCalculator\CalculatorProcessor;
use App\SmartCalculator\Enums\ECalcOperations;
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


$operations = [
    ECalcOperations::ADD->value =>       new AddOperation(),
    ECalcOperations::SUBTRACT->value =>  new SubtractOperation(),
    ECalcOperations::MULTIPLY->value =>  new MultiplyOperation(),
    ECalcOperations::DIVIDE->value =>    new DivideOperation(),
];

$resultHandler = new CliResultHandler(new CliNotifier(), new FileLogger($_ENV['WORKDIR'].$_ENV['CLI_LOG_PATH']));
$cliController = new CalcCliController(new CalculatorProcessor($operations), $resultHandler);

// use InteractiveCommandHandler later...

$cliController->handle($argv);