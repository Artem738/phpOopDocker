<?php
$host = 'db_mysql';
$db = 'base';
$user = 'art';
$pass = 'artpass';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Successfully connected!";
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$query = $pdo->query('SHOW TABLES');
$tables = $query->fetchAll(PDO::FETCH_COLUMN);

if ($tables) {
    echo PHP_EOL . PHP_EOL . "Список таблиц:" . PHP_EOL;

    foreach ($tables as $table) {
        echo "Таблица: $table" . PHP_EOL;

        $columnsQuery = $pdo->query("SHOW COLUMNS FROM $table");
        $columns = $columnsQuery->fetchAll(PDO::FETCH_COLUMN);

        echo "Поля:" . PHP_EOL;
        foreach ($columns as $column) {
            echo "- $column" . PHP_EOL;
        }
        echo "" . PHP_EOL;
    }
} else {
    echo "<br><br>В базе данных нет таблиц!";
}
