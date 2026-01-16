<?php

declare(strict_types=1);

require dirname(path: __DIR__) . '/vendor/autoload.php';

use Mini\Core\Router;

// Démarre la session pour gérer l'authentification et le panier
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Table des routes minimaliste
$routes = [
    // Accueil = catalogue
    ['GET', '/', [Mini\Controllers\HomeController::class, 'index']],

    // Produits
    ['GET', '/products', [Mini\Controllers\ProductController::class, 'listProducts']],
    ['GET', '/products/create', [Mini\Controllers\ProductController::class, 'showCreateProductForm']],
    ['POST', '/products', [Mini\Controllers\ProductController::class, 'createProduct']],
    ['GET', '/product', [Mini\Controllers\ProductController::class, 'showProduct']],

    // Panier
    ['GET', '/cart', [Mini\Controllers\CartController::class, 'showCart']],
    ['POST', '/cart/add', [Mini\Controllers\CartController::class, 'add']],
    ['POST', '/cart/remove', [Mini\Controllers\CartController::class, 'remove']],
    ['POST', '/cart/clear', [Mini\Controllers\CartController::class, 'clear']],

    // Authentification
    ['GET', '/register', [Mini\Controllers\AuthController::class, 'showRegisterForm']],
    ['POST', '/register', [Mini\Controllers\AuthController::class, 'register']],
    ['GET', '/login', [Mini\Controllers\AuthController::class, 'showLoginForm']],
    ['POST', '/login', [Mini\Controllers\AuthController::class, 'login']],
    ['GET', '/logout', [Mini\Controllers\AuthController::class, 'logout']],

    // Commandes / espace client
    ['POST', '/checkout', [Mini\Controllers\OrderController::class, 'checkout']],
    ['GET', '/mes-commandes', [Mini\Controllers\OrderController::class, 'myOrders']],
];
// Bootstrap du router
$router = new Router($routes);
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);