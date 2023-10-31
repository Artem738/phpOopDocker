<?php

namespace App\HTTP\Controllers;

use App\Core\Di\Container;
use App\SmartCalculator\ContainerConfigurator;
use App\SmartCalculator\Enums\EInputTypes;
use App\SmartCalculator\Enums\ELogerTypes;
use App\SmartCalculator\Enums\ENotifiersTypes;
use App\SmartCalculator\Enums\EResultViewTypes;
use App\SmartCalculator\Interfaces\InputInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CalculatorController
{
    public function handle(array $uriParts)
    {
        $container = new Container();
        $configurator = new ContainerConfigurator();

        $configurator->setInputHandler($container, EInputTypes::WEB);
        $configurator->setLogger($container, ELogerTypes::NO);
        $configurator->setNotifier($container, ENotifiersTypes::WEB);
        $configurator->setBasicCalculatorOperations($container);
        $configurator->setResultViewHandler($container, EResultViewTypes::WEB);

        try {
            $processor = $container->get(InputInterface::class);
            $processor->handle($uriParts);
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            echo "Помилка: " . $e->getMessage() . PHP_EOL;
        }

    }
}
