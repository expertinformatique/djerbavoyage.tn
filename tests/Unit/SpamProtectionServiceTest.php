<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Core\Database;
use App\Services\SpamProtectionService;

class SpamProtectionServiceTest extends TestCase {
    private \PDO $pdo;
    private SpamProtectionService $service;

    protected function setUp(): void {
        $this->pdo = Database::getInstance();
        $this->pdo->exec("DELETE FROM spam_rate_limits");
        $this->service = new SpamProtectionService($this->pdo);
    }

    public function testHoneypotCatchesSpamBots(): void {
        $botInput = ['_hp_security' => 'I am a robot spammer'];
        $this->assertFalse($this->service->checkHoneypot($botInput));

        $humanInput = ['_hp_security' => '', 'name' => 'Jean Dupont'];
        $this->assertTrue($this->service->checkHoneypot($humanInput));
    }

    public function testSubmissionTimeFilter(): void {
        $instantSubmit = ['_form_ts' => time()]; // 0 seconds
        $this->assertFalse($this->service->checkSubmissionTime($instantSubmit, 2));

        $humanSubmit = ['_form_ts' => time() - 5]; // 5 seconds
        $this->assertTrue($this->service->checkSubmissionTime($humanSubmit, 2));
    }

    public function testDisposableEmailsBlocked(): void {
        $result = $this->service->checkContent('Bonjour', 'spammer@mailinator.com');
        $this->assertFalse($result['valid']);

        $result = $this->service->checkContent('Bonjour', 'voyageur@gmail.com');
        $this->assertTrue($result['valid']);
    }

    public function testExcessiveLinksAndKeywordsBlocked(): void {
        $spamText = "Visitez https://spam1.com et https://spam2.com et https://spam3.com";
        $result = $this->service->checkContent($spamText, 'test@gmail.com');
        $this->assertFalse($result['valid']);

        $keywordText = "Earn easy money with crypto investment right now";
        $result = $this->service->checkContent($keywordText, 'test@gmail.com');
        $this->assertFalse($result['valid']);

        $normalText = "Bonjour, nous aimerions réserver une sortie en mer pour 2 personnes le 15 octobre.";
        $result = $this->service->checkContent($normalText, 'client@orange.fr');
        $this->assertTrue($result['valid']);
    }

    public function testRateLimitingByIp(): void {
        $ip = '192.168.1.50';
        $action = 'contact';

        // 3 tentatives autorisées avec un seuil de 3
        $this->assertTrue($this->service->checkRateLimit($ip, $action, 3));
        $this->service->recordAttempt($ip, $action);
        $this->service->recordAttempt($ip, $action);
        $this->service->recordAttempt($ip, $action);

        // La 4ème tentative doit être bloquée
        $this->assertFalse($this->service->checkRateLimit($ip, $action, 3));
    }
}
