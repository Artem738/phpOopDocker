<?php

namespace App\SmartCalculator\InputHandlers;

use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\Interfaces\ICalculatorProcessor;
use App\SmartCalculator\Interfaces\IInputInterface;





class CliCommandHandler implements IInputInterface
{
    public function __construct(
        protected ICalculatorProcessor  $processor,
    ) {
    }

    public function handle(array $args)
    {
        if (count($args) < 4) {
            echo("  Usage: {$args[0]} <operation> <number1> <number2>" . PHP_EOL .
                "  Доступні операції: " . ECalcOperations::allToString() . PHP_EOL);
            exit();
        }

        $operation = $args[1];
        $number1 = $args[2];
        $number2 = $args[3];

        return $this->processor->calculate($operation, $number1, $number2);
    }
}
