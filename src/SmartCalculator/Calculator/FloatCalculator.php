<?php

namespace App\SmartCalculator\Calculator;

use App\SmartCalculator\Interfaces\ICalculatorInterface;

class FloatCalculator implements ICalculatorInterface
{
    public function add($a, $b): float
    {
        return $a + $b;
    }

    public function multiply($a, $b): float
    {
        return $a * $b;
    }

    public function subtract($a, $b): float
    {
        return $a - $b;
    }

    public function divide($a, $b): float
    {
        if ($b == 0) {
            throw new \InvalidArgumentException(PHP_EOL . "  Division by zero is not allowed." . PHP_EOL);
        }
        return ($a / $b);
    }
}