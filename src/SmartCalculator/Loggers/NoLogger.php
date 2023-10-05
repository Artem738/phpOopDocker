<?php

namespace App\SmartCalculator\Loggers;

use App\SmartCalculator\Interfaces\ILoggerInterface;

class NoLogger implements ILoggerInterface
{

    public function log(string $message)
    {
        // Нічого не робим
    }
}