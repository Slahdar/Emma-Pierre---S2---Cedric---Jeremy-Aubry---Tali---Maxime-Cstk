<?php

namespace App\Models;

class CartModel
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function addToCart(int $productId, int $quantity)
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $productIndex = -1;
        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['id'] === $productId) {
                $productIndex = $index;
                break;
            }
        }

        if ($productIndex !== -1) {
            $_SESSION['cart'][$productIndex]['qty'] += $quantity;
        } else {
            $_SESSION['cart'][] = ['id' => $productId, 'qty' => $quantity];
        }
    }

    public function getCartItems()
    {

        $cartItems = $_SESSION['Cart'] ?? [];

        // Récupérer les IDs des produits dans le panier
        $productIds = array_column($cartItems, 'id');
        $productIds = implode(',', $productIds);
        // Récupérer les données des produits correspondant aux IDs du panier

        $sql = "SELECT * FROM product WHERE product_id IN ($productIds)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($cartItems as $itemQty) {
            foreach ($products as $key => $product) {
                if ($product['product_id'] == $itemQty['id']) {

                    unset($products[$key]);

                    $product['qty'] = $itemQty['qty'];

                    array_push($products, $product);
                }
            }
        }


        return $products;
    }

    public function getTotal()
    {

        $cart_product = $this->getCartItems();

        $total = 0;
        foreach ($cart_product as $item) {

            $price = $item['price'];
            $total += $price * $item['qty'];
        }

        return $total;
    }
}
