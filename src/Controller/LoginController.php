<?php

namespace App\Controller;

use App\Routing\Attribute\Route;
use App\Models\LoginModel;
use Twig\Environment;

class LoginController extends AbstractController
{
    private LoginModel $loginModel;

    public function __construct(LoginModel $loginModel, Environment $twig)
    {
        parent::__construct($twig);
        $this->loginModel = $loginModel;
    }

    #[Route("/login", name: "loginPage", httpMethods: ["GET", "POST"])]
    public function login(): string
    {
        // Traitement du formulaire de connexion
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->loginModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $this->loginModel->saveUserSession($user['user_id'], $user['statut']);
                // Rediriger l'utilisateur vers l'accueil après la connexion
                header('Location: /');
                exit;
            } else {
                $errorMessage = "Nom d'utilisateur ou mot de passe incorrect.";
                return $this->twig->render('login.twig', ['login_error' => $errorMessage]);
            }
        }

        if (isset($_SESSION['user_id'])) {
            return $this->twig->render('userAccount.twig');
        } else {
            // Affichage du formulaire de connexion
            return $this->twig->render('login.twig');
        }
    }

    public function logout(): void
    {
        $this->loginModel->clearUserSession();

        header('Location: /');
    }
}
