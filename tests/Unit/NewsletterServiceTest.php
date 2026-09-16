<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Core\Database;
use App\Repositories\PdoNewsletterRepository;
use App\Services\NewsletterService;
use App\Services\SmtpMailerService;

class TestSmtpMailerService extends SmtpMailerService {
    public array $sentEmails = [];

    public function send(string $to, string $subject, string $htmlBody, string $textBody = ''): bool {
        $this->sentEmails[] = [
            'to' => $to,
            'subject' => $subject,
            'html' => $htmlBody
        ];
        return true;
    }
}

class NewsletterServiceTest extends TestCase {
    private \PDO $pdo;
    private PdoNewsletterRepository $repo;
    private TestSmtpMailerService $mailer;
    private NewsletterService $service;

    protected function setUp(): void {
        $this->pdo = Database::getInstance();
        $this->pdo->exec("DELETE FROM newsletter_subscribers");
        $this->repo = new PdoNewsletterRepository($this->pdo);
        $this->mailer = new TestSmtpMailerService();
        $this->service = new NewsletterService($this->repo, $this->mailer);
    }

    public function testSuccessfulSubscriptionSendsWelcomeEmail(): void {
        $res = $this->service->subscribe('voyageur@example.com', '127.0.0.1');

        $this->assertTrue($res['success']);
        $this->assertEquals('created', $res['status']);
        $this->assertEquals(1, $this->repo->countActive());

        $sub = $this->repo->findByEmail('voyageur@example.com');
        $this->assertNotNull($sub);
        $this->assertEquals('active', $sub['status']);
        $this->assertNotEmpty($sub['token']);

        $this->assertEquals(1, count($this->mailer->sentEmails));
        $this->assertEquals('voyageur@example.com', $this->mailer->sentEmails[0]['to']);
        $this->assertTrue(str_contains($this->mailer->sentEmails[0]['html'], 'CLUB-DJERBA-10'));
    }

    public function testDuplicateSubscriptionReturnsAlreadyActive(): void {
        $this->service->subscribe('duplicate@example.com', '127.0.0.1');
        $res2 = $this->service->subscribe('duplicate@example.com', '127.0.0.1');

        $this->assertTrue($res2['success']);
        $this->assertEquals('already_active', $res2['status']);
        $this->assertEquals(1, $this->repo->countActive());
        $this->assertEquals(1, count($this->mailer->sentEmails));
    }

    public function testInvalidEmailReturnsError(): void {
        $res = $this->service->subscribe('not-an-email');

        $this->assertFalse($res['success']);
        $this->assertEquals('invalid_email', $res['status']);
        $this->assertEquals(0, $this->repo->countActive());
        $this->assertEquals(0, count($this->mailer->sentEmails));
    }

    public function testUnsubscribeWithToken(): void {
        $this->service->subscribe('partant@example.com');
        $sub = $this->repo->findByEmail('partant@example.com');
        $this->assertNotNull($sub);

        $unsubOk = $this->service->unsubscribe($sub['token']);
        $this->assertTrue($unsubOk);
        $this->assertEquals(0, $this->repo->countActive());

        $updated = $this->repo->findByToken($sub['token']);
        $this->assertEquals('unsubscribed', $updated['status']);
        $this->assertNotNull($updated['unsubscribed_at']);
    }

    public function testReactivationAfterUnsubscribe(): void {
        $this->service->subscribe('revenir@example.com');
        $sub = $this->repo->findByEmail('revenir@example.com');
        $this->service->unsubscribe($sub['token']);

        $resReactivate = $this->service->subscribe('revenir@example.com');
        $this->assertTrue($resReactivate['success']);
        $this->assertEquals('reactivated', $resReactivate['status']);
        $this->assertEquals(1, $this->repo->countActive());
    }

    public function testInvalidTokenUnsubscribeFails(): void {
        $this->assertFalse($this->service->unsubscribe(''));
        $this->assertFalse($this->service->unsubscribe('short'));
        $this->assertFalse($this->service->unsubscribe('token_inconnu_1234567890'));
    }

    public function testSmtpMailerSettingsMatchRequirements(): void {
        $settings = (new SmtpMailerService())->getSettings();

        $this->assertEquals('mail.djerbavoyage.tn', $settings['outgoing']['server']);
        $this->assertEquals(465, $settings['outgoing']['port']);
        $this->assertEquals('SSL/TLS', $settings['outgoing']['secure']);
        $this->assertEquals('reservation@djerbavoyage.tn', $settings['outgoing']['user']);

        $this->assertEquals('mail.djerbavoyage.tn', $settings['incoming']['server']);
        $this->assertEquals(993, $settings['incoming']['imap']);
        $this->assertEquals(995, $settings['incoming']['pop3']);
    }

    public function testRepositoryListingAndPagination(): void {
        $this->service->subscribe('alpha@example.com');
        $this->service->subscribe('beta@example.com');

        $all = $this->repo->getAll(10, 0);
        $this->assertEquals(2, count($all));
        $this->assertEquals(2, $this->repo->countActive());

        $firstPage = $this->repo->getAll(1, 0);
        $this->assertEquals(1, count($firstPage));
    }
}
