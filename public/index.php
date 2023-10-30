<?php

use App\Core\Di\Container;
use App\Core\Router\WebRouterValidator;
use App\Core\Router\WebUrlRouter;
use App\SmartCalculator\ContainerConfigurator;
use App\SmartCalculator\Enums\EGreetings;
use App\SmartCalculator\Enums\EInputTypes;
use App\SmartCalculator\Enums\ELogerTypes;
use App\SmartCalculator\Enums\ENotifiersTypes;
use App\SmartCalculator\Interfaces\InputInterface;
use App\SmartCalculator\Notifiers\TelegramNotifier;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;


require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$webRouter = new WebUrlRouter(new WebRouterValidator());

echo EGreetings::bigAppNameWeb->value;

// Реалізація

$container = new Container();
$configurator = new ContainerConfigurator();

$configurator->setInputHandler($container, EInputTypes::WEB); // Изменено на WEB
$configurator->setLogger($container, ELogerTypes::NO);
$configurator->setNotifier($container, ENotifiersTypes::WEB);
$configurator->setBasicCalculatorOperations($container);
$configurator->setResultHandler($container);



try {
    // URI
    $routeData = $webRouter->route();
    $uriParts = $routeData['uriParts'] ?? [];

    $processor = $container->get(InputInterface::class);
    $processor->handle($uriParts); //  $argv
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
    echo "Помилка: " . $e->getMessage() . PHP_EOL;
}

exit();


