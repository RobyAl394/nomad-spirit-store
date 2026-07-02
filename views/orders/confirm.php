<?php $pageTitle = 'Commande Confirmée !'; require __DIR__ . '/../layout/header.php'; ?>
<section class="confirm-page">
    <div class="confirm-box">
        <div class="confirm-icon">✓</div>
        <h1>Commande Confirmée !</h1>
        <p class="confirm-msg">Merci pour votre commande. Nous vous contacterons bientôt.</p>
        <div class="order-number-box">
            <span>Numéro de Commande :</span>
            <strong>#<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></strong>
        </div>

<div class="confirm-details">
            <h3>Détails de votre commande</h3>

            <?php foreach ($orderItems as $item): ?>
                <div class="confirm-item">
                    <span class="confirm-item-name">
                        <?= htmlspecialchars($item['product_name']) ?>
                        × <?= (int)$item['quantity'] ?>
                    </span>
                    <span class="confirm-item-price">
                        <?= number_format($item['price'] * $item['quantity'], 2) ?> MAD
                    </span>
                </div>
            <?php endforeach; ?>
            <div class="confirm-total">
                <strong>Total : <?= number_format($order['total'], 2) ?> MAD</strong>
            </div>
<div class="confirm-address">
                <strong>Livraison à :</strong>
                <p><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
            </div>
<div class="confirm-status">
                <strong>Statut :</strong>
                <span class="status-badge status-pending">En attente</span>
            </div>
        </div>
<div class="confirm-actions">
            <a href="index.php" class="btn-primary">Accueil</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php?page=my-orders" class="btn-ghost">Mes Commandes</a>
            <?php endif; ?>
        </div>
    </div>

</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
