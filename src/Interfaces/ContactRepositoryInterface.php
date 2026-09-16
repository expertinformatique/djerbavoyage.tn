<?php
namespace App\Interfaces;

use App\Models\ContactMessage;

interface ContactRepositoryInterface {
    public function create(ContactMessage $msg): ?int;
    public function findById(int $id): ?ContactMessage;
    public function countAll(): int;
    public function getAll(int $limit = 50, int $offset = 0): array;
}
