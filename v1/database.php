<?php
// database.php

function connectDatabase() {
    // Параметры подключения к базе данных
    $host = 'localhost';
    $dbname = 'c90922_dalbadabl_ru';
    $user = 'c90922_dalbadabl_ru'; // замените на имя пользователя вашей базы данных
    $password = 'KuCfoFupzojuj41'; // замените на пароль вашей базы данных

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // Ошибка подключения
        echo json_encode(["error" => "Database connection failed: " . $e->getMessage()]);
        exit();
    }
}
?>
