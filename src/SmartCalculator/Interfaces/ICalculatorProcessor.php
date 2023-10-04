<?php

namespace App\SmartCalculator\Interfaces;

interface ICalculatorProcessor
{
    public function calculate(string $operation, $number1, $number2): int|float;
}