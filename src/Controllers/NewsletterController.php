<?php
namespace App\Controllers;

use Core\Controller;
use App\Services\NewsletterService;
use App\Services\SettingsService;
use App\Services\AnalyticsService;
use Core\Security;

class NewsletterController extends Controller {
    public function __construct(
        private NewsletterService $newsletterService,
        private SettingsService $settings,
        private AnalyticsService $analytics
    ) {}

    public function index(): void {
        $this->analytics->trackPageView('/newsletter');
        $this->render('pages/newsletter', [
            'seoTitle'       => 'Club Privé & Newsletter Djerba | Bons Plans & Réductions',
            'seoDescription' => 'Rejoignez le Club Privé Djerba Voyage : réductions secrètes, guides inédits et conseils locaux.',
            'settings'       => $this->settings,
            'result'         => null
        ]);
    }

    public function subscribe(): void {
        $this->analytics->trackPageView('/api/newsletter/subscribe');

        $email = Security::sanitize($_POST['email'] ?? '');
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'] ?? 'djerbavoyage.tn';
        $baseUrl = $scheme . $host;

        $res = $this->newsletterService->subscribe($email, $ip, $baseUrl);

        $isJson = (strpos($_SERVER['REQUEST_URI'] ?? '', '/api/') !== false)
               || (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false);

        if ($isJson) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($res);
            return;
        }

        $this->render('pages/newsletter', [
            'seoTitle'       => 'Club Privé & Newsletter Djerba',
            'seoDescription' => 'Inscription à la newsletter officielle de Djerba Voyage.',
            'settings'       => $this->settings,
            'result'         => $res
        ]);
    }

    public function unsubscribe(string $token): void {
        $this->analytics->trackPageView('/newsletter/unsubscribe');
        $success = $this->newsletterService->unsubscribe($token);

        $this->render('pages/newsletter', [
            'seoTitle'       => 'Désinscription Newsletter | Djerba Voyage',
            'seoDescription' => 'Confirmation de désinscription de la newsletter.',
            'settings'       => $this->settings,
            'result'         => [
                'success' => $success,
                'status'  => $success ? 'unsubscribed' : 'invalid_token',
                'message' => $success
                    ? "Vous avez été désinscrit avec succès de notre newsletter. Vous pouvez vous réinscrire à tout moment."
                    : "Le lien de désinscription est invalide ou a déjà été utilisé."
            ]
        ]);
    }
}
