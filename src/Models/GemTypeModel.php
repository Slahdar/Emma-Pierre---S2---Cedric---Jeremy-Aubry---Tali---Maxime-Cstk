<?php

namespace App\Models;

class GemTypeModel
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllTypes()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM gem_type");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
