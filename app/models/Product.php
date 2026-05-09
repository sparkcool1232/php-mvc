<?php
namespace App\Models;

use Config\Database;

class Product {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function fetchAll() {
        $query = "SELECT * FROM products ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $this->formatResults($stmt->fetchAll());
    }

    public function fetchByIds($ids) {
        if (empty($ids)) return [];
        // Create placeholders ?, ?, ? based on number of IDs
        $in = str_repeat('?,', count($ids) - 1) . '?';
        $query = "SELECT * FROM products WHERE id IN ($in)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($ids);
        
        return $this->formatResults($stmt->fetchAll());
    }

    public function fetchById($id) {
        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) return null;
        
        $results = $this->formatResults([$row]);
        return $results[0];
    }

    public function create($data) {
        $query = "INSERT INTO products (bank_name, title, highlight_main, annual_fee, min_income, promo_icon, promo_text) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['bank_name'], $data['title'], $data['highlight_main'], 
            $data['annual_fee'], $data['min_income'], $data['promo_icon'], $data['promo_text']
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE products SET bank_name=?, title=?, highlight_main=?, annual_fee=?, min_income=?, promo_icon=?, promo_text=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['bank_name'], $data['title'], $data['highlight_main'], 
            $data['annual_fee'], $data['min_income'], $data['promo_icon'], $data['promo_text'], $id
        ]);
    }

    public function delete($id) {
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    private function formatResults($results) {
        $formattedProducts = [];
        foreach ($results as $row) {
            $formattedProducts[] = [
                'id' => $row['id'],
                'bankName' => $row['bank_name'],
                'title' => $row['title'],
                'highlights' => [
                    'Key Highlight' => $row['highlight_main'],
                    'Annual Fee' => $row['annual_fee'],
                    'Minimum Income' => $row['min_income']
                ],
                'promoIcon' => $row['promo_icon'],
                'promoText' => $row['promo_text']
            ];
        }
        return $formattedProducts;
    }
}
