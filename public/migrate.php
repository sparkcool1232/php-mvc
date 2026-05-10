<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$port = $_ENV['DB_PORT'] ?? '3306';
$db_name = $_ENV['DB_NAME'] ?? 'moneysmart_clone';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';

try {
    $conn = new PDO("mysql:host=$host;port=$port", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->exec("CREATE DATABASE IF NOT EXISTS `$db_name`");
    $conn->exec("USE `$db_name`");

    echo "Database connected successfully.\n";

    $conn->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        role VARCHAR(20) DEFAULT 'user',
        ic_number VARCHAR(255),
        birthdate DATE,
        address TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    echo "Users table migrated.\n";

    $conn->exec("CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        bank_name VARCHAR(255) NOT NULL,
        title VARCHAR(255) NOT NULL,
        highlight_main VARCHAR(255),
        annual_fee VARCHAR(255),
        min_income VARCHAR(255),
        promo_icon VARCHAR(50),
        promo_text TEXT
    )");

    echo "Products table migrated.\n";

    $conn->exec("CREATE TABLE IF NOT EXISTS chat_messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_name VARCHAR(50) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    echo "Chat table migrated.\n";

    echo "All migrations completed successfully!\n";

} catch(PDOException $e) {
    echo "Migration failed: " . $e->getMessage();
}