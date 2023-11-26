<?php

namespace App\HTTP\Controllers;

use App\Core\IAllControllersInterface;
use App\Core\Router\RouteResultDTO;

class ShortUrlController implements IAllControllersInterface
{
    public function handle(RouteResultDTO $routeResult): void
    {

        echo("ShortUrl under construction");
    }
}
