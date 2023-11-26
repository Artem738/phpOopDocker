<?php

namespace App\Core;
use App\Core\Router\RouteResultDTO;

interface IAllControllersInterface
{
    public function handle(RouteResultDTO $routeResult): void;
}