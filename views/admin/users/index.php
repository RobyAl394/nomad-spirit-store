<?php $pageTitle = 'Gérer les Utilisateurs'; require __DIR__ . '/../../layout/header.php'; ?>
<section class="admin-layout">
    <main class="admin-main">
        <div class="admin-topbar">
            <h1>Gérer les Utilisateurs</h1>
            <a href="index.php?page=admin" class="btn-ghost-small">← Tableau de Bord</a>
        </div>
        <?php if (!empty($message)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Adresse Email</th>
                        <th>Téléphone</th>
                        <th>Rôle</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr class="<?= $user['id'] == $_SESSION['user_id'] ? 'current-user' : '' ?>">
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['phone'] ?? '—') ?></td>
                            <td>
                                <span class="role-badge role-<?= $user['role'] ?>">
                                    <?= $user['role'] === 'admin' ? 'Admin' : 'Client' ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                            <td class="actions-td">
                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                    <?php if ($user['role'] === 'client'): ?>
                                        <a href="index.php?page=admin-user-role&id=<?= $user['id'] ?>&role=admin"
                                           class="btn-action btn-edit"
                                           onclick="return confirm('Promouvoir en Admin ?')">→ Admin</a>
                                    <?php else: ?>
                                        <a href="index.php?page=admin-user-role&id=<?= $user['id'] ?>&role=client"
                                           class="btn-action btn-edit"
                                           onclick="return confirm('Rétrograder en Client ?')">→ Client</a>
                                    <?php endif; ?>
                                    <a href="index.php?page=admin-user-delete&id=<?= $user['id'] ?>"
                                       class="btn-action btn-delete"
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')">Supprimer</a>
                                <?php else: ?>
                                    <span style="color:#999;font-size:0.8rem;">(vous)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</section>
<?php require __DIR__ . '/../../layout/footer.php'; ?>
