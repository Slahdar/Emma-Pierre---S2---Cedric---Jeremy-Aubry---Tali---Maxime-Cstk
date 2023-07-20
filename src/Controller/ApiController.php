<?php

namespace App\Controller;

use App\Routing\Attribute\Route;
use App\Models\ProductModel;
use Exception;

class ApiController extends AbstractController
{
    private $productModel;

    public function __construct(ProductModel $productModel)
    {
        $this->productModel = $productModel;
    }
    #[Route("/api/products", name: "api_products_post", httpMethods: ["POST"])]
    public function postProduct(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);  // Method Not Allowed
            return json_encode(['error' => 'Invalid HTTP method']);
        }

        $productData = [
            'name' => $_POST['name'] ?? null,
            'price' => $_POST['price'] ?? null,
            'description' => $_POST['description'] ?? null,
            'category-select' => $_POST['category-select'] ?? null,
            'type-select' => $_POST['type-select'] ?? null,
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
    #[Route("/api/productsbis", name: "api_products_get_bis")]
    public function getAllProductsBis(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);  // Method Not Allowed
            return json_encode(['error' => 'Invalid HTTP method']);
        }

        $products = $this->productModel->getAllProductsBis();
        return json_encode($products);
    }

    #[Route("/api/products/{id}", name: "api_product_get")]
    public function getProductItem(int $id): string
    {
        return $id;
    }

    #[Route("/api/products/{id}", name: "api_product_post", httpMethods: ["POST"])]
    public function getProduct(int $id): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);  // Method Not Allowed
            return json_encode(['error' => 'Invalid HTTP method']);
        }

        $product = $this->productModel->getProductById($id);
        if ($product) {
            return json_encode($product);
        } else {
            http_response_code(404);  // Not Found
            return json_encode(['error' => 'Product not found']);
        }
    }

    #[Route("/api/addCart/{id}", name: "api_addCart_post", httpMethods: ["GET", "POST"])]
    public function addItemToCart(int $id)
    {
        if (!isset($_SESSION['Cart'])) {
            $_SESSION['Cart'] = [];
        }
        array_push($_SESSION['Cart'], ['id' => $id, 'qty' => 1]);

        // Renvoyer une réponse JSON indiquant le succès de l'opération
        return json_encode(['success' => true]);
    }
}
