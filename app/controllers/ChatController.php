<?php
namespace App\Controllers;

use App\Models\Chat;

class ChatController {
    
    // Equivalent to /chat/send.php
    public function send() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $userName = $_SESSION['username'] ?? 'Guest';
            $message = $data['message'] ?? '';
            
            if (!empty($message)) {
                $chatModel = new Chat();
                $chatModel->saveMessage($userName, $message);
                echo json_encode(['status' => 'success']);
                return;
            }
        }
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    }

    // Equivalent to /chat/fetch.php
    public function fetch() {
        $chatModel = new Chat();
        $messages = $chatModel->fetchRecentMessages();
        
        header('Content-Type: application/json');
        echo json_encode($messages);
    }
}
