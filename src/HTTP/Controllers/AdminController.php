<?php

namespace App\HTTP\Controllers;

use App\Core\Router\RouteResultDTO;

class AdminController
{
    public function handle(RouteResultDTO $routeResult): void
    {

        echo("Admin part under construction - ". $routeResult->uriParts[0] . ' </br>');
        echo(urlencode('https://www.espressoenglish.net/the-100-most-common-words-in-english/') . ' </br>');
        echo(urlencode('<li >') . ' </br>');
        echo(urlencode('</li >') . ' </br>');


    }
}
