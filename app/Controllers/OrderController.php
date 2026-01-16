<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Order;
use Mini\Models\Product;

final class OrderController extends Controller
{
    /**
     * Validation du panier et création de la commande
     */
    public function checkout(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /cart');
            return;
        }

        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            header('Location: /login');
            return;
        }

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            header('Location: /cart');
            return;
        }

        $items = [];
        $total = 0.0;
        foreach ($cart as $productId => $quantity) {
            $product = Product::findById((int)$productId);
            if (!$product) {
                continue;
            }
            $quantity = (int)$quantity;
            $lineTotal = (float)$product['prix'] * $quantity;
            $total += $lineTotal;

            $items[] = [
                'product'   => $product,
                'quantity'  => $quantity,
                'lineTotal' => $lineTotal,
            ];
        }

        if (empty($items)) {
            header('Location: /cart');
            return;
        }

        $orderId = Order::createFromCart((int)$user['id'], $items, $total);
        if ($orderId === null) {
            $this->render('cart/index', [
                'title' => 'Mon panier',
                'items' => $items,
                'total' => $total,
                'error' => 'Erreur lors de la création de la commande. Veuillez réessayer.',
            ]);
            return;
        }

        // On vide le panier
        $_SESSION['cart'] = [];

        $this->render('orders/confirmation', [
            'title'    => 'Commande confirmée',
            'orderId'  => $orderId,
            'total'    => $total,
        ]);
    }

    /**
     * Espace client : liste des commandes
     */
    public function myOrders(): void
    {
        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            header('Location: /login');
            return;
        }

        $orders = Order::findByUser((int)$user['id']);

        // On récupère les items pour chaque commande
        $ordersWithItems = [];
        foreach ($orders as $order) {
            $ordersWithItems[] = [
                'order' => $order,
                'items' => Order::findItems((int)$order['id']),
            ];
        }

        $this->render('orders/my-orders', [
            'title'  => 'Mes commandes',
            'orders' => $ordersWithItems,
        ]);
    }
}


