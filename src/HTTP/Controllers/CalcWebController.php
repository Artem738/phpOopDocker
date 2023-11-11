<?php

namespace App\HTTP\Controllers;

use App\Core\IAllControllersInterface;
use App\Core\IResultHandlerInterface;
use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\Enums\EGreetings;
use App\SmartCalculator\Interfaces\ICalculatorProcessor;

class CalcWebController implements IAllControllersInterface
{
    public function __construct(
        protected ICalculatorProcessor    $controller,
        protected IResultHandlerInterface $resultHandler,
    ) {
    }

    public function handle(array $args): void
    {
        echo EGreetings::bigAppNameWeb->value; //H1

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

        // Зайві числа
        if (count($args) > 3) {
            echo "Увага: виявлено зайве число. Воно буде проігноровано.<br>";
        }

        try {
            $result = $this->controller->calculate($operation, $number1, $number2);
            $this->resultHandler->handle($operation, $result); // Обработка результату
            echo "Результат операції: " . $result;
        } catch (\Exception $e) {
            echo "Помилка калькулятора: " . $e->getMessage() . "<br>";
            die();
        }
    }
}
