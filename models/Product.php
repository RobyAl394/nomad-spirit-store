<?php
class Product {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    public function getAll(): array {
        $stmt = $this->pdo->query("
            SELECT p.*, c.name AS category_name, c.slug AS category_slug
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            ORDER BY p.created_at DESC
        ");
        return $stmt->fetchAll();
    }
    public function getByParentCategory(int $parentId): array {
        $stmt = $this->pdo->prepare("
            SELECT p.*, c.name AS category_name, c.slug AS category_slug
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.category_id = ?
               OR p.category_id IN (SELECT id FROM categories WHERE parent_id = ?)
            ORDER BY p.created_at DESC
        ");
        $stmt->execute([$parentId, $parentId]);
        return $stmt->fetchAll();
    }
    public function getByCategory(int $categoryId): array {
        $stmt = $this->pdo->prepare("
            SELECT p.*, c.name AS category_name, c.slug AS category_slug
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.category_id = ?
            ORDER BY p.created_at DESC
        ");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll();
    }
    public function getFeatured(int $limit = 8): array {
        $stmt = $this->pdo->prepare("
            SELECT p.*, c.name AS category_name, c.slug AS category_slug
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.is_featured = 1
            ORDER BY p.created_at DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    public function findById(int $id): array|false {
        $stmt = $this->pdo->prepare("
            SELECT p.*, c.name AS category_name, c.slug AS category_slug
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.id = ?
            LIMIT 1
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create(array $data): int {
        $stmt = $this->pdo->prepare("
            INSERT INTO products
                (name, description, price, old_price, stock, category_id, image, badge, is_featured)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['name'],
            $data['description'] ?? '',
            $data['price'],
            $data['old_price'] ?: null,
            $data['stock'] ?? 10,
            $data['category_id'],
            $data['image'] ?? '',
            $data['badge'] ?? '',
            $data['is_featured'] ?? 0,
        ]);
        return (int) $this->pdo->lastInsertId();
    }
    public function update(int $id, array $data): void {
        $stmt = $this->pdo->prepare("
            UPDATE products SET
                name = ?, description = ?,
                price = ?, old_price = ?, stock = ?,
                category_id = ?, image = ?, badge = ?, is_featured = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $data['name'],
            $data['description'] ?? '',
            $data['price'],
            $data['old_price'] ?: null,
            $data['stock'] ?? 10,
            $data['category_id'],
            $data['image'] ?? '',
            $data['badge'] ?? '',
            $data['is_featured'] ?? 0,
            $id,
        ]);
    }
    public function delete(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
    }
    public function count(): int {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    }
    public function search(string $keyword): array {
        $like = '%' . $keyword . '%';
        $stmt = $this->pdo->prepare("
            SELECT p.*, c.name AS category_name, c.slug AS category_slug
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.name LIKE ?
            ORDER BY p.created_at DESC
        ");
        $stmt->execute([$like]);
        return $stmt->fetchAll();
    }
}
