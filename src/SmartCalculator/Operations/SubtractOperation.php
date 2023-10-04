<?php

namespace App\SmartCalculator\Operations;

use App\SmartCalculator\Interfaces\ICalcOperation;

class SubtractOperation implements ICalcOperation {
    public function execute($number1, $number2): int|float {
        return $number1 - $number2;
    }
}