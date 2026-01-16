<!-- Formulaire pour créer un nouveau produit -->
<div class="main-container" style="max-width: 700px;">
    <div class="section-header" style="border-bottom: 2px solid var(--gl-gold); margin-bottom: 30px;">
        <h2 class="section-title">Ajouter un produit</h2>
    </div>
    
    <!-- Message de succès ou d'erreur -->
    <?php if (isset($message)): ?>
        <div class="alert <?= isset($success) && $success ? 'alert-success' : 'alert-error' ?>">
            <?= isset($success) && $success ? '✓ ' : '× ' ?><?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="/products" style="background: var(--gl-white); border: 1px solid var(--gl-gray-medium); padding: 40px;">
        <div class="form-group">
            <label for="nom" class="form-label">Nom du produit</label>
            <input 
                type="text" 
                id="nom" 
                name="nom" 
                required 
                maxlength="150"
                value="<?= isset($old_values['nom']) ? htmlspecialchars($old_values['nom']) : '' ?>"
                class="form-control"
                placeholder="Entrez le nom du produit"
            >
        </div>
        
        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea 
                id="description" 
                name="description" 
                rows="4"
                class="form-control"
                placeholder="Entrez la description du produit (optionnel)"
            ><?= isset($old_values['description']) ? htmlspecialchars($old_values['description']) : '' ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="prix" class="form-label">Prix (€)</label>
            <input 
                type="number" 
                id="prix" 
                name="prix" 
                required 
                step="0.01"
                min="0"
                value="<?= isset($old_values['prix']) ? htmlspecialchars($old_values['prix']) : '' ?>"
                class="form-control"
                placeholder="0.00"
            >
        </div>
        
        <div class="form-group">
            <label for="stock" class="form-label">Stock</label>
            <input 
                type="number" 
                id="stock" 
                name="stock" 
                required 
                min="0"
                value="<?= isset($old_values['stock']) ? htmlspecialchars($old_values['stock']) : '' ?>"
                class="form-control"
                placeholder="0"
            >
        </div>
        
        <div class="form-group">
            <label for="image_url" class="form-label">URL de l'image</label>
            <input 
                type="url" 
                id="image_url" 
                name="image_url" 
                value="<?= isset($old_values['image_url']) ? htmlspecialchars($old_values['image_url']) : '' ?>"
                class="form-control"
                placeholder="https://exemple.com/image.jpg"
            >
            <small style="display: block; margin-top: 8px; color: var(--gl-gray-dark); font-size: 12px; letter-spacing: 0.3px;">Entrez l'URL complète de l'image (optionnel)</small>
        
        <!-- Aperçu de l'image si une URL est fournie -->
        <?php if (!empty($old_values['image_url']) && filter_var($old_values['image_url'], FILTER_VALIDATE_URL)): ?>
            <div class="form-group">
                <label class="form-label">Aperçu de l'image</label>
                <div style="border: 1px solid var(--gl-gray-medium); padding: 20px; text-align: center; background: var(--gl-gray-light);">
                    <img 
                        src="<?= htmlspecialchars($old_values['image_url']) ?>" 
                        alt="Aperçu" 
                        style="max-width: 100%; max-height: 300px; object-fit: contain;"
                        onerror="this.style.display='none'"
                    >
                </div>
            </div>
        <?php endif; ?>
        
        <button type="submit" class="btn btn-gold" style="width: 100%; margin-top: 10px;">
            Créer le produit
        </button>
    </form>
    
    <div style="margin-top: 30px; display: flex; gap: 20px; justify-content: center;">
        <a href="/products" class="btn btn-outline">Voir le catalogue</a>
        <a href="/" class="btn btn-outline">Retour à l'accueil</a>
    </div>
</div>
