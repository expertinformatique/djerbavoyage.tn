<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Core\Database;
use App\Repositories\PdoBookingScheduleRepository;
use App\Models\AirportTransfer;

class ServicesAdminTest extends TestCase {
    private PdoBookingScheduleRepository $scheduleRepo;
    private \PDO $pdo;

    protected function setUp(): void {
        $this->pdo = Database::getInstance();
        $this->scheduleRepo = new PdoBookingScheduleRepository($this->pdo);

        $this->pdo->exec("DELETE FROM orders WHERE type = 'service_pass'");
        $this->pdo->exec("DELETE FROM airport_transfers");

        $this->pdo->exec("
            INSERT INTO orders (id, order_number, customer_email, total_amount, stripe_session_id, status, type)
            VALUES (50, 'DJE-PASS-ADM1', 'client.adm@test.tn', 150.0, 'sess_adm', 'paid', 'service_pass')
        ");

        $this->pdo->exec("
            INSERT INTO airport_transfers (id, order_id, flight_number, arrival_date, arrival_time, status)
            VALUES (20, 50, 'BJ515', '2026-10-20', '11:00', 'pending')
        ");
    }

    public function testGetAllPassOrdersListing() {
        $passes = $this->scheduleRepo->getAllPassOrders(10);
        $this->assertNotEmpty($passes);
        $this->assertEquals(1, count($passes));
        $this->assertEquals('DJE-PASS-ADM1', $passes[0]['order_number']);
        $this->assertEquals('BJ515', $passes[0]['flight_number']);
        $this->assertEquals('pending', $passes[0]['transfer_status']);
    }

    public function testUpdateAirportTransferStatusByAdmin() {
        $ok = $this->scheduleRepo->updateAirportStatus(20, 'driver_assigned', 'Chauffeur Mohamed assigné (Mercedes Vito)');
        $this->assertTrue($ok);

        $transfer = $this->scheduleRepo->getAirportTransferByOrderId(50);
        $this->assertNotNull($transfer);
        $this->assertEquals('driver_assigned', $transfer->status);
        $this->assertEquals('Chauffeur Mohamed assigné (Mercedes Vito)', $transfer->driverNotes);
    }

    public function testSettingsRepositorySetAndGet() {
        $settingsRepo = new \App\Repositories\PdoSettingsRepository($this->pdo);
        $ok = $settingsRepo->set('booking_partner_id', '8073836');
        $this->assertTrue($ok);

        $all = $settingsRepo->getAllAsKeyValue();
        $this->assertEquals('8073836', $all['booking_partner_id'] ?? null);

        // Test update existing setting
        $okUpdate = $settingsRepo->set('booking_partner_id', '9999999');
        $this->assertTrue($okUpdate);

        $allUpdated = $settingsRepo->getAllAsKeyValue();
        $this->assertEquals('9999999', $allUpdated['booking_partner_id'] ?? null);
    }
}
