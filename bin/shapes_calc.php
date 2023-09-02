<?php

use ShapesСalculator\Interfaces\ShapeInterface;
use ShapesСalculator\Interfaces\ThreeDimensionalShapeInterface;
use ShapesСalculator\Shapes\ThreeDimensionalShapes\Cone;
use ShapesСalculator\Shapes\ThreeDimensionalShapes\Cube;
use ShapesСalculator\Shapes\ThreeDimensionalShapes\Cuboid;
use ShapesСalculator\Shapes\TwoDimensionalShapes\Circle;
use ShapesСalculator\Shapes\TwoDimensionalShapes\Rectangle;
use ShapesСalculator\Shapes\TwoDimensionalShapes\Square;
use ShapesСalculator\Shapes\TwoDimensionalShapes\Triangle;

require_once __DIR__ . '/../vendor/autoload.php';
$loader = new Nette\Loaders\RobotLoader;
$loader->addDirectory(__DIR__ . '/../src'); // путь к вашим классам
$loader->setTempDirectory(__DIR__ . '/../temp/robot_loader'); // путь к временной директории
$loader->register();

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