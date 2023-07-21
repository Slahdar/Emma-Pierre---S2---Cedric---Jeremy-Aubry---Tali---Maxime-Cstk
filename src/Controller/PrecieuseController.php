<?php

namespace App\Controller;

use App\Routing\Attribute\Route;

class PrecieuseController extends AbstractController
{
    #[Route("/collection-precieuse", name: "collection-precieuse")]
    public function collectionPrecieuse(): string
    {
        return $this->twig->render('collectionPrecieuse.html.twig');
    }
}
