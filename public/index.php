<?php




use App\Core\Factories\ControllerFactory;
use App\Core\Reflector\ClassReflector;
use App\Core\Router\RoutesController;
use App\Core\Router\WebRouterValidator;
use App\Core\Router\WebUrlRouter;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/controllerDependencies.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$factory = new ControllerFactory(new ClassReflector());

$webRouter = new WebUrlRouter(new WebRouterValidator(),'reflect');
$routes = require_once __DIR__ . '/../config/webRoutes.php';

try {
    $routeData = $webRouter->route();
    $controller = new RoutesController($routes, $factory);
    $controller->dispatch($routeData);
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
    echo "Помилка: " . $e->getMessage() . PHP_EOL;
}