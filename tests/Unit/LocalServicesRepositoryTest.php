<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Core\Database;
use App\Repositories\PdoLocalServiceRepository;
use App\Repositories\PdoBookingScheduleRepository;
use App\Models\LocalService;
use App\Models\ServiceBooking;
use App\Models\AirportTransfer;

class LocalServicesRepositoryTest extends TestCase {
    private PdoLocalServiceRepository $serviceRepo;
    private PdoBookingScheduleRepository $scheduleRepo;
    private \PDO $pdo;

    protected function setUp(): void {
        $this->pdo = Database::getInstance();
        $this->serviceRepo = new PdoLocalServiceRepository($this->pdo);
        $this->scheduleRepo = new PdoBookingScheduleRepository($this->pdo);

        // Nettoyer et réinitialiser des données de test
        $this->pdo->exec("DELETE FROM local_services");
        $this->pdo->exec("DELETE FROM service_bookings");
        $this->pdo->exec("DELETE FROM airport_transfers");

        $this->pdo->exec("
            INSERT INTO local_services (id, category, slug, name, short_description, price_eur, unit_label, duration_label, location_label, badge, image_url, is_active, sort_order)
            VALUES (10, 'quad', 'quad-test', 'Randonnée Quad Test', 'Description quad', 40.0, 'par quad', '2h', 'Lagune', 'Top', 'quad.png', 1, 1),
                   (11, 'nautisme', 'jet-ski-test', 'Jet Ski Test', 'Description jet', 65.0, 'par jet', '30m', 'Plage', NULL, 'jet.png', 1, 2)
        ");
    }

    public function testServiceRetrieval() {
        $service = $this->serviceRepo->findById(10);
        $this->assertNotNull($service);
        $this->assertEquals('quad-test', $service->slug);
        $this->assertEquals(40.0, $service->priceEur);

        $quads = $this->serviceRepo->getByCategory('quad');
        $this->assertNotEmpty($quads);
        $this->assertEquals(1, count($quads));

        $all = $this->serviceRepo->getAllActive();
        $this->assertEquals(2, count($all));
    }

    public function testServiceBookingAndSchedule() {
        $booking = new ServiceBooking(
            orderId: 1,
            serviceId: 10,
            guestsCount: 2,
            unitPrice: 40.0,
            totalPrice: 80.0,
            status: 'confirmed'
        );
        $created = $this->scheduleRepo->createBooking($booking);
        $this->assertNotNull($created->id);

        $bookings = $this->scheduleRepo->getBookingsByOrderId(1);
        $this->assertEquals(1, count($bookings));
        $this->assertEquals('Randonnée Quad Test', $bookings[0]->service->name);

        $updated = $this->scheduleRepo->updateBookingSchedule($created->id, '2026-10-15', '17:30', 'Préférence sunset');
        $this->assertTrue($updated);

        $found = $this->scheduleRepo->findBookingById($created->id);
        $this->assertEquals('2026-10-15', $found->scheduledDate);
        $this->assertEquals('17:30', $found->scheduledTime);
        $this->assertEquals('scheduled', $found->status);
    }

    public function testAirportTransfer() {
        $transfer = new AirportTransfer(
            orderId: 1,
            flightNumber: 'TU720',
            airline: 'Tunisair',
            arrivalDate: '2026-10-14',
            arrivalTime: '14:20',
            passengersCount: 2,
            dropoffLocation: 'Hôtel Hasdrubal',
            phoneWhatsapp: '+33612345678',
            status: 'pending'
        );

        $saved = $this->scheduleRepo->saveAirportTransfer($transfer);
        $this->assertNotNull($saved->id);

        $retrieved = $this->scheduleRepo->getAirportTransferByOrderId(1);
        $this->assertNotNull($retrieved);
        $this->assertEquals('TU720', $retrieved->flightNumber);
        $this->assertEquals('Hôtel Hasdrubal', $retrieved->dropoffLocation);
    }
}
