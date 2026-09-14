<?php
namespace App\Services;

use PDO;

class FraudDetectionService {
    public function __construct(private PDO $pdo, private LoggerService $logger) {}

    public function validateCheckoutPrice(int $productId, float $submittedPriceEur, string $ip): bool {
        $stmt = $this->pdo->prepare("SELECT price_eur FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);
        $realPrice = (float)$stmt->fetchColumn();

        if ($realPrice > 0 && abs($realPrice - $submittedPriceEur) > 0.01) {
            $this->logger->log(
                event: 'price_tampering_attempt',
                severity: 'critical',
                message: "Tentative de falsification de prix. Produit #{$productId}, Soumis: {$submittedPriceEur}€, Réel: {$realPrice}€",
                ip: $ip
            );
            return false;
        }
        return true;
    }

    public function isIpBanned(string $ip): bool {
        $banFile = __DIR__ . '/../../storage/cache/banned_ips.json';
        if (!file_exists($banFile)) return false;

        $banned = json_decode(file_get_contents($banFile), true) ?? [];
        return isset($banned[$ip]) && time() < $banned[$ip];
    }
}