<?php

namespace ShapesСalculator\Shapes\ThreeDimensionalShapes;

use ShapesСalculator\Shapes\ThreeDimensionalShapes\AbstractShapes\TreeDimensionalShape;
use ShapesСalculator\Shapes\TwoDimensionalShapes\Circle;

class Cone extends TreeDimensionalShape
{
    protected Circle $circle;

    public function __construct(
        protected float $radius,
        protected float $height
    ) {
        $this->validateInputDataArray("Cone", [$radius, $height]);
        $this->circle = new Circle($radius);
    }

    public function getShapeInfo(): string
    {
        return "Конус з радіусом {$this->radius} і висотою {$this->height}";
    }

    public function calculateVolume(): float
    {
        return (1 / 3) * $this->circle->calculateArea() * $this->height;
    }
}