<?php $pageTitle = 'Votre Panier'; require __DIR__ . '/../layout/header.php'; ?>
<section class="cart-page">
    <div class="page-title-wrap">
        <h1>Votre Panier</h1>
    </div>
    <?php if (empty($cartItems)): ?>
<div class="empty-state">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1">
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                <line x1="3" y1="6" x2="21" y2="6"/>
                <path d="M16 10a4 4 0 0 1-8 0"/>
            </svg>
            <p>Votre panier est vide.</p>
            <a href="index.php?page=products" class="btn-primary">Continuer les Achats</a>
        </div>
    <?php else: ?>
        <div class="cart-layout">
<div class="cart-items">
<form method="POST" action="index.php?page=cart-update" id="cartForm">
                    <?php foreach ($cartItems as $productId => $item): ?>
                        <div class="cart-item">
<div class="cart-item-img">
                                <?php if (!empty($item['image']) && file_exists($item['image'])): ?>
                                    <img src="<?= htmlspecialchars($item['image']) ?>"
                                         alt="<?= htmlspecialchars($item['name']) ?>">
                                <?php else: ?>
                                    <div class="cart-img-placeholder"></div>
                                <?php endif; ?>
                            </div>
<div class="cart-item-info">
                                <h3>
                                    <a href="index.php?page=product&id=<?= (int)$productId ?>">
                                        <?= htmlspecialchars($item['name']) ?>
                                    </a>
                                </h3>
                                <p class="cart-item-price"><?= number_format($item['price'], 2) ?> MAD</p>
                            </div>
<div class="cart-qty">
                                <button type="button" onclick="updateQty(this, -1)">−</button>
                                <input type="number"
                                       name="qty[<?= (int)$productId ?>]"
                                       value="<?= (int)$item['qty'] ?>"
                                       min="0"
                                       max="99"
                                       class="cart-qty-input"
                                       onchange="this.form.submit()">
                                <button type="button" onclick="updateQty(this, 1)">+</button>
                            </div>
<div class="cart-item-subtotal">
                                <?= number_format($item['price'] * $item['qty'], 2) ?> MAD
                            </div>
<a href="index.php?page=cart-remove&id=<?= (int)$productId ?>"
                               class="cart-remove"
                               title="Supprimer"
                               onclick="return confirm('Supprimer ?')">
                                ✕
                            </a>
                        </div>
                    <?php endforeach; ?>
                    <div class="cart-actions">
                        <a href="index.php?page=products" class="btn-ghost">Continuer les Achats</a>
                        <button type="submit" class="btn-outline-dark">Mettre à jour</button>
                    </div>
                </form>
            </div>
<div class="cart-summary">
                <h3>Résumé</h3>
                <div class="summary-row">
                    <span>Sous-total</span>
                    <span><?= number_format($subtotal, 2) ?> MAD</span>
                </div>
                <div class="summary-row">
                    <span>Livraison</span>
                    <?php if ($shippingCost === 0): ?>
                        <span class="free-shipping">✓ Gratuit</span>
                    <?php else: ?>
                        <span><?= number_format($shippingCost, 2) ?> MAD</span>
                    <?php endif; ?>
                </div>
                <?php if ($subtotal < 150 && $shippingCost > 0): ?>
                    <p class="shipping-notice">
                        Ajoutez <?= number_format(150 - $subtotal, 2) ?> MAD pour la livraison gratuite !
                    </p>
                <?php endif; ?>
                <div class="summary-row summary-total">
                    <span>Total</span>
                    <span><?= number_format($total, 2) ?> MAD</span>
                </div>
                <a href="index.php?page=checkout" class="btn-primary btn-full">
                    Passer la Commande →
                </a>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <p class="cart-login-note">
                        <a href="index.php?page=login">Connexion</a> pour enregistrer votre commande.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</section>
<script>
function updateQty(btn, delta) {
    const input = btn.parentElement.querySelector('input');
    let val = parseInt(input.value) + delta;
    if (val < 0) val = 0;
    input.value = val;
    document.getElementById('cartForm').submit();
}
</script>
<?php require __DIR__ . '/../layout/footer.php'; ?>
