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

    public function getAllProductsBis()
    {
        $stmt = $this->pdo->prepare(
            " SELECT p.product_id, p.product_name, p.price, p.description, p.image, c.category_name, g.gem_name, col.collection_name FROM product p LEFT JOIN category c ON p.category_id = c.category_id LEFT JOIN gem_type g ON p.gem_id = g.gem_id LEFT JOIN collection col ON p.collection_id = col.collection_id "
        );
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createProduct(array $data): bool
    {
        $sql = 'INSERT INTO product (product_name, price, description, image, category_id, gem_id, collection_id) VALUES (?, ?, ?, ?, ?, ?, ?)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$data['name'], $data['price'], $data['description'], $data['image'], $data['category-select'], $data['type-select'], $data['collection-select']]);
    }

    public function getProductById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM product WHERE product_id = ?");
        $stmt->execute([$id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function deleteProductById(int $id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM product WHERE product_id = ?");
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
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
