<?php
namespace App\Controller;

use App\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route("/contact", name: "contact")]
    public function contact(): string
    {
        // Vérifie si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupère les données soumises par l'utilisateur
            $name = $_POST['user_name'];
            $email = $_POST['user_mail'];
            $firstname = $_POST['user_firstname'];
            $phone = $_POST['user_phone'];
            $message = $_POST['user_message'];

            // Vérifie si les champs obligatoires sont remplis
            if (empty($name) || empty($email) || empty($firstname) || empty($phone) || empty($message)) {
                // Vous pouvez ajouter ici une redirection vers la page de contact avec un message d'erreur, par exemple :
                // header('Location: /contact?error=Veuillez remplir tous les champs obligatoires.');
                // exit;
                // Cependant, il est préférable d'afficher l'erreur dans la page contact.html.twig pour une meilleure expérience utilisateur.

                return $this->twig->render('contact.html.twig', ['error' => 'Veuillez remplir tous les champs obligatoires.']);
            }

            // TODO: Insérer le code pour enregistrer les données dans la base de données ou envoyer un e-mail avec les données du formulaire
            // Vous pouvez ajouter ici le code pour enregistrer les données dans la base de données ou pour envoyer un e-mail avec les informations du formulaire.

            // Affiche un message de succès dans la page contact.html.twig
            return $this->twig->render('contact.html.twig', ['success' => 'Votre message a été envoyé avec succès ! Nous vous contacterons bientôt.']);
        }

        // Affiche le formulaire de contact
        return $this->twig->render('contact.html.twig');
    }
}
