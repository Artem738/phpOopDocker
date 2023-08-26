<?php

namespace ShapesСalculator\Shapes\TwoDimensionalShapes;

use ShapesСalculator\Interfaces\ShapeInterface;
use ShapesСalculator\Validators\MyValidator;

class Triangle extends MyValidator implements ShapeInterface
{
    public function __construct(
        protected float $base,
        protected float $height
    ) {
        $this->validateInputDataArray("Triangle", [$base, $height]);
    }

    public function getShapeInfo(): string
    {
        return "Трикутник із основою {$this->base} і висотою {$this->height}";
    }

    public function calculateArea(): float
    {
        return 0.5 * $this->base * $this->height;
    }

}