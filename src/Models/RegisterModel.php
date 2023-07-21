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

    public function registerUserAndCustomer(string $username, string $nomPrenom, string $email, string $password, string $phone, string $numero_rue, string $nom_rue, string $code_postal, string $country, string $city): bool
    {
        // Hash du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Start the transaction
        $this->pdo->beginTransaction();

        try {
            // Requête pour insérer les informations du client dans la table customer
            $stmt_customer = $this->pdo->prepare('INSERT INTO customer (telephone, numero_rue, nom_rue, code_postal, pays, ville) VALUES (:telephone, :numero_rue, :nom_rue, :code_postal, :pays, :ville)');
            $stmt_customer->execute([ 'telephone' => $phone, 'numero_rue' => $numero_rue, 'nom_rue' => $nom_rue, 'code_postal' => $code_postal, 'pays' => $country, 'ville' => $city]);

            $idCustomer = $this->pdo->lastInsertId();
            // Requête pour insérer le nouvel utilisateur dans la table user
            $stmt_user = $this->pdo->prepare('INSERT INTO user (username, email, password, id_customer, nom_prenom) VALUES (:username, :email, :password, :idCustomer, :nomPrenom)');
            $stmt_user->execute(['username' => $username, 'email' => $email, 'password' => $hashedPassword, "idCustomer"=>$idCustomer, "nomPrenom"=>$nomPrenom]);
            // $user_id = $this->pdo->lastInsertId();


            // Commit the transaction if everything is successful
            $this->pdo->commit();

            return true; // Registration successful
        } catch (Exception $e) {
            // Rollback the transaction if there is an error
            $this->pdo->rollback();

            return false; // Registration failed
        }
    }
}