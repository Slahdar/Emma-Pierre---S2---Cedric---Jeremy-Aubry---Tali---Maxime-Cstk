<?php

namespace App\Controller;

use App\Routing\Attribute\Route;
use App\Models\ProductModel;
use Twig\Environment;
use Exception;

class productPageController extends AbstractController
{
    private $productModel;

    public function __construct(ProductModel $productModel, Environment $twig)
    {
        parent::__construct($twig);
        $this->productModel = $productModel;
    }

    #[Route("/product/{id}", name: "product_page")]
    public function getProductPage(int $id): string
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);  // Method Not Allowed
            return json_encode(['error' => 'Invalid HTTP method']);
        }

        $product = $this->productModel->getProductById($id);
        if ($product) {
            return $this->twig->render('productPage.html.twig', ['product' => $product]);
        } else {
            http_response_code(404);  // Not Found
            return json_encode(['error' => 'Product not found']);
        }
    }
}
