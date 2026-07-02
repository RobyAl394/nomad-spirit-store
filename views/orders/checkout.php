<?php $pageTitle = 'Finaliser la Commande'; require __DIR__ . '/../layout/header.php'; ?>
<section class="checkout-page">
    <div class="page-title-wrap">
        <h1>Finaliser la Commande</h1>
    </div>
<?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
<?php if (!isset($_SESSION['user_id'])): ?>
        <div class="guest-note">
            <p>
                Vous commandez en tant qu'invité. Créez un compte pour suivre vos commandes.
                <a href="index.php?page=login">Connexion</a> /
                <a href="index.php?page=signup">Inscription</a>
            </p>
        </div>
    <?php endif; ?>

    <div class="checkout-layout">

<form method="POST" action="index.php?page=place-order" class="checkout-form">

            <h2>Informations de Livraison</h2>

            <div class="form-row">
                <div class="form-group">
                    <label for="name">Votre Nom *</label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="<?= htmlspecialchars($prefill['name'] ?? '') ?>"
                           placeholder="Votre nom complet"
                           required>
                </div>

                <div class="form-group">
                    <label for="phone">Votre Téléphone</label>
                    <input type="tel"
                           id="phone"
                           name="phone"
                           value="<?= htmlspecialchars($prefill['phone'] ?? '') ?>"
                           placeholder="+212 6XX XX XX XX">
                </div>
            </div>

            <div class="form-group">
                <label for="email">Votre Email *</label>
                <input type="email"
                       id="email"
                       name="email"
                       value="<?= htmlspecialchars($prefill['email'] ?? '') ?>"
                       placeholder="exemple@email.com"
                       required>
            </div>

            <div class="form-group">
                <label for="address">Adresse de Livraison *</label>
                <textarea id="address"
                          name="address"
                          rows="4"
                          placeholder="N° de rue, ville, code postal, pays"
                          required><?= htmlspecialchars($prefill['address'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn-primary btn-full">
                ✓ Confirmer la Commande
            </button>

        </form>

<div class="checkout-summary">
            <h2>Résumé de la Commande</h2>

            <div class="checkout-items">
                <?php foreach ($cartItems as $item): ?>
                    <div class="checkout-item">
                        <?php if (!empty($item['image']) && file_exists($item['image'])): ?>
                            <img src="<?= htmlspecialchars($item['image']) ?>"
                                 alt="<?= htmlspecialchars($item['name']) ?>">
                        <?php else: ?>
                            <div class="checkout-img-placeholder"></div>
                        <?php endif; ?>
                        <div class="checkout-item-info">
                            <span class="checkout-item-name"><?= htmlspecialchars($item['name']) ?></span>
                            <span class="checkout-item-qty">× <?= (int)$item['qty'] ?></span>
                        </div>
                        <span class="checkout-item-price">
                            <?= number_format($item['price'] * $item['qty'], 2) ?> MAD
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="summary-row">
                <span>Sous-total</span>
                <span><?= number_format($subtotal, 2) ?> MAD</span>
            </div>
            <div class="summary-row">
                <span>Livraison</span>
                <span><?= $shippingCost === 0 ? 'Gratuit' : number_format($shippingCost, 2).' MAD' ?></span>
            </div>
            <div class="summary-row summary-total">
                <span>Total</span>
                <span><?= number_format($total, 2) ?> MAD</span>
            </div>
        </div>

    </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
