<?php
namespace App\Services;

use PDO;

class DownloadService {
    public function __construct(private PDO $pdo) {}

    public function generateToken(int $orderId, int $productId, int $hoursValid = 72): string {
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', time() + ($hoursValid * 3600));

        $stmt = $this->pdo->prepare("
            INSERT INTO download_tokens (order_id, product_id, token, expires_at)
            VALUES (:order_id, :product_id, :token, :expires_at)
        ");
        $stmt->execute([
            'order_id'   => $orderId,
            'product_id' => $productId,
            'token'      => $token,
            'expires_at' => $expiresAt
        ]);

        return $token;
    }

    public function validateToken(string $token): ?array {
        $stmt = $this->pdo->prepare("
            SELECT dt.*, p.file_path, p.title_fr 
            FROM download_tokens dt
            JOIN products p ON dt.product_id = p.id
            WHERE dt.token = :token
        ");
        $stmt->execute(['token' => $token]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) return null;
        if ($data['downloads_left'] <= 0) return null;
        if (strtotime($data['expires_at']) < time()) return null;

        return $data;
    }

    public function decrementDownloads(string $token): void {
        $stmt = $this->pdo->prepare("UPDATE download_tokens SET downloads_left = downloads_left - 1 WHERE token = :token");
        $stmt->execute(['token' => $token]);
    }
}