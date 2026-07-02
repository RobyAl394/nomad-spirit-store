<?php
$currentPage = $_GET['page'] ?? 'admin';
$pageTitle   = 'Tableau de Bord';
$statusLabels = [
    'pending'   => 'En attente',
    'confirmed' => 'Confirmé',
    'shipped'   => 'Expédié',
    'delivered' => 'Livré',
    'cancelled' => 'Annulé',
];
require __DIR__ . '/../layout/header.php';
?>
<section class="admin-layout">
    <main class="admin-main">
        <div class="admin-topbar">
            <h1>Tableau de Bord</h1>
            <span>Bienvenue, <?= htmlspecialchars($_SESSION['user_name']) ?> !</span>
        </div>
        <?php if (!empty($message)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
<div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value"><?= $stats['products'] ?></div>
                <div class="stat-label">Total Produits</div>
                <a href="index.php?page=admin-products">Voir →</a>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?= $stats['categories'] ?></div>
                <div class="stat-label">Total Catégories</div>
                <a href="index.php?page=admin-categories">Voir →</a>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?= $stats['users'] ?></div>
                <div class="stat-label">Total Utilisateurs</div>
                <a href="index.php?page=admin-users">Voir →</a>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?= $stats['orders'] ?></div>
                <div class="stat-label">Total Commandes</div>
                <a href="index.php?page=admin-orders">Voir →</a>
            </div>
        </div>
<div class="admin-section">
            <div class="admin-section-header">
                <h2>Commandes Récentes</h2>
                <a href="index.php?page=admin-orders">Voir toutes →</a>
            </div>
            <?php if (empty($recentOrders)): ?>
                <p>Aucune commande pour l'instant.</p>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Utilisateur</th>
                                <th>Total</th>
                                <th>Statut</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentOrders as $order): ?>
                                <tr>
                                    <td>#<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></td>
                                    <td><?= htmlspecialchars($order['user_name'] ?? $order['guest_name'] ?? 'Invité') ?></td>
                                    <td><?= number_format($order['total'], 2) ?> MAD</td>
                                    <td><span class="status-badge status-<?= $order['status'] ?>"><?= $statusLabels[$order['status']] ?></span></td>
                                    <td><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </main>
</section>
<?php require __DIR__ . '/../layout/footer.php'; ?>
