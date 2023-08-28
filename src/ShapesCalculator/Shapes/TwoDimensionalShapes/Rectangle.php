<?php

namespace ShapesСalculator\Shapes\TwoDimensionalShapes;

use ShapesСalculator\Shapes\TwoDimensionalShapes\AbstractShapes\FourSquareShape;

class Rectangle extends FourSquareShape
{
    public function getShapeInfo(): string
    {
        return "Прямокутник із шириною {$this->length} і висотою {$this->width}";
    }
}