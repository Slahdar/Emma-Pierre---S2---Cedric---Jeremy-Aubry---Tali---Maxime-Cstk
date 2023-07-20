<?php

namespace App\Controller;

use App\Routing\Attribute\Route;

class cartController extends AbstractController
{
    #[Route("/cart", name: "Cart")]
    public function home(): string
    {
        return $this->twig->render('cartPage.html.twig');
    }
}
