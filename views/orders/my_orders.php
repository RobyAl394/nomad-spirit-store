<?php
$pageTitle = 'Mes Commandes';
$statusLabels = [
    'pending'   => 'En attente',
    'confirmed' => 'Confirmé',
    'shipped'   => 'Expédié',
    'delivered' => 'Livré',
    'cancelled' => 'Annulé',
];
require __DIR__ . '/../layout/header.php';
?>

<section class="orders-page">

    <div class="page-title-wrap">
        <h1>Mes Commandes</h1>
        <p>Bonjour, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong> !</p>
    </div>

    <?php if (empty($orders)): ?>
        <div class="empty-state">
            <p>Vous n'avez pas encore de commandes.</p>
            <a href="index.php?page=products" class="btn-primary">Boutique</a>
        </div>
    <?php else: ?>
        <div class="orders-table-wrap">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Numéro de Commande</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><strong>#<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></strong></td>
                            <td><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                            <td><?= number_format($order['total'], 2) ?> MAD</td>
                            <td>
                                <span class="status-badge status-<?= $order['status'] ?>">
                                    <?= $statusLabels[$order['status']] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
