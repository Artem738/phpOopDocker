<?php

namespace App\SmartCalculator;

use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\Interfaces\ICalculatorProcessor;
use App\SmartCalculator\Interfaces\IResultHandler;

class CalculatorProcessor implements ICalculatorProcessor
{

    public function __construct(
        protected IResultHandler $resultHandler,
        protected array          $operations = []
    ) {
    }

    public function calculate(string $operation, $number1, $number2): int|float
    {
        if (!isset($this->operations[$operation])) {
            throw new \InvalidArgumentException(
                PHP_EOL . "Unknown operation: $operation. 
            Supported operations: " . ECalcOperations::allToString() . PHP_EOL
            );
        }

        $result = $this->operations[$operation]->execute($number1, $number2);

        $this->resultHandler->handle($operation, $result);

        return $result;
    }
}
