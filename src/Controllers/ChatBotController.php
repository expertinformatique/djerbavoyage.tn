<?php
namespace App\Controllers;

use App\Interfaces\ChatConversationRepositoryInterface;
use App\Models\ChatConversation;
use App\Services\ChatKnowledgeService;
use App\Services\SmtpMailerService;
use App\Services\SpamProtectionService;
use Exception;

/**
 * Contrôleur du ChatBot IA — Djerba Voyage
 */
class ChatBotController
{
    public function __construct(
        private ChatConversationRepositoryInterface $repo,
        private ?ChatKnowledgeService $knowledge = null,
        private ?SmtpMailerService $mailer = null,
        private ?SpamProtectionService $spamService = null
    ) {
        $this->knowledge = $knowledge ?? new ChatKnowledgeService();
        $this->mailer = $mailer ?? new SmtpMailerService();
    }

    public function handleEndpoint(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        try {
            $rawInput = file_get_contents('php://input');
            $data = json_decode($rawInput, true);
            if (!is_array($data)) $data = $_POST;

            $remoteIp = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
            $lang = $data['lang'] ?? (\Core\Lang::getLocale() ?: 'fr');

            $response = $this->handle($data, $remoteIp, $lang);
            http_response_code($response['code'] ?? 200);
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            $this->logError("Chat Endpoint Error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Une erreur est survenue lors du traitement. Veuillez réessayer.'
            ]);
        }
    }

    public function handle(array $input, string $remoteIp, string $lang = 'fr'): array
    {
        $sessionId = trim($input['session_id'] ?? '') ?: ('sess_' . bin2hex(random_bytes(8)));
        $action = $input['action'] ?? 'message';
        $userMsg = trim($input['message'] ?? '');
        $history = is_array($input['history'] ?? null) ? $input['history'] : [];
        $ipHash = hash('sha256', $remoteIp);

        $conv = $this->repo->findBySessionId($sessionId) ?? new ChatConversation([
            'id' => 'CHAT-' . strtoupper(bin2hex(random_bytes(6))),
            'session_id' => $sessionId,
            'ip_hash' => $ipHash,
            'status' => 'active'
        ]);

        if (!empty($input['client_name'])) $conv->setClientName(strip_tags(trim($input['client_name'])));
        if (!empty($input['client_email'])) $conv->setClientEmail(filter_var(trim($input['client_email']), FILTER_SANITIZE_EMAIL));
        if (!empty($input['client_phone'])) $conv->setClientPhone(strip_tags(trim($input['client_phone'])));

        if ($action === 'save_contact') return $this->handleSaveContact($conv, $input, $history, $lang);
        if ($action === 'send_summary') return $this->handleSendSummary($conv, $history);
        if ($action === 'clear' || $action === 'delete') {
            $this->repo->deleteBySessionId($sessionId);
            return ['code' => 200, 'success' => true, 'action' => 'cleared'];
        }
        if ($action === 'archive') {
            $conv->setStatus('archived');
            $this->repo->save($conv);
            return ['code' => 200, 'success' => true, 'action' => 'archived'];
        }

        if ($userMsg === '') return ['code' => 400, 'success' => false, 'message' => 'Message requis.'];

        $this->extractContactInfo($userMsg, $conv);
        $history[] = ['role' => 'user', 'content' => $userMsg, 'time' => date('H:i')];

        $reply = $this->knowledge->generateReply($userMsg, $history, $lang);
        $history[] = [
            'role' => 'assistant',
            'content' => $reply['text'],
            'action' => $reply['action'] ?? null,
            'action_label' => $reply['action_label'] ?? null,
            'time' => date('H:i')
        ];

        $conv->setDetectedNeed($reply['detected_need'] ?? 'Information');
        $conv->setMessages($history);
        $conv->setSummary($this->knowledge->buildSummary($history, $conv->getDetectedNeed()));
        $this->repo->save($conv);

        return [
            'code' => 200,
            'success' => true,
            'session_id' => $sessionId,
            'conversation_id' => $conv->getId(),
            'reply' => $reply['text'],
            'action' => $reply['action'] ?? null,
            'action_label' => $reply['action_label'] ?? null,
            'detected_need' => $conv->getDetectedNeed(),
            'client_known' => !empty($conv->getClientEmail()),
        ];
    }

    private function handleSaveContact(ChatConversation $conv, array $input, array $history, string $lang): array
    {
        $name = strip_tags(trim($input['client_name'] ?? ''));
        $email = filter_var(trim($input['client_email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $phone = strip_tags(trim($input['client_phone'] ?? ''));

        if ($name) $conv->setClientName($name);
        if ($email) $conv->setClientEmail($email);
        if ($phone) $conv->setClientPhone($phone);

        $ack = match($lang) {
            'ar' => "شكراً لك " . ($name ?: '') . " ! تم تسجيل بياناتك بنجاح. سيقوم فريقنا بالتواصل معك لتأكيد تفاصيل رحلتك.",
            'en' => "Thank you " . ($name ?: '') . "! Your contact information has been recorded. Our travel desk will contact you shortly.",
            default => "Merci " . ($name ?: '') . " ! Vos coordonnées sont bien enregistrées. Notre équipe de réservation va vous contacter avec votre devis personnalisé."
        };

        $history[] = ['role' => 'assistant', 'content' => $ack, 'time' => date('H:i')];
        $conv->setMessages($history);
        $conv->setStatus('contact_provided');
        $conv->setSummary($this->knowledge->buildSummary($history, $conv->getDetectedNeed() ?: 'Demande qualifiée'));
        $this->repo->save($conv);

        $this->dispatchEmailNotification($conv);

        return ['code' => 200, 'success' => true, 'reply' => $ack, 'contact_saved' => true];
    }

    private function handleSendSummary(ChatConversation $conv, array $history): array
    {
        $conv->setMessages($history);
        $conv->setStatus('completed');
        $summary = $this->knowledge->buildSummary($history, $conv->getDetectedNeed() ?: 'Générale');
        $conv->setSummary($summary);
        $this->repo->save($conv);

        $sent = $this->dispatchEmailNotification($conv);
        return [
            'code' => 200,
            'success' => true,
            'email_sent' => $sent,
            'message' => 'Synthèse de l\'échange transmise à notre service réservation.'
        ];
    }

    private function extractContactInfo(string $msg, ChatConversation $conv): void
    {
        if (!$conv->getClientEmail() && preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/i', $msg, $m)) {
            $conv->setClientEmail(filter_var($m[0], FILTER_SANITIZE_EMAIL));
        }
        if (!$conv->getClientPhone() && preg_match('/(?:\+?\d{1,3}[\s.-]?)?\(?\d{2,4}\)?[\s.-]?\d{2,4}[\s.-]?\d{2,4}/', $msg, $m)) {
            if (strlen(preg_replace('/\D/', '', $m[0])) >= 8) {
                $conv->setClientPhone(strip_tags($m[0]));
            }
        }
    }

    private function dispatchEmailNotification(ChatConversation $conv): bool
    {
        $subject = "🤖 Nouveau contact Concierge IA : " . ($conv->getClientName() ?: 'Voyageur') . " (" . ($conv->getDetectedNeed() ?: 'Séjour') . ")";
        $body = "<h2>Synthèse d'échange Concierge IA Djerba Voyage</h2>";
        $body .= "<p><strong>Client :</strong> " . htmlspecialchars($conv->getClientName() ?? 'Non renseigné') . "</p>";
        $body .= "<p><strong>Email :</strong> " . htmlspecialchars($conv->getClientEmail() ?? 'Non renseigné') . "</p>";
        $body .= "<p><strong>Téléphone / WhatsApp :</strong> " . htmlspecialchars($conv->getClientPhone() ?? 'Non renseigné') . "</p>";
        $body .= "<p><strong>Besoin identifié :</strong> " . htmlspecialchars($conv->getDetectedNeed() ?? 'Non précisé') . "</p>";
        $body .= "<p><strong>Résumé :</strong> " . htmlspecialchars($conv->getSummary() ?? '') . "</p>";
        $body .= "<hr><h3>Historique des échanges :</h3><ul>";
        foreach ($conv->getMessages() as $m) {
            $role = ($m['role'] ?? '') === 'user' ? '👤 Voyageur' : '🤖 Concierge IA';
            $body .= "<li><strong>{$role} :</strong> " . htmlspecialchars($m['content'] ?? '') . "</li>";
        }
        $body .= "</ul>";

        return $this->mailer->send('reservation@djerbavoyage.tn', $subject, $body);
    }

    private function logError(string $msg): void
    {
        $root = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        @error_log('[' . date('Y-m-d H:i:s') . '] ' . $msg . PHP_EOL, 3, $root . '/error.log');
    }
}
