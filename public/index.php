<?php

use App\Core\Router\RoutesController;
use App\Core\Router\WebRouterValidator;
use App\Core\Router\WebUrlRouter;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;


require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');  //Доробити...
$dotenv->load();


$webRouter = new WebUrlRouter(new WebRouterValidator());

$routes = require_once __DIR__ . '/../routes/web.php';  //  routes

$controller = new RoutesController($routes);

try {

    $routeData = $webRouter->route();
    $controller->dispatch($routeData);

} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
    echo "Помилка: " . $e->getMessage() . PHP_EOL;
}
