<?php
namespace Config;

use PDO;
use PDOException;

class Database {
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
            $db_name = $_ENV['DB_NAME'] ?? 'moneysmart_clone';
            $username = $_ENV['DB_USER'] ?? 'root';
            $password = $_ENV['DB_PASS'] ?? '';

            try {
                self::$conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch(PDOException $exception) {
                // If DB doesn't exist yet, we will gracefully handle it so the app doesn't crash completely
                die("Database Connection Error: " . $exception->getMessage() . "<br><br>Make sure MySQL is running in XAMPP and the database 'moneysmart_clone' is created!");
            }
        }
        return self::$conn;
    }
}
