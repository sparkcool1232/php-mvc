<?php
namespace App\Controllers;

use App\Models\User;

class AuthController {
    public function showLogin() {
        $this->render('login');
    }

    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->login($username, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: /");
            exit;
        } else {
            $this->render('login', ['error' => 'Invalid username or password']);
        }
    }

    public function showRegister() {
        $this->render('register');
    }

    public function register() {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("CSRF Token Validation Failed. Potential malicious request.");
        }

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        
        $extraData = [
            'ic_number' => $_POST['ic_number'] ?? '',
            'birthdate' => $_POST['birthdate'] ?? '',
            'address' => $_POST['address'] ?? ''
        ];
        
        // Very basic validation
        if (strlen($username) > 2 && strlen($password) > 3) {
            $userModel = new User();
            // If they type 'admin', make them an admin for demo purposes
            $role = ($username === 'admin') ? 'admin' : 'user';
            $userModel->register($username, $password, $role, $extraData);
            header("Location: /login");
            exit;
        } else {
            $this->render('register', ['error' => 'Username/Password too short']);
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /");
        exit;
    }

    private function render($view, $data = []) {
        extract($data);
        require BASE_PATH . "/app/views/{$view}.php";
    }
}
