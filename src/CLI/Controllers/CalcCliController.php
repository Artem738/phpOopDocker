<?php

namespace App\CLI\Controllers;

use App\Core\IAllControllersInterface;
use App\Core\IResultHandlerInterface;
use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\Enums\EGreetings;
use App\SmartCalculator\Interfaces\ICalculatorProcessor;

class CalcCliController implements IAllControllersInterface
{
    public function __construct(
        protected ICalculatorProcessor $calculatorProcessor,
        protected IResultHandlerInterface $resultHandler
    ) {
    }

    public function handle(array $args): void
    {
        echo EGreetings::bigAppNameCli->value;

        if (count($args) < 4) {
            echo "Використання: <operation> <number1> <number2>" . PHP_EOL;
            echo "Доступні операції: " . ECalcOperations::allToString() . PHP_EOL;
            exit();
        }

        $operation = $args[1];
        $number1 = (float)$args[2];
        $number2 = (float)$args[3];

        try {
            $result = $this->calculatorProcessor->calculate($operation, $number1, $number2);
            $this->resultHandler->handle($operation, $result);
            echo "Результат: " . $result . PHP_EOL;
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . PHP_EOL;
            exit();
        }
    }
}
