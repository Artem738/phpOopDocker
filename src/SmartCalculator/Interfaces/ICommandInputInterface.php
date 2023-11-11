<?php

namespace App\SmartCalculator\Interfaces;

interface ICommandInputInterface
{
    public function handle(array $args): void;
}