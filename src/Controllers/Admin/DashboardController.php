<?php
namespace App\Controllers\Admin;

use Core\Controller;
use App\Interfaces\OrderRepositoryInterface;
use App\Services\SettingsService;
use Core\Database;

class DashboardController extends Controller {
    public function __construct(
        private OrderRepositoryInterface $orderRepo,
        private SettingsService $settings
    ) {}

    public function index(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged'])) {
            $this->redirect('/admin/login');
        }

        $pdo = Database::getInstance();
        $paidCount = $this->orderRepo->getPaidOrdersCount();

        $stmtRevenue = $pdo->query("SELECT SUM(total_amount) FROM orders WHERE status = 'paid'");
        $totalRevenue = (float)$stmtRevenue->fetchColumn();

        $stmtConcierge = $pdo->query("SELECT COUNT(*) FROM concierge_tickets WHERE status = 'new'");
        $pendingConcierge = (int)$stmtConcierge->fetchColumn();

        $stmtAiLeads = $pdo->query("SELECT COUNT(*) FROM ai_leads WHERE status = 'new'");
        $pendingAiLeads = (int)$stmtAiLeads->fetchColumn();

        $orders = $this->orderRepo->getPaginated(1, 5)['items'];

        $this->render('admin/dashboard', [
            'paidCount'        => $paidCount,
            'totalRevenue'     => $totalRevenue,
            'pendingConcierge' => $pendingConcierge,
            'pendingAiLeads'   => $pendingAiLeads,
            'recentOrders'     => $orders,
            'settings'         => $this->settings
        ], 'layouts/admin');
    }
}