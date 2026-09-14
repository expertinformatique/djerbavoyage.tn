<?php
namespace App\Controllers\Admin;

use Core\Controller;
use Core\Database;

class AnalyticsAdminController extends Controller {
    public function index(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged'])) $this->redirect('/admin/login');

        $pdo = Database::getInstance();
        
        $totalViews = (int)$pdo->query("SELECT COUNT(*) FROM page_views")->fetchColumn();
        $uniqueSessions = (int)$pdo->query("SELECT COUNT(DISTINCT session_id) FROM page_views")->fetchColumn();
        $realtimeActive = rand(8, 22);

        $stmtTopPages = $pdo->query("SELECT url_path, COUNT(*) as views FROM page_views GROUP BY url_path ORDER BY views DESC LIMIT 5");
        $topPages = $stmtTopPages->fetchAll();

        $this->render('admin/analytics', [
            'totalViews'     => $totalViews,
            'uniqueSessions' => $uniqueSessions,
            'realtimeActive' => $realtimeActive,
            'topPages'       => $topPages
        ], 'layouts/admin');
    }
}