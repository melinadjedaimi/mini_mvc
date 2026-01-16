<?php
// Test simple pour diagnostiquer les problèmes
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Test de diagnostic</h1>";

echo "<h2>1. Autoloader</h2>";
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
    echo "✅ Autoloader chargé<br>";
} else {
    echo "❌ Autoloader manquant<br>";
    exit;
}

echo "<h2>2. Session</h2>";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
echo "✅ Session démarrée<br>";

echo "<h2>3. Base de données</h2>";
try {
    $pdo = Mini\Core\Database::getPDO();
    echo "✅ Connexion à la base de données réussie<br>";
    
    // Test de requête
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM produits");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✅ Nombre de produits dans la base : " . $result['count'] . "<br>";
} catch (Exception $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage() . "<br>";
}

echo "<h2>4. Contrôleurs</h2>";
if (class_exists('Mini\Controllers\HomeController')) {
    echo "✅ HomeController existe<br>";
} else {
    echo "❌ HomeController introuvable<br>";
}

if (class_exists('Mini\Controllers\ProductController')) {
    echo "✅ ProductController existe<br>";
} else {
    echo "❌ ProductController introuvable<br>";
}

if (class_exists('Mini\Controllers\CartController')) {
    echo "✅ CartController existe<br>";
} else {
    echo "❌ CartController introuvable<br>";
}

if (class_exists('Mini\Controllers\AuthController')) {
    echo "✅ AuthController existe<br>";
} else {
    echo "❌ AuthController introuvable<br>";
}

if (class_exists('Mini\Controllers\OrderController')) {
    echo "✅ OrderController existe<br>";
} else {
    echo "❌ OrderController introuvable<br>";
}

echo "<h2>5. Modèles</h2>";
if (class_exists('Mini\Models\Product')) {
    echo "✅ Product existe<br>";
} else {
    echo "❌ Product introuvable<br>";
}

if (class_exists('Mini\Models\User')) {
    echo "✅ User existe<br>";
} else {
    echo "❌ User introuvable<br>";
}

if (class_exists('Mini\Models\Order')) {
    echo "✅ Order existe<br>";
} else {
    echo "❌ Order introuvable<br>";
}

echo "<h2>6. Test de route</h2>";
echo "<a href='/'>Accueil</a><br>";
echo "<a href='/products'>Produits</a><br>";
echo "<a href='/cart'>Panier</a><br>";
echo "<a href='/login'>Connexion</a><br>";
echo "<a href='/register'>Inscription</a><br>";

