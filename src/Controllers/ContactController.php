<?php
namespace App\Controllers;

use Core\Controller;
use Core\Security;
use App\Services\ContactService;
use App\Services\SettingsService;
use App\Services\AnalyticsService;

class ContactController extends Controller {
    public function __construct(
        private ContactService $contactService,
        private SettingsService $settings,
        private AnalyticsService $analytics
    ) {}

    public function index(): void {
        $this->analytics->trackPageView('/contact');
        $this->render('pages/contact', [
            'seoTitle'       => 'Contactez l\'Équipe Djerba Voyage | Conciergerie & Guides',
            'seoDescription' => 'Une question sur votre séjour, nos guides PDF ou nos excursions à Djerba ? Contactez directement notre équipe locale.',
            'settings'       => $this->settings,
            'result'         => null
        ]);
    }

    public function submit(): void {
        $this->analytics->trackPageView('/contact/submit');

        $isJson = (strpos($_SERVER['REQUEST_URI'] ?? '', '/api/') !== false)
               || (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false);

        $input = $isJson ? json_decode(file_get_contents('php://input'), true) : $_POST;
        if (!is_array($input)) {
            $input = $_POST;
        }

        $data = [
            'name'    => Security::sanitize($input['name'] ?? ''),
            'email'   => Security::sanitize($input['email'] ?? ''),
            'phone'   => Security::sanitize($input['phone'] ?? ''),
            'subject' => Security::sanitize($input['subject'] ?? ''),
            'message' => Security::sanitize($input['message'] ?? '')
        ];

        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $result = $this->contactService->handleContact($data, $ip);

        if ($isJson) {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code($result['success'] ? 200 : 400);
            echo json_encode($result);
            return;
        }

        $this->render('pages/contact', [
            'seoTitle'       => 'Contactez l\'Équipe Djerba Voyage',
            'seoDescription' => 'Confirmation d\'envoi de votre message.',
            'settings'       => $this->settings,
            'result'         => $result
        ]);
    }
}
