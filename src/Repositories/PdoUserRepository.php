<?php
namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use PDO;

class PdoUserRepository implements UserRepositoryInterface {
    public function __construct(private PDO $pdo) {}

    public function findById(int $id): ?User {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? User::fromArray($row) : null;
    }

    public function findByUsername(string $username): ?User {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? User::fromArray($row) : null;
    }

    public function findByEmail(string $email): ?User {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? User::fromArray($row) : null;
    }

    public function getAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM users ORDER BY id ASC");
        $rows = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        if ($stmt) $stmt->closeCursor();
        return array_map(fn($r) => User::fromArray($r), $rows);
    }

    public function getPaginated(int $page = 1, int $limit = 10): array {
        $page   = max(1, $page);
        $limit  = max(1, $limit);
        $offset = ($page - 1) * $limit;
        $total  = $this->count();

        $stmt = $this->pdo->prepare("SELECT * FROM users ORDER BY id ASC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        $stmt->closeCursor();

        return [
            'items' => array_map(fn($r) => User::fromArray($r), $rows),
            'total' => $total
        ];
    }

    public function create(User $user): bool {
        $stmt = $this->pdo->prepare("
            INSERT INTO users (username, email, password, role, created_at)
            VALUES (:username, :email, :password, :role, CURRENT_TIMESTAMP)
        ");
        return $stmt->execute([
            'username' => $user->username,
            'email'    => $user->email,
            'password' => $user->password,
            'role'     => $user->role
        ]);
    }

    public function update(User $user, ?string $newPassword = null): bool {
        if (!empty($newPassword)) {
            $stmt = $this->pdo->prepare("
                UPDATE users
                SET username = :username, email = :email, role = :role, password = :password
                WHERE id = :id
            ");
            return $stmt->execute([
                'username' => $user->username,
                'email'    => $user->email,
                'role'     => $user->role,
                'password' => $newPassword,
                'id'       => $user->id
            ]);
        }

        $stmt = $this->pdo->prepare("
            UPDATE users
            SET username = :username, email = :email, role = :role
            WHERE id = :id
        ");
        return $stmt->execute([
            'username' => $user->username,
            'email'    => $user->email,
            'role'     => $user->role,
            'id'       => $user->id
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function count(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM users");
        $count = (int)$stmt->fetchColumn();
        if ($stmt) $stmt->closeCursor();
        return $count;
    }
}
