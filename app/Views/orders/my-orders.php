<div style="max-width: 900px; margin: 0 auto; padding: 20px;">
    <h1 style="margin-bottom: 20px;">Mes commandes</h1>

    <?php if (empty($orders)): ?>
        <div style="padding: 30px; background:#f8f9fa; border-radius:6px;">
            <p style="margin:0; color:#666;">Vous n'avez pas encore passé de commande.</p>
        </div>
    <?php else: ?>
        <?php foreach ($orders as $entry): ?>
            <?php $order = $entry['order']; ?>
            <?php $items = $entry['items']; ?>
            <div style="border:1px solid #ddd; border-radius:6px; padding:15px; margin-bottom:15px; background:#fff;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                    <div>
                        <strong>Commande #<?= htmlspecialchars($order['id']) ?></strong><br>
                        <small style="color:#777;">
                            Passée le <?= htmlspecialchars($order['created_at']) ?>
                        </small>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:18px; font-weight:bold;">
                            <?= number_format((float)$order['total'], 2, ',', ' ') ?> €
                        </div>
                        <div style="font-size:13px; color:#555;">
                            Statut : <?= htmlspecialchars($order['statut']) ?>
                        </div>
                    </div>
                </div>

                <?php if (!empty($items)): ?>
                    <table style="width:100%; border-collapse:collapse; margin-top:10px;">
                        <thead>
                            <tr style="background:#f1f1f1;">
                                <th style="padding:8px; text-align:left;">Article</th>
                                <th style="padding:8px; text-align:center;">Qté</th>
                                <th style="padding:8px; text-align:right;">Prix</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td style="padding:8px; border-bottom:1px solid #eee;">
                                        <?= htmlspecialchars($item['nom']) ?>
                                    </td>
                                    <td style="padding:8px; border-bottom:1px solid #eee; text-align:center;">
                                        <?= (int)$item['quantite'] ?>
                                    </td>
                                    <td style="padding:8px; border-bottom:1px solid #eee; text-align:right;">
                                        <?= number_format((float)$item['prix_unitaire'], 2, ',', ' ') ?> €
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div style="margin-top:20px;">
        <a href="/" style="color:#007bff; text-decoration:none;">← Retour à l'accueil</a>
    </div>
</div>


