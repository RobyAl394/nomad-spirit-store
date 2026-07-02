<?php $pageTitle = $currentCategory ? $currentCategory['name'] : 'Boutique'; require __DIR__ . '/../layout/header.php'; ?>

<section class="shop-page">

    <div class="shop-header">
        <div class="shop-breadcrumb">
            <a href="index.php">Accueil</a> /
            <?php if ($currentCategory): ?>
                <a href="index.php?page=products">Boutique</a> /
                <span><?= htmlspecialchars($currentCategory['name']) ?></span>
            <?php else: ?>
                <span>Boutique</span>
            <?php endif; ?>
        </div>

        <h1 class="shop-title">
            <?= htmlspecialchars($currentCategory ? $currentCategory['name'] : 'Boutique') ?>
        </h1>

        <?php if (!empty($keyword)): ?>
            <p class="search-results-info">
                Résultats pour : "<strong><?= htmlspecialchars($keyword) ?></strong>"
                (<?= count($products) ?> produit<?= count($products) > 1 ? 's' : '' ?>)
            </p>
        <?php else: ?>
            <p class="shop-count"><?= count($products) ?> pièces</p>
        <?php endif; ?>
    </div>

    <div class="shop-layout">

<main class="shop-products">

            <?php if (empty($products)): ?>
                <div class="empty-state">
                    <p>Aucun produit trouvé.</p>
                    <a href="index.php?page=products" class="btn-primary">Voir tous les produits</a>
                </div>
            <?php else: ?>
                <div class="prod-grid prod-grid-shop">
                    <?php foreach ($products as $p): ?>
                        <?php
                        $badgeClass = '';
                        $badgeText  = '';
                        if ($p['badge'] === 'new')  { $badgeClass = 'badge-new';  $badgeText = 'Nouveau'; }
                        if ($p['badge'] === 'sale') { $badgeClass = 'badge-sale'; $badgeText = 'Solde'; }
                        if ($p['badge'] === 'best') { $badgeClass = 'badge-best'; $badgeText = 'Best'; }
                        ?>
                        <div class="prod-card">
                            <div class="prod-img">
                                <?php if (!empty($p['image']) && file_exists($p['image'])): ?>
                                    <img src="<?= htmlspecialchars($p['image']) ?>"
                                         alt="<?= htmlspecialchars($p['name']) ?>"
                                         loading="lazy">
                                <?php else: ?>
                                    <div class="prod-img-placeholder prod-color-<?= ($p['id'] % 4) + 1 ?>">
                                        <svg width="60" height="70" viewBox="0 0 60 70" fill="none">
                                            <path d="M30 6 L48 18 L48 60 L30 64 L12 60 L12 18 Z"
                                                  stroke="currentColor" stroke-width="1.2" fill="none" opacity="0.4"/>
                                        </svg>
                                    </div>
                                <?php endif; ?>

                                <?php if ($badgeText): ?>
                                    <span class="prod-badge <?= $badgeClass ?>"><?= $badgeText ?></span>
                                <?php endif; ?>

                                <div class="prod-actions">
                                    <a href="index.php?page=product&id=<?= (int)$p['id'] ?>" class="action-btn">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <div class="prod-info">
                                <div class="prod-origin"><?= htmlspecialchars($p['category_name'] ?? '') ?></div>
                                <a href="index.php?page=product&id=<?= (int)$p['id'] ?>" class="prod-name">
                                    <?= htmlspecialchars($p['name']) ?>
                                </a>
        <?php if ($p['stock'] > 0): ?>
                                    <div class="prod-stock in-stock">✓ En stock</div>
                                <?php else: ?>
                                    <div class="prod-stock out-stock">✗ Rupture de stock</div>
                                <?php endif; ?>

                                <div class="prod-footer">
                                    <div class="prod-pricing">
                                        <span class="prod-price"><?= number_format($p['price'], 2) ?> MAD</span>
                                        <?php if (!empty($p['old_price'])): ?>
                                            <span class="prod-old"><?= number_format($p['old_price'], 2) ?> MAD</span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($p['stock'] > 0): ?>
                                        <form method="POST" action="index.php?page=cart-add">
                                            <input type="hidden" name="product_id" value="<?= (int)$p['id'] ?>">
                                            <input type="hidden" name="qty" value="1">
                                            <button type="submit" class="prod-add">Ajouter au Panier</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </main>
    </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
