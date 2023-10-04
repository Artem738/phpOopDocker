<?php

namespace App\SmartCalculator\Interfaces;
interface ICalculatorInterface
{
    // поки навчання, спеціально не встановлюємо int чи float
    public function add($a, $b);

    public function multiply($a, $b);

    public function subtract($a, $b);

    public function divide($a, $b);
}