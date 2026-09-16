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

        $activeCount = $this->newsletterRepo->countActive();
        $subscribers = $this->newsletterRepo->getAll(100);

        $this->render('admin/newsletter', [
            'activeCount' => $activeCount,
            'subscribers' => $subscribers
        ], 'layouts/admin');
    }
}
