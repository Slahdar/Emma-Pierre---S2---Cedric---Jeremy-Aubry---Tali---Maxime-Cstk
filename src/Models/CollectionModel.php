<?php

namespace App\Models;

class CollectionModel
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllTypes()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM collection");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
