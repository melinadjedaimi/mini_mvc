<div class="main-container">
    <div class="section-header">
        <h2 class="section-title">Mon Panier</h2>
    </div>

    <?php if (empty($items)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">🛒</div>
            <p class="empty-state-text">Votre panier est vide.</p>
            <a href="/" class="btn btn-gold">Découvrir notre collection</a>
        </div>
    <?php else: ?>
        <div class="cart-container">
            <?php foreach ($items as $row): ?>
                <?php $p = $row['product']; ?>
                <div class="cart-item">
                    <?php if (!empty($p['image_url'])): ?>
                        <img src="<?= htmlspecialchars($p['image_url']) ?>" alt="<?= htmlspecialchars($p['nom']) ?>" class="cart-item-image" onerror="this.style.display='none'">
                    <?php else: ?>
                        <div class="cart-item-image" style="background: var(--gl-gray-light); display: flex; align-items: center; justify-content: center;">
                            <span style="color: var(--gl-gray-medium); font-size: 12px;">◇</span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="cart-item-details">
                        <div>
                            <h3 class="cart-item-title"><?= htmlspecialchars($p['nom']) ?></h3>
                            <div style="font-size: 11px; color: var(--gl-gray-dark); letter-spacing: 0.5px; margin-bottom: 10px;">ID #<?= htmlspecialchars($p['id']) ?></div>
                            <div style="font-size: 14px; color: var(--gl-text); margin-bottom: 8px;">Quantité : <?= (int)$row['quantity'] ?></div>
                            <div style="font-size: 13px; color: var(--gl-gray-dark);">Prix unitaire : <?= number_format((float)$p['prix'], 2, ',', ' ') ?> €</div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div class="cart-item-price"><?= number_format((float)$row['lineTotal'], 2, ',', ' ') ?> €</div>
                            <form method="POST" action="/cart/remove" style="display:inline;">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($p['id']) ?>">
                                <button type="submit" class="btn btn-outline" style="padding: 8px 16px; font-size: 11px;">
                                    Retirer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-summary">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <form method="POST" action="/cart/clear">
                    <button type="submit" class="btn btn-outline" style="padding: 10px 20px;">
                        Vider le panier
                    </button>
                </form>
            </div>

            <div class="cart-total">
                <div class="cart-total-label">Total</div>
                <div class="cart-total-amount"><?= number_format((float)$total, 2, ',', ' ') ?> €</div>
            </div>

            <div style="display:flex; gap: 15px; margin-top:30px; flex-wrap: wrap;">
                <a href="/" class="btn btn-outline" style="flex: 1;">Continuer mes achats</a>
                <form method="POST" action="/checkout" style="flex: 1;">
                    <button type="submit" class="btn btn-gold" style="width: 100%;">
                        Valider ma commande
                    </button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>


