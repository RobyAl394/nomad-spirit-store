<?php
$pageTitle = 'Gérer les Commandes';
$statusLabels = [
    'pending'   => 'En attente',
    'confirmed' => 'Confirmé',
    'shipped'   => 'Expédié',
    'delivered' => 'Livré',
    'cancelled' => 'Annulé',
];
require __DIR__ . '/../../layout/header.php';
?>
<section class="admin-layout">
    <main class="admin-main">
        <div class="admin-topbar">
            <h1>Gérer les Commandes</h1>
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
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><strong>#<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></strong></td>
                            <td><?= htmlspecialchars($order['user_name'] ?? $order['guest_name'] ?? 'Invité') ?></td>
                            <td><?= htmlspecialchars($order['user_email'] ?? $order['guest_email'] ?? '—') ?></td>
                            <td><?= number_format($order['total'], 2) ?> MAD</td>
                            <td><span class="status-badge status-<?= $order['status'] ?>"><?= $statusLabels[$order['status']] ?></span></td>
                            <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                            <td>
                                <select onchange="updateStatus(<?= $order['id'] ?>, this.value)" class="status-select">
                                    <?php foreach (['pending','confirmed','shipped','delivered','cancelled'] as $s): ?>
                                        <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>>
                                            <?= $statusLabels[$s] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</section>
<script>
function updateStatus(orderId, status) {
    window.location = 'index.php?page=admin-order-status&id=' + orderId + '&status=' + status;
}
</script>
<?php require __DIR__ . '/../../layout/footer.php'; ?>
