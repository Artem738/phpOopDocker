<?php

namespace ShapesСalculator\Interfaces;

interface ShapeInterface
{
    public function getShapeInfo(): string;

    public function calculateArea(): float;

}