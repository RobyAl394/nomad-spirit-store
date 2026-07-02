<?php $pageTitle = 'Gérer les Produits'; require __DIR__ . '/../../layout/header.php'; ?>
<section class="admin-layout">
    <main class="admin-main">
        <div class="admin-topbar">
            <h1>Gérer les Produits</h1>
            <div>
                <a href="index.php?page=admin" class="btn-ghost-small">← Tableau de Bord</a>
                <a href="index.php?page=admin-product-form" class="btn-primary">
                    + Ajouter un Produit
                </a>
            </div>
        </div>
        <?php if (!empty($message)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Catégorie</th>
                        <th>En vedette</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td>
                                <?php if (!empty($p['image']) && file_exists($p['image'])): ?>
                                    <img src="<?= htmlspecialchars($p['image']) ?>"
                                         alt="" style="width:50px;height:60px;object-fit:cover;border-radius:4px;">
                                <?php else: ?>
                                    <div style="width:50px;height:60px;background:var(--sand);border-radius:4px;"></div>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($p['name']) ?></td>
                            <td><?= number_format($p['price'], 2) ?> MAD</td>
                            <td class="<?= $p['stock'] <= 0 ? 'text-danger' : '' ?>">
                                <?= $p['stock'] ?>
                            </td>
                            <td><?= htmlspecialchars($p['category_name'] ?? '—') ?></td>
                            <td><?= $p['is_featured'] ? '✓' : '—' ?></td>
                            <td class="actions-td">
                                <a href="index.php?page=admin-product-form&id=<?= $p['id'] ?>"
                                   class="btn-action btn-edit">Modifier</a>
                                <a href="index.php?page=admin-product-delete&id=<?= $p['id'] ?>"
                                   class="btn-action btn-delete"
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</section>
<?php require __DIR__ . '/../../layout/footer.php'; ?>
