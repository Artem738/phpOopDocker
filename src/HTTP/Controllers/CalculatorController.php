<?php

namespace App\HTTP\Controllers;

use App\Core\Router\RouteResultDTO;
use App\SmartCalculator\Interfaces\IInputInterface;

class CalculatorController
{

    public function __construct(
        protected IInputInterface $commandHandler,
    ) {
    }

    public function handle(RouteResultDTO $routeResult): void
    {
        $this->commandHandler->handle($routeResult->uriParts);
    }
}


