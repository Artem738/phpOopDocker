<?php

require_once __DIR__ . '/../vendor/autoload.php';


use App\Core\Factories\ControllerFactory;
use App\Core\Router\RoutesController;
use App\Core\Router\WebRouterValidator;
use App\Core\Router\WebUrlRouter;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();


$routes = require_once __DIR__ . '/../routes/web.php';
$factory = new ControllerFactory();
$webRouter = new WebUrlRouter(new WebRouterValidator());

try {
    $routeData = $webRouter->route();
    $controller = new RoutesController($routes, $factory);
    $controller->dispatch($routeData);
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
    echo "Помилка: " . $e->getMessage() . PHP_EOL;
}