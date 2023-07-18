<?php

namespace App\Controller;

use App\Routing\Attribute\Route;

use App\Models\CategoryModel;
use App\Models\GemTypeModel;
use Twig\Environment;

class backEndController extends AbstractController
{
    private $CategoryModel;
    private $gemTypeModel;

    public function __construct(CategoryModel $CategoryModel, GemTypeModel $gemTypeModel, Environment $twig)
    {
        parent::__construct($twig);
        $this->CategoryModel = $CategoryModel;
        $this->gemTypeModel = $gemTypeModel;
    }

    #[Route("/back", name: "backEnd")]
    public function home(): string
    {
        $categories = $this->CategoryModel->getAllCategories();
        $types = $this->gemTypeModel->getAllTypes();

        return $this->twig->render('backEnd.html.twig', ['categories' => $categories, 'types' => $types]);
    }
}
