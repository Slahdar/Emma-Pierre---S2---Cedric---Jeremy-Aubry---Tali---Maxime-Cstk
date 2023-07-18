<?php

namespace App\Controller;

use App\Routing\Attribute\Route;

use App\Models\CategorieModel;
use App\Models\GemTypeModel;

class backEndController extends AbstractController
{
    private $categorieModel;
    private $gemTypeModel;

    public function __construct(CategorieModel $categorieModel, GemTypeModel $gemTypeModel)
    {
        $this->categorieModel = $categorieModel;
        $this->gemTypeModel = $gemTypeModel;
    }

    #[Route("/back", name: "backEnd")]
    public function home(): string
    {
        $categories = $this->categorieModel->getAllCategories();
        $types = $this->gemTypeModel->getAllTypes();

        return $this->twig->render('backEnd.html.twig', ['categories' => $categories, 'types' => $types]);
    }
}
