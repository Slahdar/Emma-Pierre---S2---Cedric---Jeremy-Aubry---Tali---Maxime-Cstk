<?php

namespace App\Controller;

use App\Routing\Attribute\Route;

class aProposController extends AbstractController
{
    #[Route("/a-propos", name: "a-propos")]
    public function aPropos(): string
    {
        return $this->twig->render('aPropos.html.twig');
    }
}
