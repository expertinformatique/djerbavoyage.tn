<?php
namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface {
    public function findById(int $id): ?User;
    public function findByUsername(string $username): ?User;
    public function findByEmail(string $email): ?User;
    public function getAll(): array;
    public function getPaginated(int $page = 1, int $limit = 10): array;
    public function create(User $user): bool;
    public function update(User $user, ?string $newPassword = null): bool;
    public function delete(int $id): bool;
    public function count(): int;
}
