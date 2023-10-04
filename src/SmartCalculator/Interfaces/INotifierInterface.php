<?php

namespace App\SmartCalculator\Interfaces;
interface INotifierInterface
{
    public function send(string $message);
}
