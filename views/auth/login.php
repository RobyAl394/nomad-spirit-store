<?php $pageTitle = 'Connexion'; require __DIR__ . '/../layout/header.php'; ?>
<section class="auth-section">
    <div class="auth-card">
        <div class="auth-logo">
            <a href="index.php">Nomad<em>Spirit</em></a>
        </div>
        <h1 class="auth-title">Connexion</h1>
        <p class="auth-subtitle">Connectez-vous pour gérer vos commandes.</p>
<?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
<form method="POST" action="index.php?page=login" class="auth-form">
            <div class="form-group">
                <label for="email">Adresse Email</label>
                <input type="email"
                       id="email"
                       name="email"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       placeholder="exemple@email.com"
                       required
                       autocomplete="email">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password"
                       id="password"
                       name="password"
                       placeholder="••••••••"
                       required
                       autocomplete="current-password">
            </div>
            <button type="submit" class="btn-auth">Se Connecter</button>
        </form>
<p class="auth-switch">
            Pas encore de compte ?
            <a href="index.php?page=signup">Inscription</a>
        </p>
<div class="guest-note">
            <p>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                Vous commandez en tant qu'invité. Créez un compte pour suivre vos commandes.
            </p>
            <a href="index.php?page=checkout" class="btn-ghost-small">Passer la Commande</a>
        </div>
    </div>
</section>
<?php require __DIR__ . '/../layout/footer.php'; ?>
