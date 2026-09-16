<?php
namespace App\Controllers\Admin;

use Core\Controller;
use Core\Security;
use App\Interfaces\OrderRepositoryInterface;

class OrdersAdminController extends Controller {
    public function __construct(private OrderRepositoryInterface $orderRepo) {}

    private function requireAuth(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged'])) {
            $this->redirect('/admin/login');
        }
    }

    public function index(): void {
        $this->requireAuth();
        
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $limit  = 25;
        $search = trim(Security::sanitize($_GET['search'] ?? ''));
        $status = trim(Security::sanitize($_GET['status'] ?? ''));
        if (!in_array($status, ['paid', 'pending', 'cancelled', 'refunded'])) {
            $status = 'all';
        }
        
        $stats = $this->orderRepo->getStats();
        $ordersData = $this->orderRepo->getPaginated($page, $limit, $search, $status);
        
        $total = $ordersData['total'] ?? 0;
        $items = $ordersData['items'] ?? [];

        $flashSuccess = $_SESSION['admin_flash_success'] ?? null;
        $flashError   = $_SESSION['admin_flash_error'] ?? null;
        unset($_SESSION['admin_flash_success'], $_SESSION['admin_flash_error']);
        
        $this->render('admin/orders/index', [
            'orders'       => $items,
            'total'        => $total,
            'page'         => $page,
            'limit'        => $limit,
            'search'       => $search,
            'status'       => $status,
            'stats'        => $stats,
            'flashSuccess' => $flashSuccess,
            'flashError'   => $flashError,
            'totalPages'   => $total > 0 ? (int)ceil($total / $limit) : 1
        ], 'layouts/admin');
    }

    public function updateStatus(): void {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/orders');
        }

        $orderId = (int)($_POST['order_id'] ?? 0);
        $status  = trim(Security::sanitize($_POST['status'] ?? ''));
        $isAjax  = !empty($_POST['ajax']) || (!empty($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json'));

        $allowedStatuses = ['paid', 'pending', 'cancelled', 'refunded'];
        if (!in_array($status, $allowedStatuses)) {
            if ($isAjax) {
                $this->json(['success' => false, 'error' => 'Statut invalide.'], 400);
            }
            $_SESSION['admin_flash_error'] = "Statut invalide.";
            $this->redirect('/admin/orders');
        }

        $order = $this->orderRepo->findById($orderId);
        if (!$order) {
            if ($isAjax) {
                $this->json(['success' => false, 'error' => 'Commande introuvable.'], 404);
            }
            $_SESSION['admin_flash_error'] = "Commande introuvable.";
            $this->redirect('/admin/orders');
        }

        $success = $this->orderRepo->updateStatus($orderId, $status);

        if ($success) {
            $statusLabels = [
                'paid'      => 'Validée / Payée',
                'pending'   => 'En attente',
                'cancelled' => 'Annulée',
                'refunded'  => 'Remboursée'
            ];
            $label = $statusLabels[$status] ?? $status;
            
            if ($isAjax) {
                $this->json(['success' => true, 'order_id' => $orderId, 'status' => $status, 'status_label' => $label]);
            }
            $_SESSION['admin_flash_success'] = "Commande {$order->orderNumber} marquée comme {$label}.";
        } else {
            if ($isAjax) {
                $this->json(['success' => false, 'error' => 'Erreur lors de la mise à jour.'], 500);
            }
            $_SESSION['admin_flash_error'] = "Erreur lors de la mise à jour du statut.";
        }

        $referer = $_SERVER['HTTP_REFERER'] ?? url('/admin/orders');
        header("Location: {$referer}");
        exit;
    }

    public function details(): void {
        $this->requireAuth();

        $orderId = (int)($_GET['id'] ?? 0);
        if ($orderId <= 0) {
            $this->json(['error' => 'ID de commande invalide.'], 400);
        }

        $details = $this->orderRepo->getOrderDetails($orderId);
        if (!$details) {
            $this->json(['error' => 'Détails de la commande introuvables.'], 404);
        }

        $this->json($details);
    }
}
