<?php

namespace ShapesСalculator\Validators;

class MathValidator
{
    public function isNegative(float $value): bool
    {
        return $value < 0;
    }
}