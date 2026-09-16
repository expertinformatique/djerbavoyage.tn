<?php
namespace App\Interfaces;

interface NewsletterRepositoryInterface {
    public function findByEmail(string $email): ?array;
    public function findByToken(string $token): ?array;
    public function subscribe(string $email, string $token, ?string $ip = null): string;
    public function unsubscribe(string $token): bool;
    public function countActive(): int;
    public function countAll(): int;
    public function getAll(int $limit = 100, int $offset = 0): array;
}
