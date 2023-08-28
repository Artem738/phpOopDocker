<?php

namespace ShapesСalculator\Shapes\TwoDimensionalShapes\AbstractShapes;

use ShapesСalculator\Interfaces\ShapeInterface;
use ShapesСalculator\Validators\MyValidator;

abstract class FourSquareShape extends MyValidator implements ShapeInterface
{
    // Робимо FourSquareShape абстрактним, так ми зобовъяжемо дочірні класи довиконита привла закладені у інтерфейсі Shape.
    public function __construct(
        protected float $length,
        protected float $width
    ) {
        $this->validateInputDataArray("FourSquareShape", [$length, $width]);
    }

    public function calculateArea(): float
    {
        return $this->length * $this->width;
    }

}
