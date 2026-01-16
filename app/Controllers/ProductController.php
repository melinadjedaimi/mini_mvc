<?php

// Active le mode strict pour la vérification des types
declare(strict_types=1);
// Déclare l'espace de noms pour ce contrôleur
namespace Mini\Controllers;
// Importe la classe de base Controller du noyau
use Mini\Core\Controller;
use Mini\Models\Product;
use Mini\Models\Category;

// Déclare la classe finale ProductController qui hérite de Controller
final class ProductController extends Controller
{
    // Liste tous les produits (page catalogue secondaire)
    public function listProducts(): void
    {
        // Récupère le paramètre de catégorie depuis l'URL
        $categorieId = isset($_GET['categorie']) ? (int)$_GET['categorie'] : 0;
        
        // Récupère toutes les catégories pour la navigation
        $categories = Category::getAll();
        
        // Récupère les produits selon la catégorie sélectionnée
        if ($categorieId > 0) {
            $products = Product::getByCategory($categorieId);
            $selectedCategory = Category::findById($categorieId);
            $pageTitle = $selectedCategory ? 'Catégorie : ' . $selectedCategory['nom'] : 'Liste des produits';
        } else {
            $products = Product::getAll();
            $pageTitle = 'Catalogue complet';
        }
        
        // Affiche la liste des produits
        $this->render('product/list-products', params: [
            'title' => $pageTitle,
            'products' => $products,
            'categories' => $categories,
            'selectedCategoryId' => $categorieId
        ]);
    }

    // Page détail produit
    public function showProduct(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($id <= 0) {
            http_response_code(404);
            echo 'Produit introuvable';
            return;
        }

        $product = Product::findById($id);
        if ($product === null) {
            http_response_code(404);
            echo 'Produit introuvable';
            return;
        }

        $this->render('product/detail', [
            'title'   => $product['nom'] . ' - Détail',
            'product' => $product,
        ]);
    }

    public function showCreateProductForm(): void
    {
        // Affiche le formulaire de création de produit
        $this->render('product/create-product', params: [
            'title' => 'Créer un produit'
        ]);
    }

    public function createProduct(): void
    {
        // Vérifie que la méthode HTTP est POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /products/create');
            return;
        }
        
        // Récupère les données depuis $_POST
        $input = $_POST;
        
        // Valide les données requises
        if (empty($input['nom']) || empty($input['prix']) || empty($input['stock'])) {
            $this->render('product/create-product', params: [
                'title' => 'Créer un produit',
                'message' => 'Les champs "nom", "prix" et "stock" sont requis.',
                'success' => false,
                'old_values' => $input
            ]);
            return;
        }
        
        // Valide le prix (doit être un nombre positif)
        if (!is_numeric($input['prix']) || floatval($input['prix']) < 0) {
            $this->render('product/create-product', params: [
                'title' => 'Créer un produit',
                'message' => 'Le prix doit être un nombre positif.',
                'success' => false,
                'old_values' => $input
            ]);
            return;
        }
        
        // Valide le stock (doit être un entier positif)
        if (!is_numeric($input['stock']) || intval($input['stock']) < 0) {
            $this->render('product/create-product', params: [
                'title' => 'Créer un produit',
                'message' => 'Le stock doit être un entier positif.',
                'success' => false,
                'old_values' => $input
            ]);
            return;
        }
        
        // Valide l'URL de l'image si fournie
        $image_url = $input['image_url'] ?? '';
        if (!empty($image_url) && !filter_var($image_url, FILTER_VALIDATE_URL)) {
            $this->render('product/create-product', params: [
                'title' => 'Créer un produit',
                'message' => 'L\'URL de l\'image n\'est pas valide.',
                'success' => false,
                'old_values' => $input
            ]);
            return;
        }
        
        // Crée une nouvelle instance Product
        $product = new Product();
        $product->setNom($input['nom']);
        $product->setDescription($input['description'] ?? '');
        $product->setPrix(floatval($input['prix']));
        $product->setStock(intval($input['stock']));
        $product->setImageUrl($image_url);
        
        // Sauvegarde le produit
        if ($product->save()) {
            $this->render('product/create-product', params: [
                'title' => 'Créer un produit',
                'message' => 'Produit créé avec succès.',
                'success' => true
            ]);
        } else {
            $this->render('product/create-product', params: [
                'title' => 'Créer un produit',
                'message' => 'Erreur lors de la création du produit.',
                'success' => false,
                'old_values' => $input
            ]);
        }
    }
}

