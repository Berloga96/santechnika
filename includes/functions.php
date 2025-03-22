<?php

// Подключение конфигурации
require_once __DIR__ . '/../config.php';
function connectToDatabase() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }
    return $conn;
}
?>