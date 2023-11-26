<?php

namespace App\SmartCalculator;

use App\SmartCalculator\Enums\ECalcOperations;
use App\SmartCalculator\Interfaces\ICalculatorProcessor;

/**
 * Клас CalculatorProcessor здійснює обчислення за заданою операцією та числами.
 */
class CalculatorProcessor implements ICalculatorProcessor
{
    /**
     * Конструктор класу CalculatorProcessor.
     *
     * @param array $operations Асоціативний масив, де ключ - назва операції, значення - об'єкт операції.
     */
    public function __construct(
        protected array $operations,
    ) {
    }

    /**
     * Виконує обчислення за заданою операцією та числами.
     *
     * @param string $operation Назва операції.
     * @param mixed $number1 Перше число для обчислень.
     * @param mixed $number2 Друге число для обчислень.
     * @return int|float Результат обчислення.
     * @throws \InvalidArgumentException Якщо операція невідома.
     */
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


