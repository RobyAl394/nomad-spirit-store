<?php
class User {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findByEmail(string $email): array|false {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findById(int $id): array|false {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(string $name, string $email, string $password, string $phone = ''): int {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("
            INSERT INTO users (name, email, password, phone, role)
            VALUES (?, ?, ?, ?, 'client')
        ");
        $stmt->execute([$name, $email, $hashedPassword, $phone]);

        return (int) $this->pdo->lastInsertId();
    }

    public function verifyPassword(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }

    public function getAll(): array {
        $stmt = $this->pdo->query("SELECT id, name, email, phone, role, created_at FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function updateRole(int $id, string $role): void {
        $stmt = $this->pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
        $stmt->execute([$role, $id]);
    }

    public function delete(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function count(): int {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }

    public function emailExists(string $email): bool {
        return $this->findByEmail($email) !== false;
    }

    public function authenticate(string $email, string $password): array|false {
        $user = $this->findByEmail($email);
        if ($user && $this->verifyPassword($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
