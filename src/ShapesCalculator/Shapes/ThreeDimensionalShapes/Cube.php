<?php

namespace ShapesСalculator\Shapes\ThreeDimensionalShapes;

use ShapesСalculator\Shapes\ThreeDimensionalShapes\AbstractShapes\RectangularTreeDimensionalShape;

class Cube extends RectangularTreeDimensionalShape
{
    public function __construct(protected float $sideLength)
    {
        parent::__construct($sideLength, $sideLength, $sideLength);
    }

    public function getShapeInfo(): string
    {
        return "Куб зі стороною {$this->sideLength}";
    }
}