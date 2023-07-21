<?php

namespace App\Controller;

use App\Routing\Attribute\Route;

class UniqueController extends AbstractController
{
    #[Route("/collection-unique", name: "collection-unique")]
    public function collectionUnique(): string
    {
        return $this->twig->render('collectionUnique.html.twig');
    }
}
