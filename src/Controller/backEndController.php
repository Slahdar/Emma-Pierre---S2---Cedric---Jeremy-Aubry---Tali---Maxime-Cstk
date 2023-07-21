<?php

namespace App\Controller;

use App\Routing\Attribute\Route;
use App\Models\CategoryModel;
use App\Models\GemTypeModel;
use App\Models\CollectionModel;
use Twig\Environment;

class backEndController extends AbstractController
{
    private $CategoryModel;
    private $gemTypeModel;
    private $collectionModel;

    public function __construct(CategoryModel $CategoryModel, GemTypeModel $gemTypeModel, CollectionModel $collectionModel, Environment $twig)
    {
        parent::__construct($twig);
        $this->CategoryModel = $CategoryModel;
        $this->gemTypeModel = $gemTypeModel;
        $this->collectionModel = $collectionModel;
    }

    #[Route("/back", name: "backEnd")]
    public function home(): string
    {
        if (!isset($_SESSION['status']) || $_SESSION['status'] == 1) {
            http_response_code(401);  
            return 'ERROR 401 : Unauthorised';
        }

        $categories = $this->CategoryModel->getAllCategories();
        $types = $this->gemTypeModel->getAllTypes();
        $collections = $this->collectionModel->getAllCollection();

        return $this->twig->render('backEnd.html.twig', ['categories' => $categories, 'types' => $types, 'collections' => $collections]);
    }
}
