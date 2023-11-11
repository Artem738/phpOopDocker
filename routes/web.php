<?php

use App\HTTP\Controllers\AdminController;
use App\HTTP\Controllers\ParsController;
use App\HTTP\Controllers\ShortUrlController;
use App\SmartCalculator\CalculatorProcessor;
use App\SmartCalculator\Enums\ECalcOperations;


return [
    '/^\/calc\/('.ECalcOperations::allToStringVertBar().')\/\d+\/\d+$/' => CalculatorProcessor::class,

    '/^short-url\/([a-zA-Z0-9]+)$/' => ShortUrlController::class,

    '/^\/admin$/' => AdminController::class,
    '/^\/pars$/' => ParsController::class,
];