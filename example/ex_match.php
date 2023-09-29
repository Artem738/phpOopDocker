<?php

// Создаём массив с различными фруктами
$fruits = ["Apple", "Banana", "Cherry", "Orange", "Grape"];

// Наполним новый массив информацией о цветах этих фруктов
$fruitColors = [];

foreach ($fruits as $fruit) {
    // Используем оператор match для определения цвета каждого фрукта
    $color = match($fruit) {
        "Apple" => "Red",
        "Banana" => "Yellow",
        "Cherry" => "Red",
        "Orange" => "Orange",
        "Grape" => "Purple",
        default => "Unknown"
    };

    // Сохраняем цвет в новом массиве
    $fruitColors[$fruit] = $color;
}

// Выводим новый массив с цветами фруктов
print_r($fruitColors);

// Проверим цвет конкретного фрукта с помощью оператора match
$selectedFruit = "Apple";
$selectedFruitColor = match($selectedFruit) {
    "Apple", "Cherry" => "Red",
    "Banana" => "Yellow",
    "Orange" => "Orange",
    "Grape" => "Purple",
    default => "Unknown"
};

echo "The color of {$selectedFruit} is {$selectedFruitColor}.\n";
