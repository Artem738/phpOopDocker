<?php

namespace App\SmartCalculator\Notifiers;

use App\SmartCalculator\Interfaces\INotifierInterface;

class CliINotifier implements INotifierInterface
{
    public function send(string $message): void
    {
        echo $message . PHP_EOL;
    }
}