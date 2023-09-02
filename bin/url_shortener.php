<?php

require_once __DIR__ . '/../vendor/autoload.php';
$loader = new Nette\Loaders\RobotLoader;
$loader->addDirectory(__DIR__ . '/../src'); // шлях до класів
$loader->setTempDirectory(__DIR__ . '/../temp'); // шлях до темп
$loader->register();



use UrlShortener\UrlProcessor;

$urlProcessor = new UrlProcessor();

echo "Ласкаво просимо до програми URL-кодування та декодування!" . PHP_EOL;

while (true) {

    echo "Будь ласка, оберіть опцію:" . PHP_EOL;
    echo "1. Закодувати URL" . PHP_EOL;
    echo "2. Декодувати URL" . PHP_EOL;
    echo "3. Вийти з програми" . PHP_EOL;


    $option = readline("Введіть номер опції: ");


    switch ($option) {
        case '1':
            $urlToEncode = readline("Введіть URL для кодування: ");
            $codeLength = readline("Введіть бажану довжину коду URL: ");
            $urlProcessor->setShortCodeLength(empty($codeLength) ? 10 : (int)$codeLength);
            $encodedUrl = $urlProcessor->encode($urlToEncode);
            echo "Закодований URL: $encodedUrl" . PHP_EOL;
            break;
        case '2':
            $encodedUrl = readline("Введіть закодований URL для декодування: ");
            $decodedUrl = $urlProcessor->decode($encodedUrl);
            echo "Декодований URL: $decodedUrl" . PHP_EOL;
            break;
        case '3':
            echo "Дякуємо за використання програми!" . PHP_EOL;
            exit;
        default:
            echo "Невірний вибір опції. Будь ласка, виберіть коректну опцію." . PHP_EOL;
            break;
    }
}