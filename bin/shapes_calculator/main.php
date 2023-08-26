<?php


require_once 'Validators/MathValidator.php';
require_once 'Validators/MyValidator.php';
require_once 'Interfaces/ShapeInterface.php';
require_once 'Shapes/TwoDimensionalShapes/Circle.php';
require_once 'Shapes/TwoDimensionalShapes/AbstractShapes/FourSquareShape.php';
require_once 'Shapes/TwoDimensionalShapes/Square.php';
require_once 'Shapes/TwoDimensionalShapes/Rectangle.php';
require_once 'Shapes/TwoDimensionalShapes/Triangle.php';
require_once 'Interfaces/ThreeDimensionalShapeInterface.php';
require_once 'Shapes/ThreeDimensionalShapes/AbstractShapes/TreeDimensionalShape.php';
require_once 'Shapes/ThreeDimensionalShapes/AbstractShapes/RectangularTreeDimensionalShape.php';
require_once 'Shapes/ThreeDimensionalShapes/Cuboid.php';
require_once 'Shapes/ThreeDimensionalShapes/Cube.php';
require_once 'Shapes/ThreeDimensionalShapes/Cone.php';

use ShapesСalculator\Interfaces\ShapeInterface;
use ShapesСalculator\Interfaces\ThreeDimensionalShapeInterface;
use ShapesСalculator\Shapes\ThreeDimensionalShapes\Cone;
use ShapesСalculator\Shapes\ThreeDimensionalShapes\Cube;
use ShapesСalculator\Shapes\ThreeDimensionalShapes\Cuboid;
use ShapesСalculator\Shapes\TwoDimensionalShapes\Circle;
use ShapesСalculator\Shapes\TwoDimensionalShapes\Rectangle;
use ShapesСalculator\Shapes\TwoDimensionalShapes\Square;
use ShapesСalculator\Shapes\TwoDimensionalShapes\Triangle;

function twoDimensionalCalculation(ShapeInterface $shape): void
{
    echo $shape->getShapeInfo() . PHP_EOL;
    echo "Площа = " . $shape->calculateArea() . PHP_EOL;
    echo PHP_EOL;
}

function threeDimensionalCalculation(ThreeDimensionalShapeInterface $shape): void
{
    echo $shape->getShapeInfo() . PHP_EOL;
    echo "Об'єм = " . $shape->calculateVolume() . PHP_EOL;
    echo PHP_EOL;
}

function main(): void
{
    twoDimensionalCalculation(new Circle(42));
    twoDimensionalCalculation(new Triangle(30, 40));
    twoDimensionalCalculation(new Rectangle(10, 20));
    twoDimensionalCalculation(new Square(20));

    threeDimensionalCalculation(new Cuboid(10, 10, 10));
    threeDimensionalCalculation(new Cube(20));
    threeDimensionalCalculation(new Cone(10, 10));
}

main();

//test repo