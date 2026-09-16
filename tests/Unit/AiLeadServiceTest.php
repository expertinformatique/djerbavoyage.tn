<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Core\Database;
use App\Repositories\PdoAiLeadRepository;
use App\Services\AiLeadService;
use App\Services\SmtpMailerService;

class AiLeadTestMailerService extends SmtpMailerService {
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

class AiLeadServiceTest extends TestCase {
    private \PDO $pdo;
    private PdoAiLeadRepository $repo;
    private AiLeadTestMailerService $mailer;
    private AiLeadService $service;

    protected function setUp(): void {
        $this->pdo = Database::getInstance();
        $this->pdo->exec("DELETE FROM ai_leads");
        $this->repo = new PdoAiLeadRepository($this->pdo);
        $this->mailer = new AiLeadTestMailerService();
        $this->service = new AiLeadService($this->repo, $this->mailer);
    }

    public function testProcessLeadSuccessSavesToDatabaseAndEmailsReservation(): void {
        $data = [
            'name'        => 'Sophie Martin',
            'email'       => 'sophie.martin@example.com',
            'phone'       => '+33 6 12 34 56 78',
            'travel_date' => '2026-10-15',
            'notes'       => 'Voyage de noces, chambre vue mer souhaitée',
            'preferences' => [
                'traveler'       => 'couple',
                'style'          => 'romance',
                'lodging'        => 'menzel',
                'pace'           => 'balanced',
                'duration'       => '7j',
                'hotel'          => 'Menzel Prestige & Spa',
                'itineraryTitle' => 'Évasion Île & Criques Sauvages'
            ]
        ];

        $res = $this->service->processLead($data, '192.168.1.50');

        $this->assertTrue($res['success'], "res[success] should be true");
        $this->assertNotNull($res['leadId'], "leadId should not be null");
        $this->assertEquals(1, $this->repo->countAll(), "countAll should be 1");

        // Vérification en base de données
        $saved = $this->repo->findById($res['leadId']);
        $this->assertNotNull($saved, "saved should not be null");
        $this->assertEquals('Sophie Martin', $saved->name);
        $this->assertEquals('sophie.martin@example.com', $saved->email);
        $this->assertEquals('+33 6 12 34 56 78', $saved->phone);
        $this->assertEquals('2026-10-15', $saved->travelDate);
        $this->assertEquals('couple', $saved->preferences['traveler']);

        // Vérification de l'envoi de l'e-mail à reservation@djerbavoyage.tn
        $this->assertEquals(1, count($this->mailer->sent), "mailer->sent count should be 1");
        $this->assertEquals('reservation@djerbavoyage.tn', $this->mailer->sent[0]['to']);
        $this->assertTrue(str_contains($this->mailer->sent[0]['subject'], 'Sophie Martin'), "subject must contain Sophie Martin");
        $this->assertTrue(str_contains($this->mailer->sent[0]['html'], 'sophie.martin@example.com'), "html must contain email");
        $this->assertTrue(str_contains($this->mailer->sent[0]['html'], '+33 6 12 34 56 78'), "html must contain phone");
        $this->assertTrue(str_contains($this->mailer->sent[0]['html'], 'Menzel Prestige &amp; Spa'), "html must contain hotel");
    }

    public function testProcessLeadFailsWithoutName(): void {
        $res = $this->service->processLead([
            'name'  => '',
            'email' => 'client@example.com'
        ]);

        $this->assertFalse($res['success']);
        $this->assertEquals(0, $this->repo->countAll());
        $this->assertEquals(0, count($this->mailer->sent));
    }

    public function testProcessLeadFailsWithInvalidEmail(): void {
        $res = $this->service->processLead([
            'name'  => 'Karim',
            'email' => 'invalid-email-address'
        ]);

        $this->assertFalse($res['success']);
        $this->assertEquals(0, $this->repo->countAll());
        $this->assertEquals(0, count($this->mailer->sent));
    }

    public function testRepositoryListingAndPagination(): void {
        $this->service->processLead(['name' => 'Lead A', 'email' => 'a@test.com']);
        $this->service->processLead(['name' => 'Lead B', 'email' => 'b@test.com']);

        $all = $this->repo->getAll(10, 0);
        $this->assertEquals(2, count($all));
        $this->assertEquals(2, $this->repo->countAll());

        $first = $this->repo->getAll(1, 0);
        $this->assertEquals(1, count($first));
    }
}
