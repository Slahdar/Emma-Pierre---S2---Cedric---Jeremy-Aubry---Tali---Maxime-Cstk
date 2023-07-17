<?php

namespace App\Controller;

use App\Routing\Attribute\Route;
use App\Models\ProductModel;

class ApiController extends AbstractController
{
    private $productModel;

    public function __construct(ProductModel $productModel)
    {
        $this->productModel = $productModel;
    }
    #[Route("/api/products/POST", name: "api_products_post")]
    public function postProduct(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);  // Method Not Allowed
            return json_encode(['error' => 'Invalid HTTP method']);
        }
    
        // Assuming that your product data is coming from the request body
        $productData = json_decode(file_get_contents('php://input'), true);
        if (!$productData) {
            http_response_code(400);  // Bad Request
            return json_encode(['error' => 'Invalid or missing product data']);
        }
    
        try {
            $result = $this->productModel->createProduct($productData);
            if ($result) {
                http_response_code(201);  // Created
                return json_encode(['success' => 'Product successfully created']);
            } else {
                http_response_code(500);  // Internal Server Error
                return json_encode(['error' => 'Unable to create product']);
            }
        } catch (Exception $e) {
            http_response_code(500);  // Internal Server Error
            return json_encode(['error' => 'An error occurred while creating the product']);
        }
    }
    
    #[Route("/api/products/GET", name: "api_products_get")]
    public function getProducts(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);  // Method Not Allowed
            return json_encode(['error' => 'Invalid HTTP method']);
        }

        $products = $this->productModel->getAllProducts();
        return json_encode($products);
    }

  
   

 
}