<?php
// Vue : détail d'un produit
?>
<div class="main-container">
    <div style="display:flex; flex-wrap:wrap; gap:40px; max-width: 1200px; margin: 0 auto;">
        <div style="flex:1 1 450px;">
            <?php if (!empty($product['image_url'])): ?>
                <div class="product-image-container" style="aspect-ratio: 3/4;">
                    <img
                        src="<?= htmlspecialchars($product['image_url']) ?>"
                        alt="<?= htmlspecialchars($product['nom']) ?>"
                        class="product-image"
                        onerror="this.style.display='none'"
                    >
                </div>
            <?php else: ?>
                <div class="product-image-container" style="aspect-ratio: 3/4; display:flex; align-items:center; justify-content:center; background: var(--gl-gray-light); border: 2px dashed var(--gl-gray-medium);">
                    <span style="color: var(--gl-gray-medium); font-size: 14px; letter-spacing: 1px;">AUCUNE IMAGE DISPONIBLE</span>
                </div>
            <?php endif; ?>
        </div>

        <div style="flex:1 1 450px;">
            <h1 style="margin-top:0; margin-bottom:20px; font-size: 32px; font-weight: 300; letter-spacing: 1px; text-transform: uppercase;"><?= htmlspecialchars($product['nom']) ?></h1>

            <div style="font-size:36px; font-weight:400; color: var(--gl-black); margin-bottom:20px; padding-bottom: 20px; border-bottom: 2px solid var(--gl-gold);">
                <?= number_format((float)$product['prix'], 2, ',', ' ') ?> €
            </div>

            <div style="margin-bottom:25px; font-size:12px; color: var(--gl-gray-dark); letter-spacing: 1px; text-transform: uppercase;">
                Stock disponible : <?= htmlspecialchars($product['stock']) ?>
            </div>

            <?php if (!empty($product['description'])): ?>
                <p style="margin-bottom:30px; line-height:1.8; color: var(--gl-text); font-size: 15px;">
                    <?= nl2br(htmlspecialchars($product['description'])) ?>
                </p>
            <?php endif; ?>

            <form method="POST" action="/cart/add" style="margin-bottom:25px; border-top: 1px solid var(--gl-gray-medium); padding-top: 25px;">
                <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
                <div class="form-group">
                    <label for="quantite" class="form-label">Quantité</label>
                    <input
                        type="number"
                        id="quantite"
                        name="quantite"
                        value="1"
                        min="1"
                        max="<?= (int)$product['stock'] ?>"
                        class="form-control"
                        style="width:120px; display: inline-block; margin-right: 15px;"
                    >
                    <button type="submit" class="btn btn-primary">
                        Ajouter au panier
                    </button>
                </div>
            </form>

            <div style="display: flex; gap: 15px; margin-top: 30px;">
                <a href="/cart" class="btn btn-outline">
                    Voir mon panier
                </a>
                <a href="/products" class="btn btn-outline">
                    Retour au catalogue
                </a>
            </div>
        </div>
    </div>
</div>


