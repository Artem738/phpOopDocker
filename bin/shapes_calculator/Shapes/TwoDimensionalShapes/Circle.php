<?php

namespace ShapesСalculator\Shapes\TwoDimensionalShapes;

use ShapesСalculator\Interfaces\ShapeInterface;
use ShapesСalculator\Validators\MyValidator;

class Circle extends MyValidator implements ShapeInterface
{
    public function __construct(
        protected float $radius
    ) {
        $this->validateInputDataArray("Circle", [$radius]);
    }

    public function getShapeInfo(): string
    {
        return "Радіус: " . $this->radius;
    }

    public function calculateArea(): float
    {
        return M_PI * $this->radius * $this->radius;
    }
}