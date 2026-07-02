<?php $pageTitle = 'Accès refusé'; require __DIR__ . '/../layout/header.php'; ?>
<section class="auth-section">
    <div class="auth-card" style="text-align:center;">
        <h1>Accès refusé. Vous n'avez pas les droits administrateur.</h1>
        <p>Vous devez être administrateur pour accéder à cette page.</p>
        <div style="display:flex;gap:1rem;justify-content:center;margin-top:2rem;">
            <a href="index.php" class="btn-primary">Accueil</a>
            <a href="index.php?page=login" class="btn-ghost">Connexion</a>
        </div>
    </div>
</section>
<?php require __DIR__ . '/../layout/footer.php'; ?>
