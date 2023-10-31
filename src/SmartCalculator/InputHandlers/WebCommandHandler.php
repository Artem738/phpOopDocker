<?php

namespace App\SmartCalculator\InputHandlers;

use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\Enums\EGreetings;
use App\SmartCalculator\Interfaces\ICalculatorProcessor;
use App\SmartCalculator\Interfaces\InputInterface;

class WebCommandHandler implements InputInterface
{
    public function __construct(
        protected ICalculatorProcessor $processor,
    ) {
    }


    public function handle(array $args)
    {
        echo EGreetings::bigAppNameWeb->value; //H1
        // test on "calc"
        if ($args[0] !== 'calc') {
            echo "Помилка реалізації: Невідомий URL";
            die();
        }

        array_shift($args); // remove "calc"

        if (count($args) < 3) {
            echo 'Використання: /calc/operation/number1/number2 <br>';
            echo "Доступні операції: " . ECalcOperations::allToString() . "<br>";
            die();
        }

        $operation = $args[0];
        $number1 = $args[1];
        $number2 = $args[2];

        // Проверка на лишние числа
        if (count($args) > 3) {
            echo "Увага: виявлено зайве число. Воно буде проігноровано.<br>";
        }

        try {
            return $this->processor->calculate($operation, $number1, $number2);
        } catch (\Exception $e) {
            echo "Помилка калькулятора: " . $e->getMessage() . "<br>";
            die();
        }
    }
}
