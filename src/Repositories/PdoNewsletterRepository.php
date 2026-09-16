<?php
namespace App\Repositories;

use App\Interfaces\NewsletterRepositoryInterface;
use PDO;
use Throwable;

class PdoNewsletterRepository implements NewsletterRepositoryInterface {
    public function __construct(private PDO $pdo) {}

    private function logError(Throwable $e): void {
        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        @error_log("[" . date('Y-m-d H:i:s') . "] ERROR " . $e->getCode() . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL, 3, $rootPath . '/error.log');
    }

    public function findByEmail(string $email): ?array {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM newsletter_subscribers WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => strtolower(trim($email))]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ?: null;
        } catch (Throwable $e) {
            $this->logError($e);
            return null;
        }
    }

    public function findByToken(string $token): ?array {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM newsletter_subscribers WHERE token = :token LIMIT 1");
            $stmt->execute(['token' => trim($token)]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ?: null;
        } catch (Throwable $e) {
            $this->logError($e);
            return null;
        }
    }

    public function subscribe(string $email, string $token, ?string $ip = null): string {
        $cleanEmail = strtolower(trim($email));
        try {
            $existing = $this->findByEmail($cleanEmail);
            if ($existing) {
                if ($existing['status'] === 'active') {
                    return 'already_active';
                }
                $stmt = $this->pdo->prepare("UPDATE newsletter_subscribers SET status = 'active', token = :token, ip_address = :ip, unsubscribed_at = NULL WHERE id = :id");
                $stmt->execute(['token' => $token, 'ip' => $ip, 'id' => $existing['id']]);
                return 'reactivated';
            }

            $stmt = $this->pdo->prepare("INSERT INTO newsletter_subscribers (email, status, token, ip_address) VALUES (:email, 'active', :token, :ip)");
            $stmt->execute(['email' => $cleanEmail, 'token' => $token, 'ip' => $ip]);
            return 'created';
        } catch (Throwable $e) {
            $this->logError($e);
            return 'error';
        }
    }

    public function unsubscribe(string $token): bool {
        try {
            $stmt = $this->pdo->prepare("UPDATE newsletter_subscribers SET status = 'unsubscribed', unsubscribed_at = CURRENT_TIMESTAMP WHERE token = :token");
            $stmt->execute(['token' => trim($token)]);
            return $stmt->rowCount() > 0;
        } catch (Throwable $e) {
            $this->logError($e);
            return false;
        }
    }

    public function countActive(): int {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM newsletter_subscribers WHERE status = 'active'");
            return (int)$stmt->fetchColumn();
        } catch (Throwable $e) {
            $this->logError($e);
            return 0;
        }
    }

    public function getAll(int $limit = 100, int $offset = 0): array {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM newsletter_subscribers ORDER BY id DESC LIMIT :limit OFFSET :offset");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (Throwable $e) {
            $this->logError($e);
            return [];
        }
    }
}
