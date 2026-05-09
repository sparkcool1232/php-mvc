<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Chat;

class UserController {
    public function profile() {
        $userModel = new User();
        $user = $userModel->fetchById($_SESSION['user_id']);
        
        $chatModel = new Chat();
        $chats = $chatModel->fetchMessagesByUser($_SESSION['username']);
        
        $this->render('profile', ['user' => $user, 'chats' => $chats]);
    }
    
    public function uploadAvatar() {
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $tmpPath = $_FILES['avatar']['tmp_name'];
            
            // Basic check for images
            $check = getimagesize($tmpPath);
            if($check !== false) {
                $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '_avatar.' . $ext;
                $uploadDir = BASE_PATH . '/public/assets/uploads/';
                
                if (move_uploaded_file($tmpPath, $uploadDir . $filename)) {
                    $userModel = new User();
                    $userModel->updateAvatar($_SESSION['user_id'], $filename);
                }
            }
        }
        header("Location: /profile");
        exit;
    }
    
    private function render($view, $data = []) {
        extract($data);
        require BASE_PATH . "/app/views/{$view}.php";
    }
}
