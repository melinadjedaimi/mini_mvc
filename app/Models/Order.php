<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class Order
{
    /**
     * Crée une commande et ses lignes à partir d'un panier
     *
     * @param int   $userId
     * @param array $cartItems tableau de lignes ['product' => [], 'quantity' => int, 'lineTotal' => float]
     * @param float $total
     * @return int|null ID de la commande ou null en cas d'erreur
     */
    public static function createFromCart(int $userId, array $cartItems, float $total): ?int
    {
        $pdo = Database::getPDO();
        $pdo->beginTransaction();

        try {
            $stmt = $pdo->prepare(
                "INSERT INTO commandes (id_user, total, statut) VALUES (?, ?, 'en_attente')"
            );
            $stmt->execute([$userId, $total]);
            $orderId = (int)$pdo->lastInsertId();

            $itemStmt = $pdo->prepare(
                "INSERT INTO commande_items (id_commande, id_produit, quantite, prix_unitaire) VALUES (?, ?, ?, ?)"
            );

            foreach ($cartItems as $item) {
                $product = $item['product'];
                $quantity = (int)$item['quantity'];
                $itemStmt->execute([
                    $orderId,
                    $product['id'],
                    $quantity,
                    $product['prix'],
                ]);

                // Mise à jour du stock du produit
                $updateStock = $pdo->prepare(
                    "UPDATE produits SET stock = stock - ? WHERE id = ? AND stock >= ?"
                );
                $updateStock->execute([$quantity, $product['id'], $quantity]);
            }

            $pdo->commit();
            return $orderId;
        } catch (\Throwable $e) {
            $pdo->rollBack();
            return null;
        }
    }

    /**
     * Récupère les commandes d'un utilisateur
     */
    public static function findByUser(int $userId): array
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare(
            "SELECT * FROM commandes WHERE id_user = ? ORDER BY created_at DESC"
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les lignes d'une commande
     */
    public static function findItems(int $orderId): array
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare(
            "SELECT ci.*, p.nom, p.image_url 
             FROM commande_items ci
             JOIN produits p ON p.id = ci.id_produit
             WHERE ci.id_commande = ?"
        );
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


