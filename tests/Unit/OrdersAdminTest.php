<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Core\Database;
use App\Models\Order;
use App\Repositories\PdoOrderRepository;

class OrdersAdminTest extends TestCase {
    private \PDO $pdo;
    private PdoOrderRepository $orderRepo;

    protected function setUp(): void {
        $this->pdo = Database::getInstance();
        $this->orderRepo = new PdoOrderRepository($this->pdo);

        // Réinitialiser les tables pour un environnement de test isolé
        $this->pdo->exec("DELETE FROM orders");
        $this->pdo->exec("DELETE FROM service_bookings");
        $this->pdo->exec("DELETE FROM airport_transfers");
        $this->pdo->exec("DELETE FROM download_tokens");

        // Insérer un jeu de commandes de test
        $this->pdo->exec("
            INSERT INTO orders (id, order_number, customer_email, total_amount, currency, stripe_session_id, status, type, created_at)
            VALUES 
            (10, 'CMD-TEST-1', 'karim@test.tn', 120.0, 'EUR', 'sess_10', 'paid', 'service_pass', CURRENT_TIMESTAMP),
            (20, 'CMD-TEST-2', 'sarah@test.tn', 45.0, 'EUR', 'sess_20', 'pending', 'digital_product', CURRENT_TIMESTAMP),
            (30, 'CMD-TEST-3', 'alex@test.tn', 80.0, 'EUR', 'sess_30', 'cancelled', 'service_pass', CURRENT_TIMESTAMP)
        ");

        // Insérer une navette aéroport pour la commande 10
        $this->pdo->exec("
            INSERT INTO airport_transfers (id, order_id, flight_number, airline, phone_whatsapp, status)
            VALUES (1, 10, 'TU720', 'Tunisair', '+21698765432', 'confirmed')
        ");

        // Insérer une réservation de service pour la commande 10
        $this->pdo->exec("
            INSERT INTO service_bookings (id, order_id, service_id, scheduled_date, scheduled_time, guests_count, unit_price, total_price, status)
            VALUES (1, 10, 1, '2026-10-15', '14:00', 2, 60.0, 120.0, 'confirmed')
        ");
    }

    public function testGetStatsCalculation() {
        $stats = $this->orderRepo->getStats();
        $this->assertEquals(3, $stats['total_count']);
        $this->assertEquals(1, $stats['paid_count']);
        $this->assertEquals(1, $stats['pending_count']);
        $this->assertEquals(1, $stats['cancelled_count']);
        $this->assertEquals(120.0, $stats['total_revenue']);
    }

    public function testGetPaginatedWithStatusFilter() {
        // Filtrer uniquement les commandes payées
        $paidResult = $this->orderRepo->getPaginated(1, 10, '', 'paid');
        $this->assertEquals(1, $paidResult['total']);
        $this->assertEquals('CMD-TEST-1', $paidResult['items'][0]->orderNumber);

        // Filtrer les commandes en attente
        $pendingResult = $this->orderRepo->getPaginated(1, 10, '', 'pending');
        $this->assertEquals(1, $pendingResult['total']);
        $this->assertEquals('CMD-TEST-2', $pendingResult['items'][0]->orderNumber);
    }

    public function testGetPaginatedWithSearchQuery() {
        // Recherche par email
        $resEmail = $this->orderRepo->getPaginated(1, 10, 'sarah@test.tn');
        $this->assertEquals(1, $resEmail['total']);
        $this->assertEquals('CMD-TEST-2', $resEmail['items'][0]->orderNumber);

        // Recherche par numéro de commande
        $resNumber = $this->orderRepo->getPaginated(1, 10, 'CMD-TEST-3');
        $this->assertEquals(1, $resNumber['total']);
        $this->assertEquals('alex@test.tn', $resNumber['items'][0]->customerEmail);
    }

    public function testEnrichedCustomerInfoAndSummary() {
        $result = $this->orderRepo->getPaginated(1, 10, 'karim@test.tn');
        $this->assertEquals(1, $result['total']);
        $order = $result['items'][0];

        // Doit avoir le téléphone / WhatsApp issu de la navette
        $this->assertEquals('+21698765432', $order->customerPhone);
        // Doit avoir un résumé incluant la navette
        $this->assertNotEmpty($order->summaryDescription);
    }

    public function testGetOrderDetailsCompleteStructure() {
        $details = $this->orderRepo->getOrderDetails(10);
        $this->assertNotNull($details);
        $this->assertEquals('CMD-TEST-1', $details['order']->orderNumber);
        $this->assertEquals('+21698765432', $details['customer_phone']);

        $this->assertIsArray($details['bookings']);
        $this->assertEquals(1, count($details['bookings']));
        $this->assertEquals('TU720', $details['transfer']['flight_number'] ?? null);
    }

    public function testUpdateOrderStatus() {
        $ok = $this->orderRepo->updateStatus(20, 'paid');
        $this->assertTrue($ok);

        $order = $this->orderRepo->findById(20);
        $this->assertNotNull($order);
        $this->assertEquals('paid', $order->status);

        // Mettre à jour vers annulée
        $okCancel = $this->orderRepo->updateStatus(20, 'cancelled');
        $this->assertTrue($okCancel);
        $orderCancelled = $this->orderRepo->findById(20);
        $this->assertEquals('cancelled', $orderCancelled->status);
    }

    public function testUpdateOrder() {
        $order = $this->orderRepo->findById(20);
        $this->assertNotNull($order);
        $this->assertEquals('sess_20', $order->stripeSessionId);

        $order->stripeSessionId = 'sess_updated_123';
        $order->status = 'paid';
        $order->customerEmail = 'sarah_new@test.tn';
        $result = $this->orderRepo->update($order);

        $this->assertTrue($result);
        $reloaded = $this->orderRepo->findById(20);
        $this->assertEquals('sess_updated_123', $reloaded->stripeSessionId);
        $this->assertEquals('paid', $reloaded->status);
        $this->assertEquals('sarah_new@test.tn', $reloaded->customerEmail);
    }
}
