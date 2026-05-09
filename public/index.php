<?php
// public/index.php - The Entry Point
session_start();
define('BASE_PATH', dirname(__DIR__));

// Require Composer autoloader
require BASE_PATH . '/vendor/autoload.php';

// Load Environment Variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

// Generate CSRF Token for security
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Production Error Handling
if (($_ENV['APP_ENV'] ?? 'local') === 'production') {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL);
    
    set_exception_handler(function($e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo "<div style='font-family:sans-serif; text-align:center; padding-top: 100px;'>";
        echo "<h1 style='color: #001B39;'>500 - Internal Server Error</h1>";
        echo "<p>Something went wrong. Please try again later.</p></div>";
        exit;
    });
}

// Simple PSR-4 style autoloader
spl_autoload_register(function ($class) {
    // E.g. App\Controllers\ProductController -> app/controllers/ProductController.php
    $path = str_replace('App\\', 'app/', $class);
    $path = str_replace('\\', '/', $path);
    // Lowercase the first directory (e.g. app/Controllers -> app/controllers)
    $pathParts = explode('/', $path);
    if (isset($pathParts[1])) {
        $pathParts[1] = strtolower($pathParts[1]); // controllers, services, models
    }
    $file = BASE_PATH . '/' . implode('/', $pathParts) . '.php';
    
    if (file_exists($file)) {
        require_once $file;
    }
});

// Load routes
require BASE_PATH . '/routes/web.php';
