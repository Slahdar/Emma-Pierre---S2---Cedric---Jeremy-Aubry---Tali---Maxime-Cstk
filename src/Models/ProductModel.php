<?php

namespace App\Models;

class ProductModel
    {
        private $pdo;

    public function __construct(\PDO $pdo) 
        {
            $this->pdo = $pdo;
        }

    public function getAllProducts()
        {
            $stmt = $this->pdo->prepare("SELECT * FROM products");
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

    public function createProduct(array $data): bool
        {
            $sql = 'INSERT INTO products (name, price, description) VALUES (?, ?, ?)';
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$data['name'], $data['price'], $data['description']]);
        }

    }  