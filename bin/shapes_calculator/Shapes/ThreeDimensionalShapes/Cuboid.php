<?php

namespace ShapesСalculator\Shapes\ThreeDimensionalShapes;

use ShapesСalculator\Shapes\ThreeDimensionalShapes\AbstractShapes\RectangularTreeDimensionalShape;

class Cuboid extends RectangularTreeDimensionalShape
{
    public function getShapeInfo(): string
    {
        return "Паралелепіпед з довжиною {$this->length}, шириною {$this->width} і висотою {$this->height}";
    }
}