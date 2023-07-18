<?php

namespace App\Controller;

use App\Routing\Attribute\Route;
use App\Models\ProductModel;
use Twig\Environment;

class ProductListController extends AbstractController
{
    private ProductModel $productModel;

    public function __construct(ProductModel $productModel, Environment $twig)
    {
        parent::__construct($twig);
        $this->productModel = $productModel;
    }

    #[Route("/productList", name: "product_list")]

    public function productList(): string
    {
        $collections = $this->productModel->getCollections();
        $gemTypes = $this->productModel->getGemTypes();
        $categories = $this->productModel->getCategories();

        return $this->twig->render('productList.twig', [
            'collections' => $collections,
            'gemTypes' => $gemTypes,
            'categories' => $categories
        ]);
    }
}
