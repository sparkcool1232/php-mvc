<?php
namespace App\Services;

class ComparisonService {
    
    public function getAllProducts() {
        $productModel = new \App\Models\Product();
        return $productModel->fetchAll();
    }

    public function getProductsByIds($ids) {
        $productModel = new \App\Models\Product();
        return $productModel->fetchByIds($ids);
    }
}
