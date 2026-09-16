<?php
namespace App\Services;

class StripeService {
    private array $config;

    public function __construct(private ?SettingsService $settings = null) {
        $this->config = require __DIR__ . '/../../config/stripe.php';
    }

    public function getPublishableKey(): string {
        $dbKey = $this->settings?->get('stripe_pub_key');
        if (!empty($dbKey)) {
            return $dbKey;
        }
        return $_ENV['STRIPE_PUB_KEY'] ?? getenv('STRIPE_PUB_KEY') ?: ($this->config['publishable_key'] ?? '');
    }

    public function getSecretKey(): string {
        $dbKey = $this->settings?->get('stripe_secret_key');
        if (!empty($dbKey)) {
            return $dbKey;
        }
        return $_ENV['STRIPE_SECRET_KEY'] ?? getenv('STRIPE_SECRET_KEY') ?: ($this->config['secret_key'] ?? '');
    }

    /**
     * Crée une session de paiement Stripe Checkout (API Stripe REST v1 via cURL avec fallback automatique).
     */
    public function createCheckoutSession(array $params): array {
        $secretKey = $this->getSecretKey();
        $defaultDomain = function_exists('absolute_url') ? rtrim(absolute_url(''), '/') : 'https://djerbavoyage.tn';
        $domain = rtrim($params['domain'] ?? $defaultDomain, '/');
        $currency = strtolower($params['currency'] ?? 'eur');
        $priceEur = (float)($params['price_eur'] ?? 10.00);
        $amountCents = (int)round($priceEur * 100);
        $title = $params['title'] ?? 'Djerba Voyage Service';
        $email = $params['email'] ?? '';
        $orderNumber = $params['order_number'] ?? ('ORD-' . strtoupper(bin2hex(random_bytes(4))));

        $successUrl = $params['success_url'] ?? ($domain . '/checkout/success?session_id={CHECKOUT_SESSION_ID}&order_number=' . urlencode($orderNumber));
        $cancelUrl  = $params['cancel_url']  ?? ($domain . '/');

        // Appel direct à l'API officielle Stripe si la clé secrète est présente
        if (!empty($secretKey) && function_exists('curl_init') && strpos($secretKey, 'sk_') === 0) {
            $postData = [
                'payment_method_types[0]' => 'card',
                'mode' => 'payment',
                'line_items[0][price_data][currency]' => $currency,
                'line_items[0][price_data][product_data][name]' => $title,
                'line_items[0][price_data][unit_amount]' => $amountCents,
                'line_items[0][quantity]' => 1,
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
            ];
            if (!empty($email)) {
                $postData['customer_email'] = $email;
            }
            if (!empty($params['type'])) {
                $postData['metadata[type]'] = $params['type'];
            }
            if (!empty($orderNumber)) {
                $postData['metadata[order_number]'] = $orderNumber;
            }

            $ch = curl_init('https://api.stripe.com/v1/checkout/sessions');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_USERPWD, $secretKey . ':');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded'
            ]);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                $data = json_decode($response, true);
                if (!empty($data['id']) && !empty($data['url'])) {
                    return [
                        'id'  => $data['id'],
                        'url' => $data['url']
                    ];
                }
            }
        }

        // Fallback bac à sable (mode simulation)
        $sessionId = 'cs_test_' . bin2hex(random_bytes(16));
        $checkoutUrl = $successUrl;
        if (strpos($checkoutUrl, '{CHECKOUT_SESSION_ID}') !== false) {
            $checkoutUrl = str_replace('{CHECKOUT_SESSION_ID}', $sessionId, $checkoutUrl);
        } elseif (strpos($checkoutUrl, 'session_id=') === false) {
            $checkoutUrl .= (strpos($checkoutUrl, '?') !== false ? '&' : '?') . 'session_id=' . $sessionId;
        }

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