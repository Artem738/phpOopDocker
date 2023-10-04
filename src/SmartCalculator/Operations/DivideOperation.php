<?php

namespace App\SmartCalculator\Operations;

use App\SmartCalculator\Interfaces\ICalcOperation;

class DivideOperation implements ICalcOperation {
    public function execute($number1, $number2): int|float {
        if ($number2 == 0) {
            throw new \InvalidArgumentException("Cannot divide by zero.");
        }
        return $number1 / $number2;
    }
}