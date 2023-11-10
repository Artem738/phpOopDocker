<?php

namespace App\SmartCalculator\InputHandlers;

use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\Interfaces\ICalculatorProcessor;
use App\SmartCalculator\Interfaces\ICommandInputInterface;

class InteractiveCommandHandler implements ICommandInputInterface
{
    public function __construct(
        protected ICalculatorProcessor $processor,
    ) {
    }

    public function handle(array $args = []): float|int
    {
        $operation = $this->prompt("Введіть операцію (" . ECalcOperations::allToString() . "): ");
        $number1 = $this->prompt('Введіть перше число: ');
        $number2 = $this->prompt('Введіть друге число: ');

        return $this->processor->calculate($operation, $number1, $number2);
    }

    protected function prompt($message): string
    {
        echo $message;
        return trim(fgets(STDIN));
    }
}