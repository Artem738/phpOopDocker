<?php

namespace App\SmartCalculator;

use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\Interfaces\ICalculatorProcessor;
use App\SmartCalculator\Interfaces\IResultHandler;

class CalculatorProcessor implements ICalculatorProcessor
{
    protected array $operations = [];
    protected IResultHandler $resultHandler;

    public function __construct(
        IResultHandler $resultHandler,
        array $operations
    ) {
        $this->resultHandler = $resultHandler;
        $this->operations = $operations;
    }

    public function calculate(string $operation, $number1, $number2): int|float {
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
