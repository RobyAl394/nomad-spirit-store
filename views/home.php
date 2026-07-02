<?php $pageTitle = 'Accueil'; require __DIR__ . '/layout/header.php'; ?>
<section class="hero" id="heroSection">
    <div class="hero-left">
        <div class="hero-tag">Collection Patrimoine</div>
        <h1 class="hero-title">L'élégance du désert. Portée depuis des siècles.</h1>
        <p class="hero-desc">Découvrez la beauté profonde de la culture sahraouie à travers nos melhfas authentiques, daraas et accessoires.</p>
        <div class="hero-actions">
            <a href="index.php?page=products&slug=femmes" class="btn-primary">Explorer les Melhfas</a>
            <a href="index.php?page=products&slug=hommes" class="btn-ghost">Découvrir les Turbans</a>
        </div>
    </div>
    <div class="hero-right hero-right-bg"></div>
</section>
<section class="split-section">
    <div class="split-side split-left">
        <div class="split-overlay"></div>
        <div class="split-content">
            <h2>Femmes</h2>
            <p>Melhfas & Accessoires</p>
            <a href="index.php?page=products&slug=femmes" class="btn-primary">Boutique</a>
        </div>
    </div>
    <div class="split-side split-right">
        <div class="split-overlay"></div>
        <div class="split-content">
            <h2>Hommes</h2>
            <p>Tenues & Turbans</p>
            <a href="index.php?page=products&slug=hommes" class="btn-primary">Boutique</a>
        </div>
    </div>
</section>
<div class="trust-bar">
    <div class="trust-item">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
        <span>Retours gratuits sous 30 jours</span>
    </div>
    <div class="trust-item">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
        </svg>
        <span>Paiement sécurisé</span>
    </div>
    <div class="trust-item">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 8v4l3 3"/>
        </svg>
        <span>Expédition sous 3–5 jours</span>
    </div>
    <div class="trust-item">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
        </svg>
        <span>Fabriqué artisanalement</span>
    </div>
</div>
<section class="section section-categories">
    <div class="section-header">
        <div>
            <div class="section-sub">Acheter par catégorie</div>
            <h2 class="section-title">Collections <em>Sélectionnées</em></h2>
        </div>
        <a href="index.php?page=products" class="see-all">Voir Toutes les Catégories</a>
    </div>
    <div class="cat-grid">
        <?php foreach ($categories as $i => $cat): ?>
            <div class="cat-card cat-<?= $i + 1 ?>"
                 onclick="window.location='index.php?page=products&slug=<?= htmlspecialchars($cat['slug']) ?>'">
                <?php if (!empty($cat['image']) && file_exists($cat['image'])): ?>
                    <img src="<?= htmlspecialchars($cat['image']) ?>"
                         alt="<?= htmlspecialchars($cat['name']) ?>"
                         class="cat-bg-img">
                <?php endif; ?>
                <?php if ($i === 0): ?>
                    <div class="cat-tag">Featured</div>
                <?php endif; ?>
                <div class="cat-overlay">
                    <div class="cat-name"><?= htmlspecialchars($cat['name']) ?></div>
                    <div class="cat-count"><?= $cat['product_count'] ?> pièces</div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<section class="section section-products products-bg">
    <div class="section-header">
        <div>
            <div class="section-sub">Sélectionnés pour vous</div>
            <h2 class="section-title">Pièces <em>Vedettes</em></h2>
        </div>
        <a href="index.php?page=products" class="see-all">Voir Tout</a>
    </div>
<div class="filter-bar" id="filterBar">
        <button class="filter-btn active" data-filter="all">Tous</button>
        <button class="filter-btn" data-filter="new">Nouveautés</button>
        <button class="filter-btn" data-filter="femmes">Femmes</button>
        <button class="filter-btn" data-filter="hommes">Hommes</button>
        <button class="filter-btn" data-filter="sale">Soldes</button>
    </div>
    <div class="prod-grid" id="prodGrid">
        <?php foreach ($featuredProducts as $p): ?>
            <?php
            $badgeClass = '';
            $badgeText  = '';
            if ($p['badge'] === 'new')  { $badgeClass = 'badge-new';  $badgeText = 'Nouveau'; }
            if ($p['badge'] === 'sale') { $badgeClass = 'badge-sale'; $badgeText = 'Solde'; }
            if ($p['badge'] === 'best') { $badgeClass = 'badge-best'; $badgeText = 'Best'; }
            $filterTags = $p['category_slug'] ?? 'all';
            if ($p['badge'] === 'new')  $filterTags .= ' new';
            if ($p['badge'] === 'sale') $filterTags .= ' sale';
            ?>
            <div class="prod-card" data-filter="<?= htmlspecialchars($filterTags) ?>">
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
                        <a href="index.php?page=product&id=<?= (int)$p['id'] ?>" class="action-btn" title="Aperçu Rapide">
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
                    <div class="prod-footer">
                        <div class="prod-pricing">
                            <span class="prod-price"><?= number_format($p['price'], 2) ?> MAD</span>
                            <?php if (!empty($p['old_price'])): ?>
                                <span class="prod-old"><?= number_format($p['old_price'], 2) ?> MAD</span>
                            <?php endif; ?>
                        </div>
<form method="POST" action="index.php?page=cart-add">
                            <input type="hidden" name="product_id" value="<?= (int)$p['id'] ?>">
                            <input type="hidden" name="qty" value="1">
                            <input type="hidden" name="redirect" value="index.php">
                            <button type="submit" class="prod-add">Ajouter au Panier</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="load-more-wrap">
        <a href="index.php?page=products" class="btn-outline-dark">Voir Tous les Produits</a>
    </div>
</section>
<section class="section section-testimonials">
    <div class="section-header">
        <div>
            <div class="section-sub">Avis clients</div>
            <h2 class="section-title">Voix du <em>Patrimoine</em></h2>
        </div>
    </div>
    <div class="test-grid">
        <?php foreach ($testimonials as $t_item): ?>
            <div class="test-card">
<div class="test-stars"><?= str_repeat('★', $t_item['stars']) . str_repeat('☆', 5 - $t_item['stars']) ?></div>
<p class="test-text">"<?= htmlspecialchars($t_item['text']) ?>"</p>
                <div class="test-author">
                    <strong><?= htmlspecialchars($t_item['author']) ?></strong>
                    — <?= htmlspecialchars($t_item['city']) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<section class="newsletter">
    <div class="newsletter-inner">
        <div class="nl-tag">Restez Connecté</div>
        <h2 class="nl-title">Rejoignez le Cercle <em>Patrimoine</em></h2>
        <p class="nl-desc">Soyez le premier à découvrir les nouvelles collections, des histoires d'artisans et des offres exclusives.</p>
        <form class="nl-form" method="POST">
            <input type="email" name="email" placeholder="Votre adresse email" required>
            <button type="submit">S'abonner</button>
        </form>
        <p class="nl-note">Pas de spam. Désabonnez-vous à tout moment.</p>
    </div>
</section>
<?php require __DIR__ . '/layout/footer.php'; ?>
