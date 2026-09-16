<?php
namespace App\Controllers;

use Core\Controller;
use Core\Database;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use App\Services\AnalyticsService;
use App\Services\SettingsService;
use App\Services\StripeService;

class ConciergeController extends Controller {
    public function __construct(
        private SettingsService $settings,
        private AnalyticsService $analytics,
        private OrderRepositoryInterface $orderRepo,
        private StripeService $stripeService
    ) {}

    public function index(): void {
        $this->analytics->trackPageView('/concierge');

        $this->render('pages/concierge', [
            'seoTitle'       => 'Conciergerie Djerba | Itinéraire Sur-Mesure',
            'seoDescription' => 'Confiez l\'organisation de votre séjour à Djerba à nos experts locaux.',
            'conciergePrice' => $this->settings->get('concierge_price', '29.00'),
            'settings'       => $this->settings
        ]);
    }

    public function checkout(): void {
        header('Content-Type: application/json; charset=utf-8');

        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $name = trim($input['name'] ?? '');
        $email = filter_var($input['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $dates = trim($input['dates'] ?? '');

        if (!$name || !$email || !$dates) {
            http_response_code(400);
            echo json_encode(['error' => 'Veuillez renseigner votre nom, email et dates de séjour.']);
            return;
        }

        $price = (float)$this->settings->get('concierge_price', '29.00');
        $orderNumber = 'CON-VIP-' . strtoupper(bin2hex(random_bytes(3)));
        $domain = rtrim(absolute_url(''), '/');

        $session = $this->stripeService->createCheckoutSession([
            'title'        => 'Conciergerie VIP Djerba (Planification Sur-Mesure)',
            'price_eur'    => $price,
            'email'        => $email,
            'type'         => 'concierge',
            'order_number' => $orderNumber,
            'domain'       => $domain
        ]);

        $order = new Order(
            orderNumber: $orderNumber,
            customerEmail: $email,
            totalAmount: $price,
            currency: 'EUR',
            stripeSessionId: $session['id'],
            status: 'paid',
            type: 'concierge'
        );

        $createdOrder = $this->orderRepo->create($order);

        // Sauvegarde du ticket de conciergerie dans la BDD
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("
            INSERT INTO concierge_tickets (order_id, client_name, client_email, travel_dates, status)
            VALUES (:order_id, :name, :email, :dates, 'new')
        ");
        $stmt->execute([
            'order_id' => $createdOrder->id,
            'name'     => $name,
            'email'    => $email,
            'dates'    => $dates
        ]);

        echo json_encode([
            'success'      => true,
            'session_id'   => $session['id'],
            'order_number' => $orderNumber,
            'redirect_url' => $session['url']
        ]);
    }
}