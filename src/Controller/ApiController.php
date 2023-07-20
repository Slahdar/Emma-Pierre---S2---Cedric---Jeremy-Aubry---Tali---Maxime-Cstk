<?php

namespace App\Controller;

use App\Routing\Attribute\Route;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\CartModel;
use Exception;

class ApiController extends AbstractController
{
    private $productModel;
    private $orderModel;
    private $cartModel;

    public function __construct(ProductModel $productModel, CartModel $cartModel, OrderModel $orderModel)
    {
        $this->productModel = $productModel;
        $this->cartModel = $cartModel;
        $this->orderModel = $orderModel;
    }
    #[Route("/api/products", name: "api_products_post", httpMethods: ["POST"])]
    public function postProduct(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);  // Method Not Allowed
            return json_encode(['error' => 'Invalid HTTP method']);
        }

        if (!isset($_SESSION['status']) || $_SESSION['status'] == 1) {
            http_response_code(401);
            return json_encode(['error' => 'unauthorised']);
        }

        $productData = [
            'name' => $_POST['name'] ?? null,
            'price' => $_POST['price'] ?? null,
            'description' => $_POST['description'] ?? null,
            'category-select' => $_POST['category-select'] ?? null,
            'type-select' => $_POST['type-select'] ?? null,
            'collection-select' => $_POST['collection-select'] ?? null,
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

    #[Route("/api/cart", name: "api_products_get")]
    public function getCart(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);  // Method Not Allowed
            return json_encode(['error' => 'Invalid HTTP method']);
        }

        $cartItems = $this->cartModel->getCartItems();
        return json_encode($cartItems);
    }

    #[Route("/api/cart/total", name: "api_cardtotal_get")]
    public function getCartTotal(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);  // Method Not Allowed
            return json_encode(['error' => 'Invalid HTTP method']);
        }

        $cartTotal = $this->cartModel->getTotal();
        return json_encode($cartTotal);
    }


    #[Route("/api/cart/deleteall", name: "api_empty_cart_get")]
    public function emptyCart(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);  // Method Not Allowed
            return json_encode(['error' => 'Invalid HTTP method']);
        }

        unset($_SESSION['Cart']);
        return json_encode("cart is empty");
    }

    #[Route("/api/productsbis", name: "api_products_get_bis")]
    public function getAllProductsBis(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);  // Method Not Allowed
            return json_encode(['error' => 'Invalid HTTP method']);
        }

        if (!isset($_SESSION['status']) || $_SESSION['status'] == 1) {
            http_response_code(401);
            return json_encode(['error' => 'unauthorised']);
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

    #[Route("/api/product/delete/{id}", name: "api_product_delete", httpMethods: ["GET", "POST"])]
    public function deleteProduct(int $id): string
    {
        // Set the Content-Type header
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);  // Method Not Allowed
            return json_encode(['error' => 'Invalid HTTP method']);
        }

        if (!isset($_SESSION['status']) || $_SESSION['status'] == 1) {
            http_response_code(401);
            return json_encode(['error' => 'unauthorised']);
        }

        $product = $this->productModel->deleteProductById($id);
        if ($product) {
            return json_encode(['message' => 'Product deleted successfully']);
        } else {
            http_response_code(404);  // Not Found
            return json_encode(['error' => 'Product not found']);
        }
    }

    #[Route("/api/addCart/{id}/{qty}", name: "api_addCart_post", httpMethods: ["POST"])]
    public function addItemToCart(int $id, int $qty)
    {
        if (!isset($_SESSION['Cart'])) {
            $_SESSION['Cart'] = [];
        }

        // Vérifier si le produit avec l'ID donné existe déjà dans le panier
        $productIndex = -1;
        foreach ($_SESSION['Cart'] as $index => $item) {
            if ($item['id'] === $id) {
                $productIndex = $index;
                break;
            }
        }

        // Si le produit existe déjà, mettre à jour la quantité en l'additionnant
        if ($productIndex !== -1) {
            $_SESSION['Cart'][$productIndex]['qty'] += $qty;
        } else {
            // Si le produit n'existe pas encore, l'ajouter au panier
            $_SESSION['Cart'][] = ['id' => $id, 'qty' => $qty];
        }

        // Renvoyer une réponse JSON indiquant le succès de l'opération
        return json_encode(['success' => true]);
    }

    #[Route("/api/cart/delete/{id}", name: "api_cart_delete", httpMethods: ["GET", "POST"])]
    public function deleteCartProduct(int $id): string
    {
        // Set the Content-Type header
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);  // Method Not Allowed
            return json_encode(['error' => 'Invalid HTTP method']);
        }

        foreach ($_SESSION['Cart'] as $key => $product) {
            if ($product['id'] == $id) {  // Corrected 'product_id' to 'id'
                unset($_SESSION['Cart'][$key]);
            }
        }


        $_SESSION['Cart'] = array_values($_SESSION['Cart']);

        return json_encode(['message' => 'Product deleted successfully']);
    }


    #[Route("/api/order", name: "api_order", httpMethods: ["POST"])]
    public function doTheOrder()
    {

        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return json_encode(['error' => 'Invalid HTTP method']);
        }
        $user_id = $_SESSION['user_id'];
        $cart = $this->cartModel->getCartItems();


        $order = $this->orderModel->doOrder($user_id, $cart);
        if ($order) {
            unset($_SESSION['Cart']);
            return json_encode(['message' => 'order was sucessfull']);
        } else {
            http_response_code(404);
            return json_encode(['error' => 'error processing order']);
        }
    }

    #[Route("/api/orders", name: "api_get_orders", httpMethods: ["GET", "POST"])]
    public function getTheOrders()
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            return json_encode(['error' => 'Invalid HTTP method']);
        }

        if (!isset($_SESSION['status']) || $_SESSION['status'] == 1) {
            http_response_code(401);
            return json_encode(['error' => 'unauthorised']);
        }

        $orders = $this->orderModel->getAllOrders();
        return json_encode($orders);
    }
}
