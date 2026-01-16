<!-- Liste des produits -->
<div class="main-container">
    <!-- Navigation des catégories -->
    <div style="margin-bottom: 30px; padding: 20px 0; border-bottom: 1px solid var(--gl-gray-light);">
        <div style="display: flex; justify-content: center; align-items: center; gap: 8px; flex-wrap: wrap;">
            <a 
                href="/products" 
                class="category-filter <?= $selectedCategoryId === 0 ? 'active' : '' ?>"
                style="padding: 10px 20px; text-decoration: none; color: <?= $selectedCategoryId === 0 ? 'var(--gl-black)' : 'var(--gl-gray-dark)' ?>; background: <?= $selectedCategoryId === 0 ? 'var(--gl-gold)' : 'transparent' ?>; border: 1px solid <?= $selectedCategoryId === 0 ? 'var(--gl-gold)' : 'var(--gl-gray-medium)' ?>; border-radius: 2px; font-size: 13px; letter-spacing: 1px; font-weight: <?= $selectedCategoryId === 0 ? '600' : '400' ?>; transition: all 0.3s ease;"
                onmouseover="if(!'<?= $selectedCategoryId === 0 ? 'active' : '' ?>') { this.style.borderColor='var(--gl-black)'; this.style.color='var(--gl-black)'; }"
                onmouseout="if(!'<?= $selectedCategoryId === 0 ? 'active' : '' ?>') { this.style.borderColor='var(--gl-gray-medium)'; this.style.color='var(--gl-gray-dark)'; }"
            >
                TOUS LES PRODUITS
            </a>
            
            <?php foreach ($categories as $category): ?>
                <a 
                    href="/products?categorie=<?= htmlspecialchars($category['id']) ?>" 
                    class="category-filter <?= $selectedCategoryId === (int)$category['id'] ? 'active' : '' ?>"
                    style="padding: 10px 20px; text-decoration: none; color: <?= $selectedCategoryId === (int)$category['id'] ? 'var(--gl-black)' : 'var(--gl-gray-dark)' ?>; background: <?= $selectedCategoryId === (int)$category['id'] ? 'var(--gl-gold)' : 'transparent' ?>; border: 1px solid <?= $selectedCategoryId === (int)$category['id'] ? 'var(--gl-gold)' : 'var(--gl-gray-medium)' ?>; border-radius: 2px; font-size: 13px; letter-spacing: 1px; font-weight: <?= $selectedCategoryId === (int)$category['id'] ? '600' : '400' ?>; transition: all 0.3s ease;"
                    onmouseover="if(<?= $selectedCategoryId !== (int)$category['id'] ? 'true' : 'false' ?>) { this.style.borderColor='var(--gl-black)'; this.style.color='var(--gl-black)'; }"
                    onmouseout="if(<?= $selectedCategoryId !== (int)$category['id'] ? 'true' : 'false' ?>) { this.style.borderColor='var(--gl-gray-medium)'; this.style.color='var(--gl-gray-dark)'; }"
                >
                    <?= strtoupper(htmlspecialchars($category['nom'])) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="section-header">
        <h2 class="section-title"><?= htmlspecialchars($title) ?></h2>
        <a href="/products/create" class="btn btn-gold">
            Ajouter un produit
        </a>
    </div>
    
    <?php if (empty($products)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">◇</div>
            <p class="empty-state-text">Aucun produit disponible dans le catalogue.</p>
            <a href="/products/create" class="btn btn-primary">Créer le premier produit</a>
        </div>
    <?php else: ?>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <!-- Image du produit -->
                    <?php if (!empty($product['image_url'])): ?>
                        <div class="product-image-container">
                            <img 
                                src="<?= htmlspecialchars($product['image_url']) ?>" 
                                alt="<?= htmlspecialchars($product['nom']) ?>" 
                                class="product-image"
                                onerror="this.style.display='none'"
                            >
                            <?php if ((int)$product['stock'] < 5 && (int)$product['stock'] > 0): ?>
                                <div class="product-badge">Stock limité</div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="product-image-container" style="display: flex; align-items: center; justify-content: center; background-color: var(--gl-gray-light);">
                            <span style="color: var(--gl-gray-medium); font-size: 14px; letter-spacing: 1px;">AUCUNE IMAGE</span>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Informations du produit -->
                    <div class="product-content">
                        <h3 class="product-title">
                            <?= htmlspecialchars($product['nom']) ?>
                        </h3>
                        
                        <?php if (!empty($product['description'])): ?>
                            <p class="product-description">
                                <?= htmlspecialchars($product['description']) ?>
                            </p>
                        <?php endif; ?>
                        
                        <div class="product-footer">
                            <div class="product-price-container">
                                <div class="product-price">
                                    <?= number_format((float)$product['prix'], 2, ',', ' ') ?> €
                                </div>
                                <div class="product-stock">
                                    Stock: <?= htmlspecialchars($product['stock']) ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Formulaire d'ajout au panier -->
                        <?php if ((int)$product['stock'] > 0): ?>
                            <form method="POST" action="/cart/add" style="margin-top: 15px;">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <input 
                                        type="number" 
                                        name="quantite" 
                                        value="1" 
                                        min="1" 
                                        max="<?= htmlspecialchars($product['stock']) ?>"
                                        style="width: 60px; padding: 8px; border: 1px solid var(--gl-gray-medium); border-radius: 2px;"
                                    >
                                    <button type="submit" class="btn btn-primary" style="flex: 1;">
                                        Ajouter au panier
                                    </button>
                                </div>
                            </form>
                        <?php else: ?>
                            <div style="margin-top: 15px; padding: 10px; background-color: #f8d7da; color: #721c24; border-radius: 2px; text-align: center; font-size: 12px; letter-spacing: 0.5px;">
                                RUPTURE DE STOCK
                            </div>
                        <?php endif; ?>
                        
                        <div style="margin-top: 10px; font-size: 11px; color: var(--gl-gray-dark); letter-spacing: 0.5px;">
                            ID: <?= htmlspecialchars($product['id']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div style="margin-top: 40px; text-align: center;">
        <a href="/" class="btn btn-outline">Retour à l'accueil</a>
    </div>
</div>

