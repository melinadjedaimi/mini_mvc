<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Product;

final class CartController extends Controller
{
    /**
     * Retourne le panier depuis la session (tableau associatif id_produit => quantite)
     */
    private function getCart(): array
    {
        return $_SESSION['cart'] ?? [];
    }

    /**
     * Enregistre le panier dans la session
     */
    private function saveCart(array $cart): void
    {
        $_SESSION['cart'] = $cart;
    }

    /**
     * Page d'affichage du panier
     */
    public function showCart(): void
    {
        $cart = $this->getCart();

        $items = [];
        $total = 0.0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::findById((int)$productId);
            if (!$product) {
                continue;
            }
            $lineTotal = (float)$product['prix'] * (int)$quantity;
            $total += $lineTotal;

            $items[] = [
                'product'   => $product,
                'quantity'  => (int)$quantity,
                'lineTotal' => $lineTotal,
            ];
        }

        $this->render('cart/index', [
            'title' => 'Mon panier',
            'items' => $items,
            'total' => $total,
        ]);
    }

    /**
     * Ajout d'un produit au panier
     */
    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /cart');
            return;
        }

        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $quantite = isset($_POST['quantite']) ? (int)$_POST['quantite'] : 1;
        if ($id <= 0 || $quantite <= 0) {
            header('Location: /');
            return;
        }

        $product = Product::findById($id);
        if ($product === null) {
            header('Location: /');
            return;
        }

        $cart = $this->getCart();
        if (isset($cart[$id])) {
            $cart[$id] += $quantite;
        } else {
            $cart[$id] = $quantite;
        }

        // On ne dépasse pas le stock disponible
        if ($cart[$id] > (int)$product['stock']) {
            $cart[$id] = (int)$product['stock'];
        }

        $this->saveCart($cart);
        header('Location: /cart');
    }

    /**
     * Retire un produit du panier
     */
    public function remove(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /cart');
            return;
        }

        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if ($id <= 0) {
            header('Location: /cart');
            return;
        }

        $cart = $this->getCart();
        unset($cart[$id]);
        $this->saveCart($cart);

        header('Location: /cart');
    }

    /**
     * Vide complètement le panier
     */
    public function clear(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->saveCart([]);
        }
        header('Location: /cart');
    }
}


