<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'];
$port = $_ENV['DB_PORT'];
$db_name = $_ENV['DB_DATABASE']; // Notice the key mapping based on their local .env
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Update all existing users to admin
    $stmt = $conn->prepare("UPDATE users SET role = 'admin'");
    $stmt->execute();

    echo "Successfully promoted " . $stmt->rowCount() . " user(s) to admin!";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
