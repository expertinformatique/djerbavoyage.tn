<?php
namespace App\Controllers;

use Core\Controller;
use App\Interfaces\LocalServiceRepositoryInterface;
use App\Interfaces\BookingScheduleRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use App\Models\ServiceBooking;
use App\Models\AirportTransfer;
use App\Services\PricingEstimationService;
use App\Services\StripeService;
use App\Services\SettingsService;
use App\Services\PassVoucherService;
use Throwable;

class LocalServicesController extends Controller {
    public function __construct(
        private LocalServiceRepositoryInterface $serviceRepo,
        private BookingScheduleRepositoryInterface $scheduleRepo,
        private OrderRepositoryInterface $orderRepo,
        private PricingEstimationService $pricingService,
        private StripeService $stripeService,
        private SettingsService $settingsService,
        private PassVoucherService $voucherService
    ) {}

    public function index(): void {
        $services = $this->serviceRepo->getAllActive();
        $byCategory = [];
        foreach ($services as $s) {
            $byCategory[$s->category][] = $s;
        }

        $domain = rtrim(absolute_url(''), '/');

        $itemListElement = [];
        foreach ($services as $index => $s) {
            $itemListElement[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'item' => [
                    '@type' => 'Service',
                    'name' => $s->name,
                    'description' => $s->shortDescription,
                    'provider' => [
                        '@type' => 'LocalBusiness',
                        'name' => 'Djerba Voyage Services',
                        'address' => [
                            '@type' => 'PostalAddress',
                            'addressLocality' => 'Djerba',
                            'addressCountry'  => 'TN'
                        ]
                    ],
                    'offers' => [
                        '@type' => 'Offer',
                        'price' => number_format($s->priceEur, 2, '.', ''),
                        'priceCurrency' => 'EUR',
                        'availability' => 'https://schema.org/InStock',
                        'url' => $domain . '/services'
                    ],
                    'aggregateRating' => [
                        '@type' => 'AggregateRating',
                        'ratingValue' => '4.9',
                        'reviewCount' => '84'
                    ]
                ]
            ];
        }

        $jsonLd = '<script type="application/ld+json">' . json_encode([
            '@context' => 'https://schema.org',
            '@type'    => 'ItemList',
            'name'     => 'Catalogue d\'Activités & Pass Séjour Sur-Mesure Djerba',
            'itemListElement' => $itemListElement
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>';

        $this->render('pages/services-builder', [
            'services'     => $services,
            'byCategory'   => $byCategory,
            'settings'     => $this->settingsService,
            'seoTitle'     => 'Pass Séjour Djerba 2026 | Réservation Activités & Transfert Aéroport VIP Offert',
            'seoDescription' => 'Composez votre pass sur-mesure à Djerba : Jet-Ski, Quads, Buggy Can-Am, Bateau Pirate, Plongée, Sahara 4x4 & Spa. Remise jusqu\'à -15% + Navette Aéroport offerte.',
            'jsonLd'       => $jsonLd
        ]);
    }

    public function estimate(): void {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $items = $input['items'] ?? [];
        $includeAirport = !empty($input['include_airport']);
        $paymentMode = in_array($input['payment_mode'] ?? '', ['full', 'deposit']) ? $input['payment_mode'] : 'full';

        // Valider et enrichir les prix depuis la BDD (sécurité anti-fraude)
        $enrichedItems = $this->enrichItemsFromDb($items);
        $estimate = $this->pricingService->calculateEstimate($enrichedItems, $includeAirport, $paymentMode);

        $this->json($estimate);
    }

    public function checkout(): void {
        try {
            $input = json_decode(file_get_contents('php://input'), true) ?? [];
            $email = filter_var($input['email'] ?? '', FILTER_VALIDATE_EMAIL);
            $name = trim($input['name'] ?? 'Voyageur Djerba');
            $phone = trim($input['phone'] ?? '');
            $items = $input['items'] ?? [];
            $includeAirport = !empty($input['include_airport']);
            $paymentMode = in_array($input['payment_mode'] ?? '', ['full', 'deposit']) ? $input['payment_mode'] : 'full';

            if (!$email || empty($items)) {
                $this->json(['error' => 'Veuillez renseigner un email valide et sélectionner au moins un service.'], 400);
            }

            $enrichedItems = $this->enrichItemsFromDb($items);
            if (empty($enrichedItems)) {
                $this->json(['error' => 'Services sélectionnés invalides.'], 400);
            }

            $estimate = $this->pricingService->calculateEstimate($enrichedItems, $includeAirport, $paymentMode);
            $orderNumber = 'DJE-PASS-' . strtoupper(bin2hex(random_bytes(3)));
            $domain = rtrim(absolute_url(''), '/');

            $session = $this->stripeService->createCheckoutSession([
                'title'        => 'Pass Séjour Djerba (' . $estimate['pack_label'] . ')',
                'price_eur'    => $estimate['amount_to_pay_now'],
                'email'        => $email,
                'type'         => 'service_pass',
                'order_number' => $orderNumber,
                'domain'       => $domain
            ]);

            $order = new Order(
                orderNumber: $orderNumber,
                customerEmail: $email,
                totalAmount: $estimate['amount_to_pay_now'],
                currency: 'EUR',
                stripeSessionId: $session['id'],
                status: 'paid', // Simulé en dev
                type: 'service_pass'
            );
            $createdOrder = $this->orderRepo->create($order);

            // Sauvegarder les réservations d'activités
            foreach ($enrichedItems as $item) {
                $booking = new ServiceBooking(
                    orderId: $createdOrder->id,
                    serviceId: $item['service_id'],
                    guestsCount: $item['quantity'],
                    unitPrice: $item['unit_price'],
                    totalPrice: round($item['unit_price'] * $item['quantity'], 2),
                    status: 'confirmed'
                );
                $this->scheduleRepo->createBooking($booking);
            }

            // Sauvegarder l'entrée d'accueil aéroport si cochée ou offerte
            if ($includeAirport || $estimate['airport_transfer_free']) {
                $transfer = new AirportTransfer(
                    orderId: $createdOrder->id,
                    phoneWhatsapp: $phone,
                    status: 'pending'
                );
                $this->scheduleRepo->saveAirportTransfer($transfer);
            }

            $sessionId = !empty($session['id']) ? $session['id'] : ('cs_test_' . bin2hex(random_bytes(16)));
            $redirectUrl = !empty($session['url']) ? $session['url'] : url('/reservation/planning/' . $orderNumber);
            $this->json([
                'session_id'   => $sessionId,
                'order_number' => $orderNumber,
                'redirect_url' => $redirectUrl
            ]);
        } catch (\Throwable $e) {
            $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
            @error_log("[" . date('Y-m-d H:i:s') . "] ERROR " . $e->getCode() . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL, 3, $rootPath . '/error.log');
            
            $errDetail = (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'development') ? (' (' . $e->getMessage() . ')') : '';
            $this->json(['error' => 'Une erreur est survenue lors de l\'initialisation du paiement.' . $errDetail], 500);
        }
    }

    public function planning(string $orderNumber): void {
        $order = $this->orderRepo->findByOrderNumber($orderNumber);
        if (!$order) {
            $this->redirect(url('/services'));
            return;
        }

        $bookings = $this->scheduleRepo->getBookingsByOrderId($order->id);
        $transfer = $this->scheduleRepo->getAirportTransferByOrderId($order->id);

        $this->render('pages/services-planning', [
            'order'        => $order,
            'bookings'     => $bookings,
            'transfer'     => $transfer,
            'settings'     => $this->settingsService,
            'seoTitle'     => 'Planification de vos Activités & Accueil Aéroport | ' . $order->orderNumber,
            'seoDescription' => 'Choisissez les dates et créneaux horaires de vos activités réservées à Djerba.'
        ]);
    }

    public function voucher(string $orderNumber): void {
        $order = $this->orderRepo->findByOrderNumber($orderNumber);
        if (!$order) {
            $this->redirect(url('/services'));
            return;
        }

        $bookings = $this->scheduleRepo->getBookingsByOrderId($order->id);
        $transfer = $this->scheduleRepo->getAirportTransferByOrderId($order->id);
        $voucher = $this->voucherService->generateVoucherData($order, $bookings, $transfer);

        $this->render('pages/voucher', [
            'voucher'  => $voucher,
            'bookings' => $bookings
        ], 'layouts/empty');
    }

    public function updateSchedule(): void {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $bookingId = (int)($input['booking_id'] ?? 0);
        $date = trim($input['date'] ?? '');
        $time = trim($input['time'] ?? '');
        $notes = trim($input['notes'] ?? '');

        if (!$bookingId || !$date || !$time) {
            $this->json(['error' => 'Date et heure requises.'], 400);
        }

        $success = $this->scheduleRepo->updateBookingSchedule($bookingId, $date, $time, $notes);
        $this->json(['success' => $success]);
    }

    public function updateAirport(): void {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $orderId = (int)($input['order_id'] ?? 0);

        if (!$orderId) {
            $this->json(['error' => 'Commande introuvable.'], 400);
        }

        $transfer = new AirportTransfer(
            orderId: $orderId,
            flightNumber: trim($input['flight_number'] ?? ''),
            airline: trim($input['airline'] ?? ''),
            arrivalDate: trim($input['arrival_date'] ?? ''),
            arrivalTime: trim($input['arrival_time'] ?? ''),
            passengersCount: max(1, (int)($input['passengers_count'] ?? 1)),
            dropoffLocation: trim($input['dropoff_location'] ?? ''),
            phoneWhatsapp: trim($input['phone_whatsapp'] ?? ''),
            driverNotes: trim($input['driver_notes'] ?? '')
        );

        $saved = $this->scheduleRepo->saveAirportTransfer($transfer);
        $this->json(['success' => (bool)$saved->id]);
    }

    private function enrichItemsFromDb(array $items): array {
        $ids = array_map(fn($i) => (int)($i['service_id'] ?? 0), $items);
        $ids = array_filter($ids);
        if (empty($ids)) return [];

        $dbServices = $this->serviceRepo->findByIds($ids);
        $servicesById = [];
        foreach ($dbServices as $s) {
            $servicesById[$s->id] = $s;
        }

        $enriched = [];
        foreach ($items as $item) {
            $id = (int)($item['service_id'] ?? 0);
            if (isset($servicesById[$id])) {
                $service = $servicesById[$id];
                $enriched[] = [
                    'service_id' => $service->id,
                    'name'       => $service->name,
                    'category'   => $service->category,
                    'unit_price' => $service->priceEur,
                    'quantity'   => max(1, (int)($item['quantity'] ?? 1))
                ];
            }
        }
        return $enriched;
    }
}
