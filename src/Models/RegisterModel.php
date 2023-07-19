<?php

namespace App\Models;

use PDO;

class RegisterModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function checkUserExists(string $username, string $email): bool
    {
        // Requête pour vérifier si le nom d'utilisateur ou l'adresse e-mail existe déjà
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM user WHERE username = :username OR email = :email');
        $stmt->execute(['username' => $username, 'email' => $email]);
        $count = $stmt->fetchColumn();

        return $count > 0;
    }

    public function registerUser(string $username, string $email, string $password): void
    {
        // Hash du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Requête pour insérer le nouvel utilisateur dans la base de données
        $stmt = $this->pdo->prepare('INSERT INTO user (username, email, password) VALUES (:username, :email, :password)');
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashedPassword]);
    }
}
