<?php
namespace App\Controllers;

use App\Services\ComparisonService;

class ProductController {
    
    public function index() {
        // Use the service to get business logic data
        $service = new ComparisonService();
        $products = $service->getAllProducts();
        
        // Pass data to the view
        $this->render('home', [
            'title' => 'MoneySmart Clone (PHP MVC)',
            'products' => $products
        ]);
    }

    public function compare() {
        $ids = $_GET['product_ids'] ?? [];
        if (empty($ids)) {
            // Redirect back if no products were selected
            header("Location: /");
            exit;
        }
        
        $service = new ComparisonService();
        $products = $service->getProductsByIds($ids);
        
        $this->render('compare', [
            'title' => 'Comparing Credit Cards',
            'products' => $products
        ]);
    }
    
    // Helper method to render views
    private function render($view, $data = []) {
        // Extract array into variables (e.g. $data['products'] becomes $products)
        extract($data);
        require BASE_PATH . "/app/views/{$view}.php";
    }
}
