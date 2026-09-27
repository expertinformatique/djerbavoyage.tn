<?php
namespace App\Models;

/**
 * Entité de conversation ChatBot IA — Djerba Voyage
 * Règle 1 : Modèle sans logique métier ni accès DB
 */
class ChatConversation
{
    private string $id;
    private string $sessionId;
    private ?string $clientName = null;
    private ?string $clientEmail = null;
    private ?string $clientPhone = null;
    private ?string $clientCompany = null;
    private ?string $detectedNeed = null;
    private ?string $summary = null;
    private string $messagesJson = '[]';
    private string $ipHash;
    private string $status = 'active';
    private ?string $createdAt = null;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? '';
            $this->sessionId = $data['session_id'] ?? '';
            $this->clientName = $data['client_name'] ?? null;
            $this->clientEmail = $data['client_email'] ?? null;
            $this->clientPhone = $data['client_phone'] ?? null;
            $this->clientCompany = $data['client_company'] ?? null;
            $this->detectedNeed = $data['detected_need'] ?? null;
            $this->summary = $data['summary'] ?? null;
            $this->messagesJson = $data['messages_json'] ?? '[]';
            $this->ipHash = $data['ip_hash'] ?? '';
            $this->status = $data['status'] ?? 'active';
            $this->createdAt = $data['created_at'] ?? null;
        }
    }

    public function getId(): string { return $this->id; }
    public function setId(string $id): void { $this->id = $id; }

    public function getSessionId(): string { return $this->sessionId; }
    public function setSessionId(string $s): void { $this->sessionId = $s; }

    public function getClientName(): ?string { return $this->clientName; }
    public function setClientName(?string $n): void { $this->clientName = $n; }

    public function getClientEmail(): ?string { return $this->clientEmail; }
    public function setClientEmail(?string $e): void { $this->clientEmail = $e; }

    public function getClientPhone(): ?string { return $this->clientPhone; }
    public function setClientPhone(?string $p): void { $this->clientPhone = $p; }

    public function getClientCompany(): ?string { return $this->clientCompany; }
    public function setClientCompany(?string $c): void { $this->clientCompany = $c; }

    public function getDetectedNeed(): ?string { return $this->detectedNeed; }
    public function setDetectedNeed(?string $d): void { $this->detectedNeed = $d; }

    public function getSummary(): ?string { return $this->summary; }
    public function setSummary(?string $s): void { $this->summary = $s; }

    public function getMessagesJson(): string { return $this->messagesJson; }
    public function setMessagesJson(string $m): void { $this->messagesJson = $m; }

    public function getMessages(): array
    {
        $decoded = json_decode($this->messagesJson, true);
        return is_array($decoded) ? $decoded : [];
    }

    public function setMessages(array $messages): void
    {
        $this->messagesJson = json_encode($messages, JSON_UNESCAPED_UNICODE);
    }

    public function getIpHash(): string { return $this->ipHash; }
    public function setIpHash(string $h): void { $this->ipHash = $h; }

    public function getStatus(): string { return $this->status; }
    public function setStatus(string $s): void { $this->status = $s; }

    public function getCreatedAt(): ?string { return $this->createdAt; }
    public function setCreatedAt(?string $c): void { $this->createdAt = $c; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'session_id' => $this->sessionId,
            'client_name' => $this->clientName,
            'client_email' => $this->clientEmail,
            'client_phone' => $this->clientPhone,
            'client_company' => $this->clientCompany,
            'detected_need' => $this->detectedNeed,
            'summary' => $this->summary,
            'messages_json' => $this->messagesJson,
            'ip_hash' => $this->ipHash,
            'status' => $this->status,
            'created_at' => $this->createdAt,
        ];
    }
}
