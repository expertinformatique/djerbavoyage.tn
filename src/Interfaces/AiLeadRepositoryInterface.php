<?php
namespace App\Interfaces;

use App\Models\AiLead;

interface AiLeadRepositoryInterface {
    public function create(AiLead $lead): ?int;
    public function findById(int $id): ?AiLead;
    public function countAll(): int;
    public function getAll(int $limit = 50, int $offset = 0): array;
}
