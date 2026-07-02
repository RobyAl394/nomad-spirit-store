<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Nomad Spirit Store' ?> — Nomad Spirit Store</title>
    <meta name="description" content="Vêtements et accessoires sahraouiens authentiques. Melhfas, daraas, turbans.">
    <link rel="stylesheet" href="assets/css/style.css?v=2">
</head>
<body>
<?php if (!empty($_SESSION['flash'])): ?>
    <div class="flash-message">
        <?= htmlspecialchars($_SESSION['flash']) ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>
<header class="site-header">
    <nav class="navbar">
        <a href="index.php" class="nav-logo">
            <img src="assets/img/logo/Nomad Spirit Store.png" alt="" class="nav-logo-img">
            Nomad<em> Spirit</em> Store
        </a>
        <button class="nav-toggle" id="navToggle" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
        <ul class="nav-links" id="navLinks">
            <li><a href="index.php">Accueil</a></li>
            <li class="has-dropdown">
                <a href="index.php?page=products&slug=femmes">Femmes ▾</a>
                <ul class="dropdown">
                    <li><a href="index.php?page=products&slug=melhfa-gaze">Melhfa Gaze</a></li>
                    <li><a href="index.php?page=products&slug=melhfa-chega">Melhfa Chega</a></li>
                    <li><a href="index.php?page=products&slug=melhfa-digital">Melhfa Digital</a></li>
                    <li><a href="index.php?page=products&slug=melhfa-persi">Melhfa Persi</a></li>
                    <li><a href="index.php?page=products&slug=melhfa-diana-london">Melhfa Diana London</a></li>
                    <li><a href="index.php?page=products&slug=melhfa-second-life">Melhfa Second Life</a></li>
                    <li><a href="index.php?page=products&slug=melhfa-uni">Melhfa Uni</a></li>
                    <li><a href="index.php?page=products&slug=melhfa-kanebo">Melhfa Kanebo</a></li>
                    <li><a href="index.php?page=products&slug=melhfa-kento-italy">Melhfa Kento Italy</a></li>
                </ul>
            </li>
            <li class="has-dropdown">
                <a href="index.php?page=products&slug=hommes">Hommes ▾</a>
                <ul class="dropdown">
                    <li><a href="index.php?page=products&slug=daraas">Daraas</a></li>
                    <li><a href="index.php?page=products&slug=turbans">Turbans</a></li>
                    <li><a href="index.php?page=products&slug=pantalons">Pantalons</a></li>
                </ul>
            </li>
            <li><a href="index.php?page=products&slug=accessoires">Accessoires</a></li>
            <li><a href="index.php?page=products">Boutique</a></li>
        </ul>
        <div class="nav-actions">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="has-dropdown nav-user">
                    <a href="#" class="nav-icon" title="Mon Compte">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <span class="nav-user-name"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                    </a>
                    <ul class="dropdown">
                        <li><a href="index.php?page=my-orders">Mes Commandes</a></li>
                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                            <li><a href="index.php?page=admin">Panneau Admin</a></li>
                            <li><a href="index.php?page=admin-products">Gérer les Produits</a></li>
                            <li><a href="index.php?page=admin-categories">Gérer les Catégories</a></li>
                            <li><a href="index.php?page=admin-users">Gérer les Utilisateurs</a></li>
                            <li><a href="index.php?page=admin-orders">Gérer les Commandes</a></li>
                        <?php endif; ?>
                        <li><a href="index.php?page=logout">Déconnexion</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="index.php?page=login" class="nav-icon" title="Connexion">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </a>
            <?php endif; ?>
            <?php
            $cartCount = 0;
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
                    $cartCount += $item['qty'];
                }
            }
            ?>
            <a href="index.php?page=cart" class="cart-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 0 1-8 0"/>
                </svg>
                Panier
                <?php if ($cartCount > 0): ?>
                    <span class="cart-badge"><?= $cartCount ?></span>
                <?php endif; ?>
            </a>
        </div>
    </nav>
</header>
<div class="announce-bar">
    <p>Livraison gratuite dès 150 MAD &nbsp;·&nbsp; Fabriqué à la main par des artisans &nbsp;·&nbsp; <a href="index.php?page=products">Découvrir la nouvelle collection →</a></p>
</div>
