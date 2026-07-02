<?php $pageTitle = $product ? 'Modifier le Produit' : 'Ajouter un Produit'; require __DIR__ . '/../../layout/header.php'; ?>
<section class="admin-layout">
    <main class="admin-main">
        <div class="admin-topbar">
            <h1><?= $product ? 'Modifier le Produit' : 'Ajouter un Produit' ?></h1>
            <a href="index.php?page=admin-products" class="btn-ghost">Annuler</a>
        </div>
        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST"
              action="index.php?page=admin-product-form<?= $product ? '&id='.$product['id'] : '' ?>"
              enctype="multipart/form-data"
              class="admin-form">
            <div class="form-group">
                <label>Nom *</label>
                <input type="text" name="name"
                       value="<?= htmlspecialchars($product['name'] ?? $_POST['name'] ?? '') ?>"
                       placeholder="Nom du produit" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="4"
                          placeholder="Description du produit"><?= htmlspecialchars($product['description'] ?? $_POST['description'] ?? '') ?></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Prix (MAD) *</label>
                    <input type="number" name="price" step="0.01" min="0"
                           value="<?= htmlspecialchars($product['price'] ?? $_POST['price'] ?? '') ?>"
                           placeholder="0.00" required>
                </div>
                <div class="form-group">
                    <label>Ancien Prix (MAD)</label>
                    <input type="number" name="old_price" step="0.01" min="0"
                           value="<?= htmlspecialchars($product['old_price'] ?? $_POST['old_price'] ?? '') ?>"
                           placeholder="Laisser vide si pas de promo">
                </div>
                <div class="form-group">
                    <label>Stock</label>
                    <input type="number" name="stock" min="0"
                           value="<?= htmlspecialchars($product['stock'] ?? $_POST['stock'] ?? 10) ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Catégorie</label>
                    <select name="category_id">
                        <option value="">— Choisir —</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"
                                <?= (($product['category_id'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Badge</label>
                    <select name="badge">
                        <option value="">Aucun</option>
                        <option value="new"  <?= ($product['badge'] ?? '') === 'new'  ? 'selected' : '' ?>>Nouveau</option>
                        <option value="sale" <?= ($product['badge'] ?? '') === 'sale' ? 'selected' : '' ?>>Solde</option>
                        <option value="best" <?= ($product['badge'] ?? '') === 'best' ? 'selected' : '' ?>>Best</option>
                    </select>
                </div>
            </div>
            <div class="form-group form-check">
                <label>
                    <input type="checkbox" name="is_featured" value="1"
                           <?= ($product['is_featured'] ?? 0) ? 'checked' : '' ?>>
                    En vedette (affiché sur la page d'accueil)
                </label>
            </div>
            <div class="form-group">
                <label>Télécharger une image</label>
                <input type="file" name="image_file" accept="image/*">
            </div>
            <div class="form-group">
                <label>ou URL de l'image existante</label>
                <input type="text" name="image_url"
                       value="<?= htmlspecialchars($product['image'] ?? '') ?>"
                       placeholder="womens-clothes/Melhfa-...jpg">
                <?php if (!empty($product['image']) && file_exists($product['image'])): ?>
                    <img src="<?= htmlspecialchars($product['image']) ?>"
                         alt="Preview" style="margin-top:8px;max-width:150px;border-radius:4px;">
                <?php endif; ?>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary">Enregistrer</button>
                <a href="index.php?page=admin-products" class="btn-ghost">Annuler</a>
            </div>
        </form>
    </main>
</section>
<?php require __DIR__ . '/../../layout/footer.php'; ?>
