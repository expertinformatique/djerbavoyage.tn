<?php
namespace App\Controllers\Admin;

use Core\Controller;
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
        
        $page = (int)($_GET['page'] ?? 1);
        if ($page < 1) $page = 1;
        $limit = 50;
        
        $search = trim($_GET['search'] ?? '');
        
        $ordersData = $this->orderRepo->getPaginated($page, $limit, $search);
        
        $total = $ordersData['total'] ?? 0;
        $items = $ordersData['items'] ?? $ordersData['orders'] ?? [];
        
        $this->render('admin/orders/index', [
            'orders'      => $items,
            'total'       => $total,
            'page'        => $page,
            'limit'       => $limit,
            'search'      => $search,
            'totalPages'  => $total > 0 ? (int)ceil($total / $limit) : 1
        ], 'layouts/admin');
    }
}
