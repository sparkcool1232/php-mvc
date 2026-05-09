<?php
namespace App\Controllers;

use App\Models\Product;

class AdminController {
    
    public function index() {
        $productModel = new Product();
        $products = $productModel->fetchAll();
        
        $chatModel = new \App\Models\Chat();
        $messages = $chatModel->fetchRecentMessages(100);

        $this->render('admin', ['products' => $products, 'messages' => $messages]);
    }

    public function deleteChat($id) {
        $chatModel = new \App\Models\Chat();
        $chatModel->deleteMessage($id);
        header("Location: /admin");
        exit;
    }

    public function add() {
        $data = [
            'bank_name' => $_POST['bank_name'] ?? '',
            'title' => $_POST['title'] ?? '',
            'highlight_main' => $_POST['highlight_main'] ?? '',
            'annual_fee' => $_POST['annual_fee'] ?? '',
            'min_income' => $_POST['min_income'] ?? '',
            'promo_icon' => $_POST['promo_icon'] ?? '',
            'promo_text' => $_POST['promo_text'] ?? ''
        ];
        
        $productModel = new Product();
        $productModel->create($data);
        
        header("Location: /admin");
        exit;
    }

    public function edit($id) {
        $productModel = new Product();
        $product = $productModel->fetchById($id);
        
        if (!$product) {
            header("Location: /admin");
            exit;
        }

        $this->render('admin_edit', ['product' => $product]);
    }

    public function update($id) {
        $data = [
            'bank_name' => $_POST['bank_name'] ?? '',
            'title' => $_POST['title'] ?? '',
            'highlight_main' => $_POST['highlight_main'] ?? '',
            'annual_fee' => $_POST['annual_fee'] ?? '',
            'min_income' => $_POST['min_income'] ?? '',
            'promo_icon' => $_POST['promo_icon'] ?? '',
            'promo_text' => $_POST['promo_text'] ?? ''
        ];
        
        $productModel = new Product();
        $productModel->update($id, $data);
        
        header("Location: /admin");
        exit;
    }

    public function delete($id) {
        $productModel = new Product();
        $productModel->delete($id);
        header("Location: /admin");
        exit;
    }

    private function render($view, $data = []) {
        extract($data);
        require BASE_PATH . "/app/views/{$view}.php";
    }
}
