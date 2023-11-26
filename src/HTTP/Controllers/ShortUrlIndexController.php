<?php

namespace App\HTTP\Controllers;

use App\Core\IAllControllersInterface;
use App\Core\Router\RouteResultDTO;

class ShortUrlIndexController implements IAllControllersInterface
{
    public function handle(RouteResultDTO $routeResult): void
    {

        echo("Short Url. Index Part - ". $routeResult->uriParts[0] . ' </br>');



    }
}
