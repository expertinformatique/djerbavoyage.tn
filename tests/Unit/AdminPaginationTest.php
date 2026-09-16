<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Core\Database;
use App\Models\Product;
use App\Models\User;
use App\Repositories\PdoProductRepository;
use App\Repositories\PdoUserRepository;
use App\Repositories\PdoNewsletterRepository;
use App\Repositories\PdoBookingScheduleRepository;

class AdminPaginationTest extends TestCase {
    private \PDO $pdo;

    protected function setUp(): void {
        $this->pdo = Database::getInstance();
    }

    public function testProductPagination() {
        $repo = new PdoProductRepository($this->pdo);
        $this->pdo->exec("DELETE FROM products");
        $this->pdo->exec("INSERT INTO products (id, slug, title_fr, price_eur, file_path) VALUES (1, 'guide-test', 'Guide Test', 9.90, 'storage/downloads/test.pdf')");

        for ($i = 2; $i <= 5; $i++) {
            $p = new Product();
            $p->slug = "guide-test-{$i}";
            $p->titleFr = "Guide Test {$i}";
            $p->priceEur = 10.0 + $i;
            $p->filePath = "guide_{$i}.pdf";
            $p->isActive = true;
            $repo->create($p);
        }

        $this->assertEquals(5, $repo->countAll());

        // Page 1 (limit 2)
        $p1 = $repo->getPaginated(1, 2);
        $this->assertEquals(5, $p1['total']);
        $this->assertEquals(2, count($p1['items']));

        // Page 3 (limit 2 -> 1 élément restant)
        $p3 = $repo->getPaginated(3, 2);
        $this->assertEquals(5, $p3['total']);
        $this->assertEquals(1, count($p3['items']));
    }

    public function testUserPagination() {
        $repo = new PdoUserRepository($this->pdo);
        $this->pdo->exec("DELETE FROM users");
        $this->pdo->exec("INSERT INTO users (id, username, email, password, role) VALUES (1, 'admin', 'admin@djerbavoyage.tn', '\$2y\$10\$abcdefghijklmnopqrstuv', 'admin')");

        for ($i = 2; $i <= 4; $i++) {
            $u = new User();
            $u->username = "user_{$i}";
            $u->email = "user{$i}@djerbavoyage.tn";
            $u->password = password_hash('password123', PASSWORD_BCRYPT);
            $u->role = 'editor';
            $repo->create($u);
        }

        $this->assertEquals(4, $repo->count());

        $p1 = $repo->getPaginated(1, 2);
        $this->assertEquals(4, $p1['total']);
        $this->assertEquals(2, count($p1['items']));

        $p2 = $repo->getPaginated(2, 2);
        $this->assertEquals(4, $p2['total']);
        $this->assertEquals(2, count($p2['items']));
    }

    public function testNewsletterPagination() {
        $repo = new PdoNewsletterRepository($this->pdo);
        $this->pdo->exec("DELETE FROM newsletter_subscribers");

        for ($i = 1; $i <= 5; $i++) {
            $repo->subscribe("subscriber{$i}@example.com", "token_{$i}");
        }

        $this->assertEquals(5, $repo->countAll());
        $this->assertEquals(5, $repo->countActive());

        // Test offset et limit
        $subPage1 = $repo->getAll(2, 0);
        $this->assertEquals(2, count($subPage1));

        $subPage3 = $repo->getAll(2, 4);
        $this->assertEquals(1, count($subPage3));
    }

    public function testBookingSchedulePassOrdersPagination() {
        $repo = new PdoBookingScheduleRepository($this->pdo);
        $this->pdo->exec("DELETE FROM airport_transfers");
        $this->pdo->exec("DELETE FROM service_bookings");
        $this->pdo->exec("DELETE FROM orders");
        $this->pdo->exec("INSERT INTO orders (id, order_number, customer_email, total_amount, stripe_session_id, status, type) VALUES (1, 'CMD-TEST', 'client@test.tn', 9.90, 'sess_test', 'paid', 'digital_product')");

        for ($i = 1; $i <= 3; $i++) {
            $this->pdo->exec("
                INSERT INTO orders (order_number, customer_email, total_amount, currency, status, type, created_at)
                VALUES ('PASS-00{$i}', 'client{$i}@example.com', 150.0, 'EUR', 'paid', 'service_pass', CURRENT_TIMESTAMP)
            ");
        }

        $this->assertEquals(3, $repo->countPassOrders());

        $page1 = $repo->getPaginatedPassOrders(1, 2);
        $this->assertEquals(3, $page1['total']);
        $this->assertEquals(2, count($page1['items']));

        $page2 = $repo->getPaginatedPassOrders(2, 2);
        $this->assertEquals(3, $page2['total']);
        $this->assertEquals(1, count($page2['items']));
    }
}
