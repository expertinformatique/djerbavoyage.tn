<?php
namespace App\Controllers;

use Core\Controller;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use App\Services\StripeService;
use App\Services\DownloadService;
use App\Services\FraudDetectionService;

use App\Services\SettingsService;

class CheckoutController extends Controller {
    public function __construct(
        private ProductRepositoryInterface $productRepo,
        private OrderRepositoryInterface $orderRepo,
        private StripeService $stripeService,
        private DownloadService $downloadService,
        private FraudDetectionService $fraudService,
        private ?SettingsService $settingsService = null
    ) {}

    public function createSession(): void {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $productId = (int)($input['product_id'] ?? 0);
            $email = filter_var($input['email'] ?? '', FILTER_VALIDATE_EMAIL);

            if (!$productId || !$email) {
                $this->json(['error' => 'Données de commande invalides.'], 400);
                return;
            }

            $product = $this->productRepo->findById($productId);
            if (!$product) {
                $this->json(['error' => 'Produit introuvable.'], 404);
                return;
            }

            $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
            if (!$this->fraudService->validateCheckoutPrice($product->id, $product->priceEur, $ip)) {
                $this->json(['error' => 'Erreur de validation du prix.'], 400);
                return;
            }

            $domain = rtrim(absolute_url(''), '/');
            $orderNumber = 'ORD-' . strtoupper(bin2hex(random_bytes(4)));

            // 1. Définir le success_url incluant order_number pour le rappel après le paiement
            $successUrl = $domain . '/checkout/success?session_id={CHECKOUT_SESSION_ID}&order_number=' . urlencode($orderNumber);

            // 2. Créer la session de paiement Stripe
            $session = $this->stripeService->createCheckoutSession([
                'title'        => $product->titleFr,
                'price_eur'    => $product->priceEur,
                'email'        => $email,
                'type'         => 'digital_product',
                'item_id'      => $product->id,
                'domain'       => $domain,
                'order_number' => $orderNumber,
                'success_url'  => $successUrl
            ]);

            // 3. Enregistrer la commande avec le stripe_session_id officiel
            $order = new Order(
                orderNumber: $orderNumber,
                customerEmail: $email,
                totalAmount: $product->priceEur,
                currency: 'EUR',
                stripeSessionId: $session['id'],
                status: 'paid', // Simulé en dev
                type: 'digital_product'
            );

            $createdOrder = $this->orderRepo->create($order);

            // 4. Générer le jeton de téléchargement associé à la commande
            $this->downloadService->generateToken($createdOrder->id, $product->id);

            // 5. Retourner l'URL de paiement Stripe intacte (non modifiée)
            $this->json([
                'session_id'   => $session['id'],
                'redirect_url' => $session['url']
            ]);
        } catch (\Throwable $e) {
            error_log("[" . date('Y-m-d H:i:s') . "] ERROR " . $e->getCode() . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL, 3, ROOT_PATH . '/error.log');
            $this->json(['error' => 'Une erreur est survenue lors de l\'initialisation du paiement.'], 500);
        }
    }

    public function success(): void {
        $sessionId = $_GET['session_id'] ?? '';
        $orderNumber = $_GET['order_number'] ?? '';
        $token = $_GET['token'] ?? '';

        if (!empty($orderNumber) && strpos($orderNumber, 'DJE-PASS-') === 0) {
            $this->redirect('/reservation/planning/' . urlencode($orderNumber));
            return;
        }

        // Récupérer le token de téléchargement actif si non fourni dans l'URL
        if (empty($token)) {
            $order = !empty($orderNumber) 
                ? $this->orderRepo->findByOrderNumber($orderNumber) 
                : (!empty($sessionId) ? $this->orderRepo->findByStripeSessionId($sessionId) : null);
            if ($order && $order->id) {
                $token = $this->downloadService->getActiveTokenForOrder($order->id) ?? '';
            }
        }

        $this->render('pages/success', [
            'sessionId' => $sessionId,
            'token'     => $token,
            'settings'  => $this->settingsService
        ]);
    }
}