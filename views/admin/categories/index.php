<?php $pageTitle = 'Gérer les Catégories'; require __DIR__ . '/../../layout/header.php'; ?>
<section class="admin-layout">
    <main class="admin-main">
        <div class="admin-topbar">
            <h1>Gérer les Catégories</h1>
            <div>
                <a href="index.php?page=admin" class="btn-ghost-small">← Tableau de Bord</a>
                <a href="index.php?page=admin-category-form" class="btn-primary">+ Ajouter une Catégorie</a>
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
                        <th>Slug</th>
                        <th>Produits</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td><?= $cat['id'] ?></td>
                            <td>
                                <?php if (!empty($cat['image']) && file_exists($cat['image'])): ?>
                                    <img src="<?= htmlspecialchars($cat['image']) ?>"
                                         alt="" style="width:50px;height:50px;object-fit:cover;border-radius:4px;">
                                <?php else: ?>
                                    <div style="width:50px;height:50px;background:var(--sand);border-radius:4px;"></div>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($cat['name']) ?></td>
                            <td><code><?= htmlspecialchars($cat['slug']) ?></code></td>
                            <td><?= $cat['product_count'] ?></td>
                            <td class="actions-td">
                                <a href="index.php?page=admin-category-form&id=<?= $cat['id'] ?>"
                                   class="btn-action btn-edit">Modifier</a>
                                <a href="index.php?page=admin-category-delete&id=<?= $cat['id'] ?>"
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
