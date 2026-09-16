<?php
namespace App\Services;

use PDO;
use Exception;

/**
 * Service de Protection Anti-Spam Multi-Niveaux pour l'envoi d'emails
 * Règle 2 : 100% compatible SQLite et MySQL
 * Règle 6 : < 200 lignes, méthodes < 40 lignes
 * Règle 8 : Gestion d'erreur non-bloquante
 */
class SpamProtectionService {
    private const DISPOSABLE_DOMAINS = [
        'mailinator.com', 'tempmail.com', '10minutemail.com', 'guerrillamail.com',
        'yopmail.com', 'trashmail.com', 'fakeinbox.com', 'sharklasers.com',
        'dispostable.com', 'getairmail.com', 'throwawaymail.com'
    ];

    private const SPAM_KEYWORDS = [
        '[url=', '<a href=', 'viagra', 'cialis', 'crypto investment',
        'telegram.me/', 't.me/', 'whatsapp marketing', 'seo ranking boost',
        'casino bonus', 'earn money fast', 'bitcoin doubler'
    ];

    public function __construct(private ?PDO $pdo = null) {}

    public function checkHoneypot(array $input): bool {
        // Si le champ piège invisible est rempli, c'est un bot
        return empty($input['_hp_security']) && empty($input['website_hp']);
    }

    public function checkSubmissionTime(array $input, int $minSeconds = 2): bool {
        if (!isset($input['_form_ts'])) {
            return true; // Si non présent (ex: appel API externe authentifié), on ne bloque pas
        }
        $ts = (int)$input['_form_ts'];
        $now = time();
        $diff = $now - $ts;
        // Soumis en moins de 2 secondes ou formulaire périmé depuis plus de 24h
        return ($diff >= $minSeconds && $diff <= 86400);
    }

    public function checkContent(string $text, string $email = ''): array {
        // 1. Vérification du domaine d'email jetable
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $parts = explode('@', strtolower($email));
            $domain = end($parts);
            if (in_array($domain, self::DISPOSABLE_DOMAINS, true)) {
                return ['valid' => false, 'reason' => 'Les adresses e-mails temporaires ou jetables ne sont pas autorisées.'];
            }
        }

        // 2. Vérification des liens excessifs (max 2 liens autorisés)
        $linkCount = preg_match_all('#https?://#i', $text);
        if ($linkCount > 2) {
            return ['valid' => false, 'reason' => 'Votre message contient trop de liens externes.'];
        }

        // 3. Détection de mots-clés de spam / phishing
        $lowerText = strtolower($text);
        foreach (self::SPAM_KEYWORDS as $kw) {
            if (str_contains($lowerText, $kw)) {
                return ['valid' => false, 'reason' => 'Le contenu du message a été détecté comme suspect.'];
            }
        }

        return ['valid' => true, 'reason' => ''];
    }

    public function checkRateLimit(string $ip, string $action, int $maxAttempts = 5, int $windowMinutes = 10): bool {
        if (!$this->pdo || empty($ip)) {
            return true;
        }

        try {
            $cutoff = date('Y-m-d H:i:s', time() - ($windowMinutes * 60));
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) FROM spam_rate_limits 
                WHERE ip = :ip AND action = :action AND created_at >= :cutoff
            ");
            $stmt->execute([
                'ip'     => $ip,
                'action' => $action,
                'cutoff' => $cutoff
            ]);
            $count = (int)$stmt->fetchColumn();

            return $count < $maxAttempts;
        } catch (Exception $e) {
            return true; // En cas d'erreur de base, ne pas bloquer les utilisateurs légitimes
        }
    }

    public function recordAttempt(string $ip, string $action): void {
        if (!$this->pdo || empty($ip)) return;

        try {
            $stmt = $this->pdo->prepare("INSERT INTO spam_rate_limits (ip, action) VALUES (:ip, :action)");
            $stmt->execute(['ip' => $ip, 'action' => $action]);
        } catch (Exception $e) {}
    }

    public function validateSubmission(
        array $input,
        string $ip,
        string $action,
        string $contentToCheck = '',
        string $email = '',
        int $maxAttempts = 5
    ): array {
        // 1. Honeypot check
        if (!$this->checkHoneypot($input)) {
            return ['is_spam' => true, 'message' => 'Soumission bloquée par la sécurité anti-bot.'];
        }

        // 2. Délai de soumission humaine
        if (!$this->checkSubmissionTime($input)) {
            return ['is_spam' => true, 'message' => 'Soumission trop rapide ou session expirée. Veuillez réessayer.'];
        }

        // 3. Analyse du contenu et email
        $contentCheck = $this->checkContent($contentToCheck, $email);
        if (!$contentCheck['valid']) {
            return ['is_spam' => true, 'message' => $contentCheck['reason']];
        }

        // 4. Rate Limiting IP
        if (!$this->checkRateLimit($ip, $action, $maxAttempts)) {
            return ['is_spam' => true, 'message' => 'Trop de tentatives en peu de temps. Veuillez patienter quelques minutes.'];
        }

        // Enregistrer la tentative valide
        $this->recordAttempt($ip, $action);

        return ['is_spam' => false, 'message' => ''];
    }
}
