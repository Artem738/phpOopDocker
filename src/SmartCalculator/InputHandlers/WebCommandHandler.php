<?php
namespace App\SmartCalculator\InputHandlers;

use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\Interfaces\ICalculatorProcessor;
use App\SmartCalculator\Interfaces\InputInterface;

class WebCommandHandler implements InputInterface
{
    public function __construct(
        protected ICalculatorProcessor $processor,
    ) {
    }

    public function handle(array $uriParts)
    {
        // Проверка, чтобы первый элемент массива был "calc"
        if ($uriParts[0] !== 'calc') {
            echo "Невідомий URL. Тут можна добавити всі доступні операції, втч urlShortener.";
            die();
        }

        array_shift($uriParts); // Убираем "calc"

        if (count($uriParts) < 3) {
            echo "Використання: /calc/<operation>/<number1>/<number2><br>";
            echo "Доступные операции: " . ECalcOperations::allToString() . "<br>";
            die();
        }

        $operation = $uriParts[0];
        $number1 = $uriParts[1];
        $number2 = $uriParts[2];

        // Проверка на лишние числа
        if (count($uriParts) > 3) {
            echo "Внимание: обнаружено лишнее число. Оно будет проигнорировано.<br>";
        }

        try {
            return $this->processor->calculate($operation, $number1, $number2);
        } catch (\Exception $e) {
            // Здесь можно добавить логирование ошибки
            echo "Помилка калькулятора: " . $e->getMessage() . "<br>";
            die();
        }
    }
}
