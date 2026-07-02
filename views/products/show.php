<?php $pageTitle = $product['name']; require __DIR__ . '/../layout/header.php'; ?>

<section class="product-page">

<div class="product-breadcrumb">
        <a href="index.php">Accueil</a> /
        <a href="index.php?page=products">Boutique</a> /
        <?php if (!empty($product['category_name'])): ?>
            <a href="index.php?page=products&slug=<?= htmlspecialchars($product['category_slug'] ?? '') ?>">
                <?= htmlspecialchars($product['category_name']) ?>
            </a> /
        <?php endif; ?>
        <span><?= htmlspecialchars($product['name']) ?></span>
    </div>

<div class="product-layout">

<div class="product-gallery">
            <div class="product-main-img">
                <?php if (!empty($product['image']) && file_exists($product['image'])): ?>
                    <img src="<?= htmlspecialchars($product['image']) ?>"
                         alt="<?= htmlspecialchars($product['name']) ?>"
                         id="mainProductImg">
                <?php else: ?>
                    <div class="prod-img-placeholder prod-color-<?= ($product['id'] % 4) + 1 ?>"
                         style="height:500px;">
                        <svg width="80" height="90" viewBox="0 0 60 70" fill="none">
                            <path d="M30 6 L48 18 L48 60 L30 64 L12 60 L12 18 Z"
                                  stroke="currentColor" stroke-width="1.2" fill="none" opacity="0.4"/>
                        </svg>
                    </div>
                <?php endif; ?>
            </div>
        </div>

<div class="product-info">

<div class="product-category-tag">
                <?= htmlspecialchars($product['category_name'] ?? '') ?>
            </div>

<h1 class="product-title"><?= htmlspecialchars($product['name']) ?></h1>

<div class="product-price-row">
                <span class="product-price"><?= number_format($product['price'], 2) ?> MAD</span>
                <?php if (!empty($product['old_price'])): ?>
                    <span class="product-old-price"><?= number_format($product['old_price'], 2) ?> MAD</span>
                    <?php
                    $discount = round((($product['old_price'] - $product['price']) / $product['old_price']) * 100);
                    ?>
                    <span class="discount-badge">-<?= $discount ?>%</span>
                <?php endif; ?>
            </div>

<div class="product-stock">
                <?php if ($product['stock'] > 0): ?>
                    <span class="in-stock">✓ En stock (<?= $product['stock'] ?> disponibles)</span>
                <?php else: ?>
                    <span class="out-stock">✗ Rupture de stock</span>
                <?php endif; ?>
            </div>

<?php if (!empty($product['description'])): ?>
                <div class="product-description">
                    <h3>Description</h3>
                    <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                </div>
            <?php endif; ?>

<?php if ($product['stock'] > 0): ?>
                <form method="POST" action="index.php?page=cart-add" class="product-add-form">
                    <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">

<div class="qty-selector">
                        <label for="qty">Quantité</label>
                        <div class="qty-controls">
                            <button type="button" onclick="changeQty(-1)">−</button>
                            <input type="number"
                                   id="qty"
                                   name="qty"
                                   value="1"
                                   min="1"
                                   max="<?= $product['stock'] ?>">
                            <button type="button" onclick="changeQty(1)">+</button>
                        </div>
                    </div>

                    <button type="submit" class="btn-add-cart">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                            <line x1="3" y1="6" x2="21" y2="6"/>
                            <path d="M16 10a4 4 0 0 1-8 0"/>
                        </svg>
                        Ajouter au Panier
                    </button>
                </form>
            <?php else: ?>
                <button class="btn-add-cart disabled" disabled>Rupture de stock</button>
            <?php endif; ?>

        </div>
    </div>

<?php if (!empty($relatedProducts)): ?>
        <section class="related-products">
            <h2>Vous pourriez aussi aimer</h2>
            <div class="prod-grid">
                <?php foreach ($relatedProducts as $rp): ?>
                    <div class="prod-card">
                        <div class="prod-img">
                            <?php if (!empty($rp['image']) && file_exists($rp['image'])): ?>
                                <img src="<?= htmlspecialchars($rp['image']) ?>"
                                     alt="<?= htmlspecialchars($rp['name']) ?>"
                                     loading="lazy">
                            <?php else: ?>
                                <div class="prod-img-placeholder prod-color-<?= ($rp['id'] % 4) + 1 ?>"></div>
                            <?php endif; ?>
                        </div>
                        <div class="prod-info">
                            <a href="index.php?page=product&id=<?= (int)$rp['id'] ?>" class="prod-name">
                                <?= htmlspecialchars($rp['name']) ?>
                            </a>
                            <div class="prod-footer">
                                <span class="prod-price"><?= number_format($rp['price'], 2) ?> MAD</span>
                                <form method="POST" action="index.php?page=cart-add">
                                    <input type="hidden" name="product_id" value="<?= (int)$rp['id'] ?>">
                                    <input type="hidden" name="qty" value="1">
                                    <button type="submit" class="prod-add">Ajouter au Panier</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

</section>

<script>
// Changer la quantité avec les boutons + et -
function changeQty(delta) {
    const input = document.getElementById('qty');
    const max   = parseInt(input.max) || 99;
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > max) val = max;
    input.value = val;
}
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
