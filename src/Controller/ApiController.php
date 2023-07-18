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
    #[Route("/api/products", name: "api_products_post", httpMethod: "POST")]
    public function postProduct(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);  // Method Not Allowed
            return json_encode(['error' => 'Invalid HTTP method']);
        }

        $productData = [
            'name' => $_POST['name'] ?? null,
            'price' => $_POST['price'] ?? null,
            'description' => $_POST['description'] ?? null
        ];

        // You can validate your product data here
        if (!$productData['name'] || !$productData['price'] || !$productData['description']) {
            http_response_code(400);  // Bad Request
            return json_encode(['error' => 'Invalid or missing product data']);
        }

        // Handling file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $tmp_name = $_FILES['image']['tmp_name'];
            $name = basename($_FILES['image']['name']);
            $directory = __DIR__ . '/../../public/img/';  // make sure this path is correct
            $uploaded = move_uploaded_file($tmp_name, $directory . $name);
            if (!$uploaded) {
                http_response_code(500);  // Internal Server Error
                return json_encode(['error' => 'File upload failed']);
            }
            $productData['image'] = $name;  // adding image name to product data
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


    #[Route("/api/products", name: "api_products_get")]
    public function getProducts(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);  // Method Not Allowed
            return json_encode(['error' => 'Invalid HTTP method']);
        }

        $products = $this->productModel->getAllProducts();
        return json_encode($products);
    }

    #[Route("/api/products/{id}", name: "api_product_get",  httpMethod: "POST")]
    public function getProduct(int $id): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);  // Method Not Allowed
            return json_encode(['error' => 'Invalid HTTP method']);
        }

        $product = $this->productModel->editProductById($id);
        if ($product) {
            return json_encode($product);
        } else {
            http_response_code(404);  // Not Found
            return json_encode(['error' => 'Product not found']);
        }
    }
}
