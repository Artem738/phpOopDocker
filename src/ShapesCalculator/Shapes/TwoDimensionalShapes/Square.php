<?php

namespace ShapesСalculator\Shapes\TwoDimensionalShapes;

use ShapesСalculator\Shapes\TwoDimensionalShapes\AbstractShapes\FourSquareShape;

class Square extends FourSquareShape
{
    public function __construct
    (
        protected float $sideLength
    ) {
        parent::__construct($sideLength, $sideLength);
    }

    public function getShapeInfo(): string
    {
        return "Квадрат зі стороною {$this->sideLength}";
    }
}