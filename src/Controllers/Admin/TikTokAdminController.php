<?php
namespace App\Controllers\Admin;

use Core\Controller;
use App\Services\TikTokPublisherService;
use App\Services\SettingsService;

class TikTokAdminController extends Controller {
    public function __construct(
        private TikTokPublisherService $tikTokService,
        private SettingsService $settings
    ) {}

    public function connect(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged'])) {
            $this->redirect('/admin/login');
            return;
        }

        $authUrl = $this->tikTokService->getAuthorizationUrl();
        header("Location: {$authUrl}");
        exit;
    }

    public function callback(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged'])) {
            $this->redirect('/admin/login');
            return;
        }

        $code  = $_GET['code'] ?? null;
        $error = $_GET['error'] ?? null;

        if ($error) {
            $errorDesc = $_GET['error_description'] ?? 'Autorisation refusée par TikTok';
            $this->render('admin/tiktok-status', [
                'success' => false,
                'message' => "Erreur TikTok : {$errorDesc}"
            ], 'layouts/admin');
            return;
        }

        if (!$code) {
            $this->render('admin/tiktok-status', [
                'success' => false,
                'message' => "Aucun code d'autorisation reçu."
            ], 'layouts/admin');
            return;
        }

        $tokenData = $this->tikTokService->exchangeCodeForToken($code);
        if ($tokenData && !empty($tokenData['access_token'])) {
            $this->render('admin/tiktok-status', [
                'success' => true,
                'message' => "Compte TikTok connecté avec succès ! Vos vidéos peuvent maintenant être publiées automatiquement.",
                'openId'  => $tokenData['open_id'] ?? null
            ], 'layouts/admin');
            return;
        }

        $this->render('admin/tiktok-status', [
            'success' => false,
            'message' => "Impossible d'obtenir le jeton d'accès TikTok. Veuillez vérifier votre Client Key et Client Secret."
        ], 'layouts/admin');
    }
}
