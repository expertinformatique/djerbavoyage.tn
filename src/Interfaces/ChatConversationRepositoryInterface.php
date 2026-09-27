<?php
namespace App\Interfaces;

use App\Models\ChatConversation;

/**
 * Interface Repository pour les conversations du ChatBot IA
 */
interface ChatConversationRepositoryInterface
{
    public function save(ChatConversation $conversation): bool;
    public function findById(string $id): ?ChatConversation;
    public function findBySessionId(string $sessionId): ?ChatConversation;
    public function deleteBySessionId(string $sessionId): bool;
    public function getPaginated(int $page = 1, int $perPage = 20, ?string $status = null): array;
}
