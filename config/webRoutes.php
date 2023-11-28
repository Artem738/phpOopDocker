<?php

use App\HTTP\Controllers\AdminController;
use App\HTTP\Controllers\CalcWebController;
use App\HTTP\Controllers\ParsController;
use App\HTTP\Controllers\ShortUrlController;
use App\HTTP\Controllers\ShortUrlIndexController;
use App\SmartCalculator\Enums\ECalcOperations;


return [
    '/^\/calc\/('.ECalcOperations::allToStringVertBar().')\/\d+\/\d+$/' => CalcWebController::class,

    '/^\/short-url\/?$/'=> ShortUrlIndexController::class,
    '/^\/short-url\/([a-zA-Z0-9]+)$/'=> ShortUrlController::class,

    '/^\/admin\/?$/' => AdminController::class,
    '/^\/pars$/' => ParsController::class,
];