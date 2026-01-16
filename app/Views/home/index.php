<div class="main-container">
    <!-- Carrousel d'images -->
    <section class="carousel-container">
        <div class="carousel">
            <div class="carousel-slide active">
                <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1200&h=500&fit=crop" alt="Collection Mareva 1">
                <div class="carousel-caption">
                    <h2>Nouvelle Collection</h2>
                    <p>Élégance intemporelle</p>
                </div>
            </div>
            <div class="carousel-slide">
                <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?w=1200&h=500&fit=crop" alt="Collection Mareva 2">
                <div class="carousel-caption">
                    <h2>Mode Durable</h2>
                    <p>Style & responsabilité</p>
                </div>
            </div>
            <div class="carousel-slide">
                <img src="https://images.unsplash.com/photo-1445205170230-053b83016050?w=1200&h=500&fit=crop" alt="Collection Mareva 3">
                <div class="carousel-caption">
                    <h2>Pièces Uniques</h2>
                    <p>Trouvez votre style</p>
                </div>
            </div>
        </div>
        <button class="carousel-btn carousel-prev" onclick="moveCarousel(-1)">‹</button>
        <button class="carousel-btn carousel-next" onclick="moveCarousel(1)">›</button>
        <div class="carousel-dots">
            <span class="dot active" onclick="currentSlide(0)"></span>
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
        </div>
    </section>

    <?php if (empty($products)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">◇</div>
            <p class="empty-state-text">Notre collection sera bientôt disponible.</p>
            <a href="/products/create" class="btn btn-gold">Proposer un article</a>
        </div>
    <?php else: ?>
        <section>
            <div class="section-header">
                <h2 class="section-title">Découvrez nos produits</h2>
            </div>
            <div class="products-grid">
                <?php foreach ($products as $product): ?>
                    <article class="product-card">
                        <?php if (!empty($product['image_url'])): ?>
                            <a href="/product?id=<?= htmlspecialchars($product['id']) ?>" class="product-image-container">
                                <img
                                    src="<?= htmlspecialchars($product['image_url']) ?>"
                                    alt="<?= htmlspecialchars($product['nom']) ?>"
                                    class="product-image"
                                    onerror="this.style.display='none'"
                                >
                                <?php if ((int)$product['stock'] < 5 && (int)$product['stock'] > 0): ?>
                                    <div class="product-badge">Dernières pièces</div>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>

                        <div class="product-content">
                            <h3 class="product-title">
                                <a href="/product?id=<?= htmlspecialchars($product['id']) ?>">
                                    <?= htmlspecialchars($product['nom']) ?>
                                </a>
                            </h3>

                            <?php if (!empty($product['description'])): ?>
                                <p class="product-description">
                                    <?= htmlspecialchars(substr($product['description'], 0, 100)) . (strlen($product['description']) > 100 ? '...' : '') ?>
                                </p>
                            <?php endif; ?>

                            <div class="product-footer">
                                <div class="product-price-container">
                                    <div class="product-price">
                                        <?= number_format((float)$product['prix'], 2, ',', ' ') ?> €
                                    </div>
                                    <div class="product-stock">Stock : <?= htmlspecialchars($product['stock']) ?></div>
                                </div>

                                <div class="product-actions">
                                    <form method="POST" action="/cart/add" style="margin:0;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
                                        <button type="submit" class="btn-icon" title="Ajouter au panier">
                                            🛒
                                        </button>
                                    </form>
                                    <a href="/product?id=<?= htmlspecialchars($product['id']) ?>" class="btn-icon" title="Voir le détail">
                                        →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</div>
