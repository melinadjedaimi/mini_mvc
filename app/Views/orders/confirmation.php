<div style="max-width: 600px; margin: 0 auto; padding: 20px; text-align:center;">
    <h1>Merci pour votre commande !</h1>
    <p style="margin-top:10px;">
        Votre commande n° <strong>#<?= htmlspecialchars((string)$orderId) ?></strong> a été enregistrée.
    </p>
    <p style="margin-top:5px; font-size:18px;">
        Montant total : <strong><?= number_format((float)$total, 2, ',', ' ') ?> €</strong>
    </p>

    <div style="margin-top:25px;">
        <a href="/mes-commandes" style="margin-right:15px; color:#007bff; text-decoration:none;">
            Voir mes commandes
        </a>
        <a href="/" style="color:#007bff; text-decoration:none;">
            Revenir à l'accueil
        </a>
    </div>
</div>


