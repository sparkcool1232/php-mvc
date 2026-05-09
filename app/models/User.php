<?php
namespace App\Models;

use Config\Database;

class User {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    private function encrypt($data) {
        if (!$data) return null;
        $key = $_ENV['APP_KEY'] ?? 'fallback_secret_key_1234567890123456';
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    private function decrypt($data) {
        if (!$data) return null;
        $key = $_ENV['APP_KEY'] ?? 'fallback_secret_key_1234567890123456';
        $decoded = base64_decode($data);
        if (strpos($decoded, '::') === false) return $data;
        list($encrypted_data, $iv) = explode('::', $decoded, 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
    }

    public function register($username, $password, $role = 'user', $extraData = []) {
        // Hash the password securely
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        $ic = $this->encrypt($extraData['ic_number'] ?? null);
        $dob = $extraData['birthdate'] ?? null;
        $address = $this->encrypt($extraData['address'] ?? null);
        
        $query = "INSERT INTO users (username, password_hash, role, ic_number, birthdate, address) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$username, $hash, $role, $ic, $dob, $address]);
    }

    public function fetchById($id) {
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        
        if ($user) {
            $user['ic_number'] = $this->decrypt($user['ic_number']);
            $user['address'] = $this->decrypt($user['address']);
        }
        return $user;
    }

    public function updateAvatar($userId, $filename) {
        $query = "UPDATE users SET avatar = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$filename, $userId]);
    }

    public function login($username, $password) {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Verify password
        if ($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }
        return false;
    }
}
