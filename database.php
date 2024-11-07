<?php
// Подключаемся к базе данных PostgreSQL с помощью PDO
try {
    // Получаем параметры подключения из переменных окружения
    $host = getenv('DB_HOST');
    $dbname = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $password = getenv('DB_PASS');
    $port = getenv('DB_PORT');

    // Создаем строку подключения (DSN)
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

    // Устанавливаем подключение
    $pdo = new PDO($dsn, $user, $password);

    // Устанавливаем режим ошибок (опционально)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Подключение к базе данных успешно!";
} catch (PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
}
?>
