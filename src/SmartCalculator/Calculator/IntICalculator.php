<?php

namespace App\SmartCalculator\Calculator;

use App\SmartCalculator\Interfaces\ICalculatorInterface;

class IntICalculator implements ICalculatorInterface
{
    public function add($a, $b): int
    {
        return $a + $b;
    }

    public function multiply($a, $b): int
    {
        return $a * $b;
    }

    public function subtract($a, $b): int
    {
        return $a - $b;
    }

    public function divide($a, $b): int
    {
        if ($b == 0) {
            throw new \InvalidArgumentException("Division by zero is not allowed.");
        }
        return intdiv($a, $b);  // використовуємо intdiv для цілочисельного ділення
    }
}