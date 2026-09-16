<?php
namespace App\Controllers\Admin;

use Core\Controller;
use Core\Database;
use PDO;

class AuditAdminController extends Controller {
    public function index(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged'])) $this->redirect('/admin/login');

        $page   = max(1, (int)($_GET['page'] ?? 1));
        $limit  = 20;
        $offset = ($page - 1) * $limit;

        $pdo   = Database::getInstance();
        $total = (int)$pdo->query("SELECT COUNT(*) FROM audit_logs")->fetchColumn();

        $stmt = $pdo->prepare("SELECT * FROM audit_logs ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $logs = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        $this->render('admin/audit', [
            'logs'       => $logs,
            'total'      => $total,
            'page'       => $page,
            'limit'      => $limit,
            'totalPages' => $total > 0 ? (int)ceil($total / $limit) : 1
        ], 'layouts/admin');
    }
}