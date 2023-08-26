<?php

namespace ShapesСalculator\Validators;


use InvalidArgumentException;

class MyValidator extends MathValidator
{
    public function validateInputDataArray(string $shapeName, array $data): void
    {
        foreach ($data as $val) {
            if ($this->isNegative($val)) {
                $errorMessage = PHP_EOL . " Помилка виникла у файлі -" . __FILE__ . PHP_EOL
                    . " Для калькуляції площі або об'єму у класі " . $shapeName
                    . ", розміри не мають бути від'ємними" . PHP_EOL;
                throw new InvalidArgumentException($errorMessage);
            }
        }
    }
}