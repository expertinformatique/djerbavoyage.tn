<?php
namespace App\Services;

use PDO;

class AnalyticsService {
    public function __construct(private PDO $pdo) {}

    public function trackPageView(string $urlPath): void {
        if (stristr($urlPath, '/admin') || stristr($urlPath, '/api')) return;

        $referrer = $_SERVER['HTTP_REFERER'] ?? 'Direct';
        if ($referrer !== 'Direct') {
            $host = parse_url($referrer, PHP_URL_HOST);
            $referrer = $host ?: 'Direct';
        }

        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $device = 'desktop';
        if (preg_match('/(android|bb\d+|meego).+mobile|avail|blackberry|iphone|ipod/i', $userAgent)) {
            $device = 'mobile';
        } else if (preg_match('/ipad|playbook|silk/i', $userAgent)) {
            $device = 'tablet';
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $ipHash = hash('sha256', $ip . date('Y-m-d'));
        $sessionId = $_COOKIE['djerba_session_id'] ?? bin2hex(random_bytes(16));

        if (!isset($_COOKIE['djerba_session_id'])) {
            setcookie('djerba_session_id', $sessionId, time() + 86400 * 30, '/');
        }

        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO page_views (url_path, referrer_domain, device_type, session_id, ip_hash)
                VALUES (:url, :ref, :device, :sess, :hash)
            ");
            $stmt->execute([
                'url'    => substr($urlPath, 0, 250),
                'ref'    => substr($referrer, 0, 140),
                'device' => $device,
                'sess'   => $sessionId,
                'hash'   => $ipHash
            ]);
        } catch (\Exception $e) {
            // Ignore analytics tracking failures silently
        }
    }
}