<?php
namespace App\Models;

use Config\Database;

class Chat {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function saveMessage($userName, $message) {
        $query = "INSERT INTO chat_messages (user_name, message) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$userName, $message]);
    }

    public function fetchRecentMessages($limit = 50) {
        $query = "SELECT * FROM chat_messages ORDER BY created_at ASC LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function fetchMessagesByUser($username) {
        $query = "SELECT * FROM chat_messages WHERE user_name = ? ORDER BY created_at DESC LIMIT 50";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username]);
        return $stmt->fetchAll();
    }

    public function deleteMessage($id) {
        $query = "DELETE FROM chat_messages WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
