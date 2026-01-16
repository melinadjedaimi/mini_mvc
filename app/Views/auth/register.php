<div class="main-container" style="max-width: 550px;">
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="font-size: 32px; font-weight: 300; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 10px;">Créer un compte</h1>
        <div style="height: 2px; width: 60px; background: var(--gl-gold); margin: 0 auto;"></div>
    </div>

    <?php if (!empty($errors ?? [])): ?>
        <div class="alert alert-error">
            <ul style="margin:0; padding-left:18px;">
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="/register" style="background: var(--gl-white); border: 1px solid var(--gl-gray-medium); padding: 40px;">
        <div class="form-group">
            <label for="nom" class="form-label">Nom</label>
            <input
                type="text"
                id="nom"
                name="nom"
                required
                value="<?= htmlspecialchars($old['nom'] ?? '') ?>"
                class="form-control"
            >
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                required
                value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                class="form-control"
            >
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Mot de passe</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                minlength="6"
                class="form-control"
            >
        </div>

        <div class="form-group">
            <label for="password_confirm" class="form-label">Confirmer le mot de passe</label>
            <input
                type="password"
                id="password_confirm"
                name="password_confirm"
                required
                minlength="6"
                class="form-control"
            >
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">
            M'inscrire
        </button>
    </form>

    <p style="margin-top:25px; font-size:13px; text-align: center; letter-spacing: 0.5px;">
        Déjà un compte ?
        <a href="/login" style="color: var(--gl-gold); text-decoration: none; font-weight: 500;">Se connecter</a>
    </p>
</div>


