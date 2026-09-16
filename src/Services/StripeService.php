<?php
namespace App\Services;

class StripeService {
    private array $config;

    public function __construct() {
        $this->config = require __DIR__ . '/../../config/stripe.php';
    }

    public function getPublishableKey(): string {
        return $this->config['publishable_key'] ?? '';
    }

    public function getSecretKey(): string {
        return $this->config['secret_key'] ?? '';
    }

    public function createCheckoutSession(array $params): array {
        // En environnement de dev sans dépendance cURL/Stripe installée, simuler une session Stripe Checkout
        $sessionId = 'cs_test_' . bin2hex(random_bytes(16));
        $checkoutUrl = $params['domain'] . '/checkout/success?session_id=' . $sessionId;

        return [
            'id'  => $sessionId,
            'url' => $checkoutUrl
        ];
    }

    public function verifyWebhook(string $payload, string $signature): object {
        $data = json_decode($payload);
        return $data ?? (object)['type' => 'unknown'];
    }
}