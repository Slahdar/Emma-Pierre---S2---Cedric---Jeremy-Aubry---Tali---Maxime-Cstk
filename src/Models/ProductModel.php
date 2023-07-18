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
        $stmt = $this->pdo->prepare("SELECT * FROM product");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createProduct(array $data): bool
    {
        $sql = 'INSERT INTO product (product_name, price, description, image) VALUES (?, ?, ?, ?)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$data['name'], $data['price'], $data['description'], $data['image']]);
    }

    public function getProductById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM product WHERE product_id = ?");
        $stmt->execute([$id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function editProductById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM product WHERE product_id = ?");
        $stmt->execute([$id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getCollections(): array
    {
        $statement = $this->pdo->query("SELECT * FROM collection");
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getGemTypes(): array
    {
        $statement = $this->pdo->query("SELECT * FROM gem_type");
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCategories(): array
    {
        $statement = $this->pdo->query("SELECT * FROM category");
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
