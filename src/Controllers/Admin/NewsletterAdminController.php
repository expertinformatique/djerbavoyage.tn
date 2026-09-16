<?php
namespace App\Controllers\Admin;

use Core\Controller;
use App\Interfaces\NewsletterRepositoryInterface;

class NewsletterAdminController extends Controller {
    public function __construct(
        private NewsletterRepositoryInterface $newsletterRepo
    ) {}

    public function index(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['admin_logged'])) {
            $this->redirect('/admin/login');
        }

        $page   = max(1, (int)($_GET['page'] ?? 1));
        $limit  = 20;
        $offset = ($page - 1) * $limit;

        $activeCount = $this->newsletterRepo->countActive();
        $total       = $this->newsletterRepo->countAll();
        $subscribers = $this->newsletterRepo->getAll($limit, $offset);

        $this->render('admin/newsletter', [
            'activeCount' => $activeCount,
            'subscribers' => $subscribers,
            'total'       => $total,
            'page'        => $page,
            'limit'       => $limit,
            'totalPages'  => $total > 0 ? (int)ceil($total / $limit) : 1
        ], 'layouts/admin');
    }
}
