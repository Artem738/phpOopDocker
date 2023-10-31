<?php

use App\Core\Router\RoutesController;
use App\Core\Router\WebRouterValidator;
use App\Core\Router\WebUrlRouter;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;


require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$webRouter = new WebUrlRouter(new WebRouterValidator());

$routes = require_once __DIR__ . '/../routes/web.php';  //  routes

$controllerDispatcher = new RoutesController($routes);

try {
    $routeData = $webRouter->route();
    $uriParts = $routeData['uriParts'] ?? [];

    $controllerDispatcher->dispatch($uriParts);
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
    echo "Помилка: " . $e->getMessage() . PHP_EOL;
}


























//// Реалізація
//
//$container = new Container();
//$configurator = new ContainerConfigurator();
//
//$configurator->setInputHandler($container, EInputTypes::WEB); // Изменено на WEB
//$configurator->setLogger($container, ELogerTypes::NO);
//$configurator->setNotifier($container, ENotifiersTypes::WEB);
//$configurator->setBasicCalculatorOperations($container);
//$configurator->setResultViewHandler($container, EResultViewTypes::WEB);
//
//
//
//try {
//    // URI
//    $routeData = $webRouter->route();
//    $uriParts = $routeData['uriParts'] ?? [];
//
//    $processor = $container->get(InputInterface::class);
//    $processor->handle($uriParts); //  $argv
//} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
//    echo "Помилка: " . $e->getMessage() . PHP_EOL;
//}
//
//exit();
//
//
