<?php

use App\HTTP\Controllers\AdminController;
use App\HTTP\Controllers\CalcWebController;
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


function createCalcWebController()
{
    $operations = [
        ECalcOperations::ADD->value => new AddOperation(),
        ECalcOperations::SUBTRACT->value => new SubtractOperation(),
        ECalcOperations::MULTIPLY->value => new MultiplyOperation(),
        ECalcOperations::DIVIDE->value => new DivideOperation(),
    ];
    $calculatorProcessor = new CalculatorProcessor($operations);
    $resultHandler = new WebResultHandler(new WebNotifier(), new FileLogger($_ENV['WORKDIR'] . $_ENV['WEB_LOG_PATH']));
    return new CalcWebController($calculatorProcessor, $resultHandler);
}

function createAdminController()
{

    return new AdminController();
}

function createShortUrlController()
{

    return new ShortUrlController();
}
function createShortUrlIndexController()
{

    return new ShortUrlIndexController();
}

