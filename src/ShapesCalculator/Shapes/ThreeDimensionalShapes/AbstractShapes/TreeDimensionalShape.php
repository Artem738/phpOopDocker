<?php

namespace ShapesСalculator\Shapes\ThreeDimensionalShapes\AbstractShapes;

use InvalidArgumentException;
use ShapesСalculator\Interfaces\ThreeDimensionalShapeInterface;
use ShapesСalculator\Validators\MyValidator;

abstract class TreeDimensionalShape extends MyValidator implements ThreeDimensionalShapeInterface
{
    public function calculateArea(): float
    {
        throw new InvalidArgumentException(PHP_EOL . "Розрахунок площі не працює на 3D фігури!" . PHP_EOL);
    }
}