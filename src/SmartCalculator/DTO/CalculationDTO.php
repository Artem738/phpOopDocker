<?php

namespace App\SmartCalculator\DTO;

use App\SmartCalculator\Enums\ECalcOperations;

class CalculationDTO
{
    public string $operation;
    public int|float $number1;
    public int|float $number2;
    public int|float $result;
    public string $errorText;

    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getOperation(): string
    {
        return $this->operation;
    }

    /**
     * @param string $operation
     */
    public function setOperation(string $value): void
    {
        $operation = ECalcOperations::tryFrom($value);

        if ($operation === null) {
            throw new InvalidArgumentException("Помилка: $value");
        }

        $this->operation = $operation;
    }

    /**
     * @return float|int
     */
    public function getNumber1(): float|int
    {
        return $this->number1;
    }

    /**
     * @param float|int $number1
     */
    public function setNumber1(float|int $number1): void
    {
        $this->number1 = $number1;
    }

    /**
     * @return float|int
     */
    public function getNumber2(): float|int
    {
        return $this->number2;
    }

    /**
     * @param float|int $number2
     */
    public function setNumber2(float|int $number2): void
    {
        $this->number2 = $number2;
    }

    /**
     * @return float|int
     */
    public function getResult(): float|int
    {
        return $this->result;
    }

    /**
     * @param float|int $result
     */
    public function setResult(float|int $result): void
    {
        $this->result = $result;
    }

    /**
     * @return string
     */
    public function getErrorText(): string
    {
        return $this->errorText;
    }

    /**
     * @param string $errorText
     */
    public function setErrorText(string $errorText): void
    {
        $this->errorText = $errorText;
    }

}