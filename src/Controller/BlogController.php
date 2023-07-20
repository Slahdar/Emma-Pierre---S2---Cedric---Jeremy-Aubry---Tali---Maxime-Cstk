<?php

namespace App\Controller;

use App\Routing\Attribute\Route;

class BlogController extends AbstractController
{
    #[Route("/blog", name: "blog")]
    public function blog(): string
    {
        return $this->twig->render('blog.html.twig');
    }
}
