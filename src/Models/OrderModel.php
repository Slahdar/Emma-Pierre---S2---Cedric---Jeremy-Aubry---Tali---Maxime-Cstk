<?php

namespace App\Models;

class OrderModel
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        // Set the PDO error mode to exception
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function doOrder($id, $cart)
    {
        try {


            // Calculate the total price for the order
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['qty'];
            }

            // Insert data into the `order` table
            $sqlOrder = 'INSERT INTO `order` (user_id, order_date, order_status, order_total) VALUES (?, CURDATE(), ?, ?)'; // Adjusted id_customer to user_id
            $stmtOrder = $this->pdo->prepare($sqlOrder);
            $stmtOrder->execute([$id, 'Pending', $total]);

            // Get the last inserted order ID for reference in the order detail
            $orderID = $this->pdo->lastInsertId();


            // Insert data into the `order_detail` table
            $sqlDetail = 'INSERT INTO `order_detail` (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)';
            $stmtDetail = $this->pdo->prepare($sqlDetail);

            foreach ($cart as $item) {
                $stmtDetail->execute([$orderID, $item['product_id'], $item['qty'], $item['price']]);
            }

            return true;  // Order processed successfully

        } catch (\PDOException $e) {
            // Log the PDO error for debugging
            error_log('PDO Error in OrderModel: ' . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            // Log any other exceptions for debugging
            error_log('General Error in OrderModel: ' . $e->getMessage());
            return false;
        }
    }

    public function getAllOrders()
    {

        $stmt = $this->pdo->prepare("SELECT od.detail_id, o.order_id, p.product_name, u.username, u.nom_prenom, od.unit_price, o.order_total, c.nom_rue, c.numero_rue, c.ville, c.code_postal
        FROM `order_detail` AS od
        JOIN `order` AS o ON od.order_id = o.order_id
        JOIN `product` AS p ON od.product_id = p.product_id
        JOIN `user` AS u ON o.user_id = u.user_id
        LEFT JOIN `customer` AS c ON c.id_customer = u.id_customer");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
