<?php
class Order {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    public function create(array $data): int {
        $stmt = $this->pdo->prepare("
            INSERT INTO orders (user_id, guest_name, guest_email, guest_phone, shipping_address, total, status)
            VALUES (?, ?, ?, ?, ?, ?, 'pending')
        ");
        $stmt->execute([
            $data['user_id'] ?? null,
            $data['guest_name'] ?? null,
            $data['guest_email'] ?? null,
            $data['guest_phone'] ?? null,
            $data['shipping_address'],
            $data['total'],
        ]);

        return (int) $this->pdo->lastInsertId();
    }
    public function addItem(int $orderId, array $item): void {
        $stmt = $this->pdo->prepare("
            INSERT INTO order_items (order_id, product_id, product_name, quantity, price)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $orderId,
            $item['product_id'],
            $item['product_name'],
            $item['quantity'],
            $item['price'],
        ]);
    }
    public function getByUser(int $userId): array {
        $stmt = $this->pdo->prepare("
            SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    public function findById(int $id): array|false {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function getItems(int $orderId): array {
        $stmt = $this->pdo->prepare("
            SELECT oi.*, p.image
            FROM order_items oi
            LEFT JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }
    public function getAll(): array {
        $stmt = $this->pdo->query("
            SELECT o.*, u.name AS user_name, u.email AS user_email
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.id
            ORDER BY o.created_at DESC
        ");
        return $stmt->fetchAll();
    }
    public function updateStatus(int $id, string $status): void {
        $stmt = $this->pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
    }
    public function count(): int {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
    }
}
