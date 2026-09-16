<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Core\Database;
use App\Repositories\PdoContactRepository;
use App\Services\ContactService;
use App\Services\SmtpMailerService;

class ContactTestMailerService extends SmtpMailerService {
    public array $sent = [];

    public function send(string $to, string $subject, string $htmlBody, string $textBody = ''): bool {
        $this->sent[] = [
            'to'      => $to,
            'subject' => $subject,
            'html'    => $htmlBody
        ];
        return true;
    }
}

class ContactServiceTest extends TestCase {
    private \PDO $pdo;
    private PdoContactRepository $repo;
    private ContactTestMailerService $mailer;
    private ContactService $service;

    protected function setUp(): void {
        $this->pdo = Database::getInstance();
        $this->pdo->exec("DELETE FROM contact_messages");
        $this->repo = new PdoContactRepository($this->pdo);
        $this->mailer = new ContactTestMailerService();
        $this->service = new ContactService($this->repo, $this->mailer);
    }

    public function testHandleContactSuccessSavesToDatabaseAndEmailsReservation(): void {
        $data = [
            'name'    => 'Laurent Dupont',
            'email'   => 'laurent.dupont@example.com',
            'phone'   => '+33 6 99 88 77 66',
            'subject' => 'Réservation Excursion Désert',
            'message' => 'Bonjour, nous serons 4 personnes du 12 au 18 octobre. Est-il possible de réserver le bivouac à Ksar Ghilane ?'
        ];

        $res = $this->service->handleContact($data, '192.168.1.10');

        $this->assertTrue($res['success']);
        $this->assertNotNull($res['id']);
        $this->assertEquals(1, $this->repo->countAll());

        $saved = $this->repo->findById($res['id']);
        $this->assertNotNull($saved);
        $this->assertEquals('Laurent Dupont', $saved->name);
        $this->assertEquals('laurent.dupont@example.com', $saved->email);
        $this->assertEquals('+33 6 99 88 77 66', $saved->phone);
        $this->assertEquals('Réservation Excursion Désert', $saved->subject);

        // Vérification de l'envoi de l'e-mail
        $this->assertEquals(1, count($this->mailer->sent));
        $this->assertEquals('reservation@djerbavoyage.tn', $this->mailer->sent[0]['to']);
        $this->assertTrue(str_contains($this->mailer->sent[0]['subject'], 'Laurent Dupont'));
        $this->assertTrue(str_contains($this->mailer->sent[0]['html'], 'laurent.dupont@example.com'));
        $this->assertTrue(str_contains($this->mailer->sent[0]['html'], 'Ksar Ghilane'));
    }

    public function testHandleContactFailsWithoutName(): void {
        $res = $this->service->handleContact([
            'name'    => '',
            'email'   => 'client@example.com',
            'message' => 'Bonjour, une question...'
        ]);

        $this->assertFalse($res['success']);
        $this->assertEquals(0, $this->repo->countAll());
        $this->assertEquals(0, count($this->mailer->sent));
    }

    public function testHandleContactFailsWithInvalidEmail(): void {
        $res = $this->service->handleContact([
            'name'    => 'Ali',
            'email'   => 'not-an-email',
            'message' => 'Bonjour le message valide'
        ]);

        $this->assertFalse($res['success']);
        $this->assertEquals(0, $this->repo->countAll());
    }

    public function testHandleContactFailsWithShortMessage(): void {
        $res = $this->service->handleContact([
            'name'    => 'Ali',
            'email'   => 'ali@test.tn',
            'message' => 'Hey'
        ]);

        $this->assertFalse($res['success']);
        $this->assertEquals(0, $this->repo->countAll());
    }

    public function testRepositoryListingAndPagination(): void {
        $this->service->handleContact(['name' => 'Client 1', 'email' => 'c1@test.com', 'message' => 'Message un']);
        $this->service->handleContact(['name' => 'Client 2', 'email' => 'c2@test.com', 'message' => 'Message deux']);

        $all = $this->repo->getAll(10, 0);
        $this->assertEquals(2, count($all));
        $this->assertEquals(2, $this->repo->countAll());

        $first = $this->repo->getAll(1, 0);
        $this->assertEquals(1, count($first));
    }
}
