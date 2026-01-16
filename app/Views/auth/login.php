<div class="main-container" style="max-width: 500px;">
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="font-size: 32px; font-weight: 300; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 10px;">Connexion</h1>
        <div style="height: 2px; width: 60px; background: var(--gl-gold); margin: 0 auto;"></div>
    </div>

    <?php if (!empty($error ?? '')): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/login" style="background: var(--gl-white); border: 1px solid var(--gl-gray-medium); padding: 40px;">
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
                class="form-control"
            >
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">
            Me connecter
        </button>
    </form>

    <p style="margin-top:25px; font-size:13px; text-align: center; letter-spacing: 0.5px;">
        Pas encore de compte ?
        <a href="/register" style="color: var(--gl-gold); text-decoration: none; font-weight: 500;">Créer un compte</a>
    </p>
</div>


