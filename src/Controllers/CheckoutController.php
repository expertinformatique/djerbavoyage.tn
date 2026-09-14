<?php
namespace App\Controllers;

use Core\Controller;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use App\Services\StripeService;
use App\Services\DownloadService;
use App\Services\FraudDetectionService;

class CheckoutController extends Controller {
    public function __construct(
        private ProductRepositoryInterface $productRepo,
        private OrderRepositoryInterface $orderRepo,
        private StripeService $stripeService,
        private DownloadService $downloadService,
        private FraudDetectionService $fraudService
    ) {}

    public function createSession(): void {
        $input = json_decode(file_get_contents('php://input'), true);
        $productId = (int)($input['product_id'] ?? 0);
        $email = filter_var($input['email'] ?? '', FILTER_VALIDATE_EMAIL);

        if (!$productId || !$email) {
            $this->json(['error' => 'Données de commande invalides.'], 400);
        }

        $product = $this->productRepo->findById($productId);
        if (!$product) {
            $this->json(['error' => 'Produit introuvable.'], 404);
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        if (!$this->fraudService->validateCheckoutPrice($product->id, $product->priceEur, $ip)) {
            $this->json(['error' => 'Erreur de validation du prix.'], 400);
        }

        $domain = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost');

        $session = $this->stripeService->createCheckoutSession([
            'title'     => $product->titleFr,
            'price_eur' => $product->priceEur,
            'email'     => $email,
            'type'      => 'digital_product',
            'item_id'   => $product->id,
            'domain'    => $domain
        ]);

        $order = new Order(
            orderNumber: 'ORD-' . strtoupper(bin2hex(random_bytes(4))),
            customerEmail: $email,
            totalAmount: $product->priceEur,
            currency: 'EUR',
            stripeSessionId: $session['id'],
            status: 'paid', // Simulé en dev
            type: 'digital_product'
        );

        $createdOrder = $this->orderRepo->create($order);
        $downloadToken = $this->downloadService->generateToken($createdOrder->id, $product->id);

        $this->json([
            'session_id'    => $session['id'],
            'redirect_url'  => $session['url'] . '&token=' . $downloadToken
        ]);
    }

    public function success(): void {
        $sessionId = $_GET['session_id'] ?? '';
        $token = $_GET['token'] ?? '';

        $this->render('pages/success', [
            'sessionId' => $sessionId,
            'token'     => $token
        ]);
    }
}