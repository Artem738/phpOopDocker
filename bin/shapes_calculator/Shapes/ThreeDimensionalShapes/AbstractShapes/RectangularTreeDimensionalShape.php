<?php

namespace ShapesСalculator\Shapes\ThreeDimensionalShapes\AbstractShapes;

use ShapesСalculator\Shapes\TwoDimensionalShapes\Rectangle;

abstract class RectangularTreeDimensionalShape extends TreeDimensionalShape
{
    protected Rectangle $rectangle;

    public function __construct(
        protected float $length,
        protected float $width,
        protected float $height
    ) {
        $this->validateInputDataArray("RectangularTreeDimensionalShape", [$length, $width, $height]);
        $this->rectangle = new Rectangle($length, $width);
    }

    public function calculateVolume(): float
    {
        return $this->rectangle->calculateArea() * $this->height;
    }

}