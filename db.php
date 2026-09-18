<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'event_management_db';

// Підключення через MySQLi
$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die("Помилка підключення до сервера: " . $conn->connect_error);
}

// Створення бази даних, якщо вона не існує
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$conn->select_db($dbname);

// Створення таблиці events, якщо вона не існує
$tableSql = "CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_date DATE NOT NULL,
    event_type VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($tableSql);
?>