<?php

namespace App\SmartCalculator\Interfaces;

interface ICalcOperation
{
    public function execute($number1, $number2): int|float;
}