<!doctype html>
<!-- Définit la langue du document -->
<html lang="fr">
<!-- En-tête du document HTML -->
<head>
    <!-- Déclare l'encodage des caractères -->
    <meta charset="utf-8">
    <!-- Configure le viewport pour les appareils mobiles -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Définit le titre de la page avec échappement -->
    <title><?= isset($title) ? htmlspecialchars($title) : 'App' ?></title>
    <!-- Style Galeries Lafayette -->
    <link rel="stylesheet" href="/css/galeries-lafayette-style.css">
</head>
<!-- Corps du document -->
<body>
<?php
// Détermine la page active pour la navigation
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$isHome = ($currentPath === '/');
$isProducts = ($currentPath === '/products');
$isProductsCreate = ($currentPath === '/products/create');
$isCart = ($currentPath === '/cart');
$isLogin = ($currentPath === '/login');
$isRegister = ($currentPath === '/register');
$isMyOrders = ($currentPath === '/mes-commandes');

$user = $_SESSION['user'] ?? null;
$cart = $_SESSION['cart'] ?? [];
$cartCount = array_sum(is_array($cart) ? $cart : []);
?>
<!-- En-tête de la page -->
<header>
    <div class="header-top">
        ✨ LIVRAISON OFFERTE DÈS 100€ D'ACHAT ✨
    </div>
    <div class="header-container">
        <!-- Logo/Titre -->
        <h1 class="logo">
            <a href="/">
                <span class="logo-icon">◆</span>
                Mareva
            </a>
        </h1>
        
        <!-- Navigation -->
        <nav>
            <ul>
                <li>
                    <a href="/" class="<?= $isHome ? 'active' : '' ?>">
                        Accueil
                    </a>
                </li>
                <li>
                    <a href="/products" class="<?= $isProducts ? 'active' : '' ?>">
                        Catalogue
                    </a>
                </li>
                <li>
                    <a href="/cart" class="<?= $isCart ? 'active' : '' ?>">
                        Panier (<?= (int)$cartCount ?>)
                    </a>
                </li>
                <?php if ($user): ?>
                    <li>
                        <a href="/mes-commandes" class="<?= $isMyOrders ? 'active' : '' ?>">
                            Mes commandes
                        </a>
                    </li>
                    <li>
                        <span class="user-greeting">
                            Bonjour <?= htmlspecialchars($user['nom']) ?>
                        </span>
                    </li>
                    <li>
                        <a href="/logout">
                            Déconnexion
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="/login" class="<?= $isLogin ? 'active' : '' ?>">
                            Connexion
                        </a>
                    </li>
                    <li>
                        <a href="/register" class="<?= $isRegister ? 'active' : '' ?>">
                            Inscription
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<!-- Zone de contenu principal -->
<main>
    <!-- Insère le contenu rendu de la vue -->
    <?= $content ?>
    
</main>

<!-- Footer -->
<footer>
    <div class="footer-container">
        <div class="footer-section">
            <h3 class="footer-title">MAREVA</h3>
            <p class="footer-description">Élégance et raffinement depuis 2026</p>
        </div>
        
        <div class="footer-section">
            <h4 class="footer-subtitle">BOUTIQUE</h4>
            <ul class="footer-links">
                <li><a href="/products">Catalogue</a></li>
                <li><a href="/products?categorie=1">Robes</a></li>
                <li><a href="/products?categorie=2">Tops</a></li>
                <li><a href="/products?categorie=3">Pantalons</a></li>
                <li><a href="/products?categorie=5">Accessoires</a></li>
            </ul>
        </div>
        
        <div class="footer-section">
            <h4 class="footer-subtitle">INFORMATIONS</h4>
            <ul class="footer-links">
                <li><a href="/">À propos</a></li>
                <li><a href="/">Mentions légales</a></li>
                <li><a href="/">Politique de confidentialité</a></li>
                <li><a href="/">Conditions générales de vente</a></li>
            </ul>
        </div>
        
        <div class="footer-section">
            <h4 class="footer-subtitle">SERVICE CLIENT</h4>
            <ul class="footer-links">
                <li><a href="/">Contact</a></li>
                <li><a href="/">Livraison & Retours</a></li>
                <li><a href="/">Guide des tailles</a></li>
                <li><a href="/">FAQ</a></li>
            </ul>
        </div>
        
        <div class="footer-section">
            <h4 class="footer-subtitle">MON COMPTE</h4>
            <ul class="footer-links">
                <?php if ($user): ?>
                    <li><a href="/mes-commandes">Mes commandes</a></li>
                    <li><a href="/cart">Mon panier</a></li>
                    <li><a href="/logout">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="/login">Connexion</a></li>
                    <li><a href="/register">Créer un compte</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>© <?= date('Y') ?> Mareva - Tous droits réservés</p>
        <p style="margin-top: 5px; font-size: 10px; opacity: 0.6;">Style inspiré des Galeries Lafayette</p>
    </div>
</footer>

<!-- Script Carrousel -->
<script>
let currentSlideIndex = 0;
const slides = document.querySelectorAll('.carousel-slide');
const dots = document.querySelectorAll('.dot');
let autoSlideInterval;

function showSlide(index) {
    // Gérer les limites
    if (index >= slides.length) {
        currentSlideIndex = 0;
    } else if (index < 0) {
        currentSlideIndex = slides.length - 1;
    } else {
        currentSlideIndex = index;
    }
    
    // Masquer toutes les slides
    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));
    
    // Afficher la slide active
    if (slides[currentSlideIndex]) {
        slides[currentSlideIndex].classList.add('active');
    }
    if (dots[currentSlideIndex]) {
        dots[currentSlideIndex].classList.add('active');
    }
}

function moveCarousel(direction) {
    showSlide(currentSlideIndex + direction);
    resetAutoSlide();
}

function currentSlide(index) {
    showSlide(index);
    resetAutoSlide();
}

function autoSlide() {
    moveCarousel(1);
}

function resetAutoSlide() {
    clearInterval(autoSlideInterval);
    autoSlideInterval = setInterval(autoSlide, 5000);
}

// Démarrer le carrousel automatique si les slides existent
if (slides.length > 0) {
    showSlide(0);
    autoSlideInterval = setInterval(autoSlide, 5000);
}
</script>

<!-- Fin du corps de la page -->
</body>
<!-- Fin du document HTML -->
</html>

