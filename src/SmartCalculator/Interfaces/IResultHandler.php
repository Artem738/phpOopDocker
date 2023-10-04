<?php

namespace App\SmartCalculator\Interfaces;


interface IResultHandler
{
    public function handle(string $operation, $result): void;
}