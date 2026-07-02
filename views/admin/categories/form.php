<?php $pageTitle = $category ? 'Modifier la Catégorie' : 'Ajouter une Catégorie'; require __DIR__ . '/../../layout/header.php'; ?>
<section class="admin-layout">
    <main class="admin-main">
        <div class="admin-topbar">
            <h1><?= $category ? 'Modifier la Catégorie' : 'Ajouter une Catégorie' ?></h1>
            <a href="index.php?page=admin-categories" class="btn-ghost">Annuler</a>
        </div>
        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST"
              action="index.php?page=admin-category-form<?= $category ? '&id='.$category['id'] : '' ?>"
              enctype="multipart/form-data"
              class="admin-form">
            <div class="form-group">
                <label>Nom *</label>
                <input type="text" name="name"
                       value="<?= htmlspecialchars($category['name'] ?? '') ?>"
                       placeholder="Vêtements Femmes" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Slug (URL) *</label>
                    <input type="text" name="slug"
                           value="<?= htmlspecialchars($category['slug'] ?? '') ?>"
                           placeholder="femmes">
                    <small>Utilisé dans l'URL. Ex: femmes, hommes, accessoires</small>
                </div>
                <div class="form-group">
                    <label>Ordre d'affichage</label>
                    <input type="number" name="sort_order" min="0"
                           value="<?= htmlspecialchars($category['sort_order'] ?? 0) ?>">
                </div>
            </div>
            <div class="form-group">
                <label>Télécharger une image</label>
                <input type="file" name="image_file" accept="image/*">
            </div>
            <div class="form-group">
                <label>ou URL de l'image existante</label>
                <input type="text" name="image_url"
                       value="<?= htmlspecialchars($category['image'] ?? '') ?>"
                       placeholder="womens-clothes/image.jpg">
                <?php if (!empty($category['image']) && file_exists($category['image'])): ?>
                    <img src="<?= htmlspecialchars($category['image']) ?>"
                         alt="" style="margin-top:8px;max-width:150px;border-radius:4px;">
                <?php endif; ?>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary">Enregistrer</button>
                <a href="index.php?page=admin-categories" class="btn-ghost">Annuler</a>
            </div>
        </form>
    </main>
</section>
<?php require __DIR__ . '/../../layout/footer.php'; ?>
