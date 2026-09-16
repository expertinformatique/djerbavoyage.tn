<?php
namespace App\Controllers;

use Core\Controller;
use Core\Security;
use App\Services\PersonalizedPdfService;
use App\Services\SmtpMailerService;
use Core\Database;

class PersonalizedPdfController extends Controller {
    public function __construct(
        private PersonalizedPdfService $pdfService,
        private SmtpMailerService $mailer,
        private ?\App\Services\SpamProtectionService $spamService = null
    ) {}

    public function preview(): void {
        $name = Security::sanitize($_GET['name'] ?? $_POST['name'] ?? 'Marie & Julien');
        $message = Security::sanitize($_GET['message'] ?? $_POST['message'] ?? 'Pour notre magnifique séjour à Djerba...');
        $dates = Security::sanitize($_GET['dates'] ?? $_POST['dates'] ?? 'Octobre 2026');
        $photo = Security::sanitize($_GET['photo'] ?? $_POST['photo'] ?? '/images/pdf_custom.png');

        header('Content-Type: text/html; charset=utf-8');
        echo $this->pdfService->generateCoverPdf($name, $message, $dates, $photo);
    }

    public function submitOrder(): void {
        header('Content-Type: application/json; charset=utf-8');

        $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;

        $name = Security::sanitize($input['name'] ?? '');
        $email = Security::sanitize($input['email'] ?? '');
        $message = Security::sanitize($input['message'] ?? '');
        $dates = Security::sanitize($input['dates'] ?? '');
        $photo = Security::sanitize($input['photo'] ?? '');
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';

        if ($this->spamService) {
            $content = $message . ' ' . $name;
            $check = $this->spamService->validateSubmission($input, $ip, 'pdf_order', $content, $email, 4);
            if ($check['is_spam']) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => $check['message']]);
                return;
            }
        }

        if (empty($name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Nom et e-mail valide requis.']);
            return;
        }

        // Notification envoyée à l'équipe réservation
        $subject = "✨ Commande Guide PDF Personnalisé : {$name}";
        $html = "
        <h2>Nouvelle commande de Guide Personnalisé</h2>
        <p><strong>Nom sur la couverture :</strong> {$name}</p>
        <p><strong>E-mail client :</strong> {$email}</p>
        <p><strong>Dates :</strong> {$dates}</p>
        <p><strong>Message / Dédicace :</strong> " . nl2br($message) . "</p>
        <p><strong>Photo sélectionnée :</strong> {$photo}</p>
        ";
        $this->mailer->send('reservation@djerbavoyage.tn', $subject, $html);

        echo json_encode([
            'success'      => true,
            'message'      => 'Votre guide personnalisé a été configuré avec succès !',
            'preview_url'  => '/pdf/preview?name=' . urlencode($name) . '&message=' . urlencode($message) . '&dates=' . urlencode($dates) . '&photo=' . urlencode($photo)
        ]);
    }
}
