<?php
namespace App\Services;

use PDO;

class LoggerService {
    public function __construct(private ?PDO $pdo = null) {}

    public function log(string $event, string $severity, string $message, ?array $payload = null, ?string $ip = null): void {
        $ip = $ip ?? $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

        // 1. Écriture Fichier Log
        $logFile = __DIR__ . '/../../storage/logs/audit-' . date('Y-m-d') . '.log';
        $logEntry = sprintf(
            "[%s] [%s] [%s] %s | IP: %s | Payload: %s\n",
            date('Y-m-d H:i:s'),
            strtoupper($severity),
            $event,
            $message,
            $ip,
            json_encode($payload, JSON_UNESCAPED_UNICODE)
        );
        @file_put_contents($logFile, $logEntry, FILE_APPEND);

        // 2. Écriture Base de Données SQL si PDO disponible
        if ($this->pdo) {
            try {
                $stmt = $this->pdo->prepare("
                    INSERT INTO audit_logs (event_type, severity, message, payload_json, ip_address, user_agent)
                    VALUES (:event, :severity, :message, :payload, :ip, :ua)
                ");
                $stmt->execute([
                    'event'    => $event,
                    'severity' => $severity,
                    'message'  => $message,
                    'payload'  => $payload ? json_encode($payload) : null,
                    'ip'       => $ip,
                    'ua'       => $userAgent
                ]);
            } catch (\Exception $e) {
                // Ignore DB logging failure to avoid infinite loops
            }
        }
    }
}