<?php
class Category {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    public function getAll(): array {
        $stmt = $this->pdo->query("
            SELECT c.*,
                   (SELECT COUNT(*) FROM products WHERE category_id = c.id) AS product_count
            FROM categories c
            ORDER BY COALESCE(c.parent_id, c.id), c.sort_order ASC
        ");
        return $stmt->fetchAll();
    }
    public function getTopLevel(): array {
        $stmt = $this->pdo->query("
            SELECT c.*,
                   (SELECT COUNT(*) FROM products p
                    WHERE p.category_id = c.id
                       OR p.category_id IN (SELECT id FROM categories WHERE parent_id = c.id)
                   ) AS product_count
            FROM categories c
            WHERE c.parent_id IS NULL
            ORDER BY c.sort_order ASC
        ");
        return $stmt->fetchAll();
    }
    public function getChildren(int $parentId): array {
        $stmt = $this->pdo->prepare("
            SELECT c.*,
                   (SELECT COUNT(*) FROM products WHERE category_id = c.id) AS product_count
            FROM categories c
            WHERE c.parent_id = ?
            ORDER BY c.sort_order ASC
        ");
        $stmt->execute([$parentId]);
        return $stmt->fetchAll();
    }
    public function getHierarchy(): array {
        $parents = $this->getTopLevel();
        foreach ($parents as &$parent) {
            $parent['children'] = $this->getChildren($parent['id']);
        }
        return $parents;
    }
    public function findBySlug(string $slug): array|false {
        $stmt = $this->pdo->prepare("
            SELECT c.*,
                   (SELECT COUNT(*) FROM products p
                    WHERE p.category_id = c.id
                       OR p.category_id IN (SELECT id FROM categories WHERE parent_id = c.id)
                   ) AS product_count
            FROM categories c
            WHERE c.slug = ?
            LIMIT 1
        ");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
    public function findById(int $id): array|false {
        $stmt = $this->pdo->prepare("
            SELECT c.*
            FROM categories c
            WHERE c.id = ?
            LIMIT 1
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create(array $data): int {
        $stmt = $this->pdo->prepare("
            INSERT INTO categories
                (name, slug, description, image, sort_order, parent_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['name'],
            $data['slug'],
            $data['description'] ?? '',
            $data['image'] ?? '',
            $data['sort_order'] ?? 0,
            $data['parent_id'] ?? null,
        ]);
        return (int) $this->pdo->lastInsertId();
    }
    public function update(int $id, array $data): void {
        $stmt = $this->pdo->prepare("
            UPDATE categories SET
                name = ?, slug = ?, description = ?,
                image = ?, sort_order = ?, parent_id = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $data['name'],
            $data['slug'],
            $data['description'] ?? '',
            $data['image'] ?? '',
            $data['sort_order'] ?? 0,
            $data['parent_id'] ?? null,
            $id,
        ]);
    }
    public function delete(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$id]);
    }
    public function count(): int {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
    }
}
