<div class="main-container">
    <!-- Carrousel moderne -->
    <section class="carousel-container">
        <div class="carousel">
            <div class="carousel-slide active" data-slide="0">
                <div class="carousel-image" style="background-image: url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1600&h=600&fit=crop');"></div>
                <div class="carousel-overlay"></div>
                <div class="carousel-content">
                    <div class="carousel-label">Collection 2026</div>
                    <h2 class="carousel-title">Nouvelle Collection</h2>
                    <p class="carousel-text">Élégance intemporelle</p>
                    <a href="/products" class="carousel-cta">Découvrir</a>
                </div>
            </div>
            <div class="carousel-slide" data-slide="1">
                <div class="carousel-image" style="background-image: url('https://images.unsplash.com/photo-1483985988355-763728e1935b?w=1600&h=600&fit=crop');"></div>
                <div class="carousel-overlay"></div>
                <div class="carousel-content">
                    <div class="carousel-label">Éco-responsable</div>
                    <h2 class="carousel-title">Mode Durable</h2>
                    <p class="carousel-text">Style & responsabilité</p>
                    <a href="/products" class="carousel-cta">Explorer</a>
                </div>
            </div>
            <div class="carousel-slide" data-slide="2">
                <div class="carousel-image" style="background-image: url('https://images.unsplash.com/photo-1445205170230-053b83016050?w=1600&h=600&fit=crop');"></div>
                <div class="carousel-overlay"></div>
                <div class="carousel-content">
                    <div class="carousel-label">Exclusif</div>
                    <h2 class="carousel-title">Pièces Uniques</h2>
                    <p class="carousel-text">Trouvez votre style</p>
                    <a href="/products" class="carousel-cta">Voir plus</a>
                </div>
            </div>
        </div>
        <button class="carousel-nav carousel-prev" onclick="moveCarousel(-1)" aria-label="Précédent">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>
        <button class="carousel-nav carousel-next" onclick="moveCarousel(1)" aria-label="Suivant">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>
        <div class="carousel-indicators">
            <button class="indicator active" onclick="currentSlide(0)" aria-label="Slide 1"></button>
            <button class="indicator" onclick="currentSlide(1)" aria-label="Slide 2"></button>
            <button class="indicator" onclick="currentSlide(2)" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-progress">
            <div class="carousel-progress-bar"></div>
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
