<?php

namespace App\Controller;

use App\Routing\Attribute\Route;

class ImpertinenteController extends AbstractController
{
    #[Route("/collection-impertinente", name: "collection-impertinente")]
    public function collectionImpertinente(): string
    {
        return $this->twig->render('collectionImpertinente.html.twig');
    }
}
