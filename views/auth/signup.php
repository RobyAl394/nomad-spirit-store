<?php $pageTitle = 'Inscription'; require __DIR__ . '/../layout/header.php'; ?>
<section class="auth-section">
    <div class="auth-card">
        <div class="auth-logo">
            <a href="index.php">Nomad<em>Spirit</em></a>
        </div>
        <h1 class="auth-title">Inscription</h1>
        <p class="auth-subtitle">Créez un compte pour suivre vos commandes et accéder à des offres exclusives.</p>
<?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
<form method="POST" action="index.php?page=signup" class="auth-form">
            <div class="form-group">
                <label for="name">Nom Complet</label>
                <input type="text"
                       id="name"
                       name="name"
                       value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                       placeholder="Votre nom complet"
                       required
                       autocomplete="name">
            </div>
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
                <label for="phone">Téléphone</label>
                <input type="tel"
                       id="phone"
                       name="phone"
                       value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                       placeholder="+212 6XX XX XX XX">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password"
                       id="password"
                       name="password"
                       placeholder="Au moins 6 caractères"
                       required
                       minlength="6"
                       autocomplete="new-password">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmer le Mot de passe</label>
                <input type="password"
                       id="confirm_password"
                       name="confirm_password"
                       placeholder="Répétez le mot de passe"
                       required
                       autocomplete="new-password">
            </div>
            <button type="submit" class="btn-auth">Créer un Compte</button>
        </form>
<p class="auth-switch">
            Déjà un compte ?
            <a href="index.php?page=login">Connexion</a>
        </p>
    </div>
</section>
<?php require __DIR__ . '/../layout/footer.php'; ?>
