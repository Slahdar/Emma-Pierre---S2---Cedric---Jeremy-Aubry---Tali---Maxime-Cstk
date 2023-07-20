<?php

namespace App\Controller;

use App\Routing\Attribute\Route;

class ContactController extends AbstractController
{
  #[Route("/contact", name: "contact_page")]
  public function contact(): string
  {
    return $this->twig->render('contact.html.twig');

  }
}
