<?php

// Active le mode strict pour la vérification des types
declare(strict_types=1);
// Déclare l'espace de noms pour ce contrôleur
namespace Mini\Controllers;
// Importe la classe de base Controller du noyau
use Mini\Core\Controller;
use Mini\Models\User;
use Mini\Models\Product;

// Déclare la classe finale HomeController qui hérite de Controller
final class HomeController extends Controller
{
    // Page d'accueil : catalogue de produits type Vinted
    public function index(): void
    {
        $products = Product::getAll();

        $this->render('home/index', params: [
            'title'    => 'Vêtements d\'occasion',
            'products' => $products,
        ]);
    }

    // Les anciennes méthodes JSON / formulaire user ne sont plus utilisées
}