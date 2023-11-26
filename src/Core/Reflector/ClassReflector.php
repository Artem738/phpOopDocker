<?php

namespace App\Core\Reflector;

use ReflectionClass;
use ReflectionMethod;


class ClassReflector
{
    /**
     * @throws \ReflectionException
     */
    public function reflectClasses()
    {
        $classes = get_declared_classes();

        foreach ($classes as $class) {
           // if (str_starts_with($class, 'App\\') && !str_starts_with($class, 'App\\Core\\') && !str_starts_with($class, 'App\\HTTP\\')) {
           if (str_starts_with($class, 'App\\')) {
           // if (true) {
                $reflector = new ReflectionClass($class);
                echo "<div style='margin-left: 40px;'>";
                $this->printClassInfo($reflector);
                echo "</div>";

                echo "<div style='margin-left: 80px;'>";
                // Вывод методов класса по видимости
                $this->printMethodsInfo($reflector, ReflectionMethod::IS_PUBLIC, "Публічні методи", "blueviolet");
                $this->printMethodsInfo($reflector, ReflectionMethod::IS_PROTECTED, "Захищені методи", "blue");
                $this->printMethodsInfo($reflector, ReflectionMethod::IS_PRIVATE, "Приватні методи", "red");


                echo "</div><hr>";
            }
        }
    }

    private function printClassInfo($reflector)
    {
        echo "<strong>Клас:</strong> <a target='_blank' href='" . str_replace($_ENV['WORKDIR'], $_ENV['GITHUB_PATH'], $reflector->getFileName()) . "'>" . $reflector->getName() . "</a><br>";
        echo "<strong>Фаїл:</strong> " . $reflector->getFileName() . "<br>";

        if ($docComment = $reflector->getDocComment()) {
            echo "<span style='color: green;'><pre>" . htmlspecialchars($docComment) . "</pre></span><br>";
        }

        foreach ($reflector->getInterfaces() as $interface) {
            echo "<span style='color: mediumseagreen;'> Інтерфейс: - " . $interface->name . "</span><br>";
        }

        if ($parentClass = $reflector->getParentClass()) {
            echo "<strong style='color: saddlebrown;'>Батьківський клас:</strong> " . $parentClass->name . "<br>";
        }

        $traits = $reflector->getTraits();
        if (count($traits) > 0) {
            echo "<strong style='color: olive;'>Використані трейти:</strong><br>";
            foreach ($traits as $trait) {
                echo "<span style='color: olive;'> - " . $trait->getName() . "</span><br>";
            }
        }

        // $constants = $reflector->getConstants();
        // error with constants...


        $properties = $reflector->getProperties();
        if (count($properties) > 0) {
            echo "<strong style='color: darkcyan;'>Властивості:</strong><br>";
            foreach ($properties as $property) {
                echo "<span style='color: darkcyan;'> - " . $property->name . "</span><br>";
            }
        }

        if ($constructor = $reflector->getConstructor()) {
            echo "<strong style='color: darkblue;'>Конструктор:</strong><br>";
            foreach ($constructor->getParameters() as $param) {
                echo "<span style='color: darkblue;'> - " . $param->name . "</span><br>";
            }
        }

        $inheritedMethods = array_filter($reflector->getMethods(), function ($method) use ($reflector) {
            return $method->getDeclaringClass()->getName() !== $reflector->getName();
        });

        if (count($inheritedMethods) > 0) {
            echo "<strong style='color: darkmagenta;'>Успадковані методи:</strong><br>";
            foreach ($inheritedMethods as $method) {
                echo "<span style='color: darkmagenta;'> - " . $method->getName() . "</span><br>";
            }
        }


        echo "<br>";
    }


    private function printMethodsInfo($reflector, $filter, $title, $color)
    {
        $methods = $reflector->getMethods($filter);

        if (count($methods) > 0) {
            echo "<strong style='color: {$color};'>{$title}:</strong><br>";

            foreach ($methods as $method) {
                echo "<span style='color: {$color};'> - " . $method->name . "</span><br>";

                if ($docComment = $method->getDocComment()) {
                    echo "<span style='color: green;'><pre>" . htmlspecialchars($docComment) . "</pre></span><br>";
                }
            }
        }
    }
}
