<?php

use App\HTTP\Controllers\AdminController;
use App\HTTP\Controllers\CalculatorController;
use App\HTTP\Controllers\ShortUrlController;
 /// WEB ROUTES/
///
return [
    'calc' => CalculatorController::class,
    'short-url' => ShortUrlController::class,
    'admin' => AdminController::class,
];



//
//return [
//    '/^calc\/(\d+)$/' => CalculatorController::class,
//
//    '/^short-url\/([a-zA-Z0-9]+)$/' => ShortUrlController::class,
//
//    '/^admin\/?$/' => AdminController::class,
//];