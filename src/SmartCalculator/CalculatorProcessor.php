<?php

namespace App\SmartCalculator;

use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\Interfaces\ICalculatorProcessor;


class CalculatorProcessor implements ICalculatorProcessor
{
    public function __construct(
        protected array $operations,
    ) {
    }

    public function calculate(string $operation, $number1, $number2): int|float
    {
        if (!isset($this->operations[$operation])) {
            throw new \InvalidArgumentException(
                "Unknown operation: $operation. Supported operations: " .
                ECalcOperations::allToString() . PHP_EOL
            );
        }

        return $this->operations[$operation]->execute($number1, $number2);
    }

}


