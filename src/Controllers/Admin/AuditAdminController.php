<?php
namespace App\Controllers\Admin;

use Core\Controller;
use Core\Database;

class AuditAdminController extends Controller {
    public function index(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged'])) $this->redirect('/admin/login');

        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT * FROM audit_logs ORDER BY created_at DESC LIMIT 50");
        $logs = $stmt->fetchAll();

        $this->render('admin/audit', [
            'logs' => $logs
        ], 'layouts/admin');
    }
}