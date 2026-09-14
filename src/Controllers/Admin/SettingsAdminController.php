<?php
namespace App\Controllers\Admin;

use Core\Controller;
use App\Services\SettingsService;
use Core\Security;

class SettingsAdminController extends Controller {
    public function __construct(private SettingsService $settings) {}

    public function index(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged'])) $this->redirect('/admin/login');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST as $key => $val) {
                if ($key !== 'csrf_token') {
                    $this->settings->set($key, Security::sanitize($val));
                }
            }
            $success = "Paramètres mis à jour avec succès !";
        }

        $this->render('admin/settings', [
            'settings' => $this->settings,
            'success'  => $success ?? null
        ], 'layouts/admin');
    }
}