<?php
namespace App\Services;

use App\Interfaces\ContactRepositoryInterface;
use App\Models\ContactMessage;

class ContactService {
    public const TARGET_EMAIL = 'reservation@djerbavoyage.tn';

    public function __construct(
        private ContactRepositoryInterface $repository,
        private SmtpMailerService $mailer,
        private ?SpamProtectionService $spamService = null
    ) {}

    public function handleContact(array $data, ?string $ip = null): array {
        $name = trim($data['name'] ?? '');
        $email = strtolower(trim($data['email'] ?? ''));
        $phone = trim($data['phone'] ?? '');
        $subject = trim($data['subject'] ?? 'Demande de contact');
        $message = trim($data['message'] ?? '');

        if ($this->spamService) {
            $content = $subject . ' ' . $message;
            $check = $this->spamService->validateSubmission($data, $ip ?? '', 'contact', $content, $email, 5);
            if ($check['is_spam']) {
                return ['success' => false, 'message' => $check['message']];
            }
        }

        if (empty($name)) {
            return ['success' => false, 'message' => 'Veuillez renseigner votre nom.'];
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Veuillez renseigner une adresse e-mail valide.'];
        }

        if (empty($message) || strlen($message) < 5) {
            return ['success' => false, 'message' => 'Veuillez écrire un message d\'au moins 5 caractères.'];
        }

        $msg = new ContactMessage(
            id: null,
            name: $name,
            email: $email,
            phone: $phone ?: null,
            subject: $subject ?: null,
            message: $message,
            ipAddress: $ip,
            status: 'new'
        );

        $id = $this->repository->create($msg);
        if (!$id) {
            return ['success' => false, 'message' => "Une erreur est survenue lors de l'envoi. Veuillez réessayer."];
        }

        $msg->id = $id;

        // Envoi de l'e-mail de notification
        $mailSubject = "📩 Nouveau Message Contact : {$name} — " . ($subject ?: 'Djerba Voyage');
        $html = $this->buildNotificationHtml($msg);
        $this->mailer->send(self::TARGET_EMAIL, $mailSubject, $html);

        return [
            'success' => true,
            'message' => "Merci " . htmlspecialchars($name) . " ! Votre message a bien été envoyé. Notre équipe locale vous répondra sous 24 heures.",
            'id'      => $id
        ];
    }

    public function buildNotificationHtml(ContactMessage $msg): string {
        return '
        <!DOCTYPE html>
        <html>
        <head><meta charset="utf-8"></head>
        <body style="font-family: Arial, sans-serif; background:#0f172a; color:#ffffff; padding:20px; margin:0;">
            <div style="max-width:600px; margin:0 auto; background:#1e293b; border-radius:16px; border:1px solid rgba(224,122,95,0.4); padding:25px;">
                <h2 style="color:#E07A5F; margin:0 0 15px; font-size:20px;">📩 Nouveau Message de Contact</h2>
                <div style="background:rgba(255,255,255,0.05); border-radius:10px; padding:15px; margin-bottom:15px;">
                    <p style="margin:4px 0; font-size:14px;"><strong>Nom :</strong> ' . htmlspecialchars($msg->name) . '</p>
                    <p style="margin:4px 0; font-size:14px;"><strong>E-mail :</strong> <a href="mailto:' . htmlspecialchars($msg->email) . '" style="color:#38bdf8;">' . htmlspecialchars($msg->email) . '</a></p>
                    <p style="margin:4px 0; font-size:14px;"><strong>Téléphone :</strong> ' . htmlspecialchars($msg->phone ?? 'Non renseigné') . '</p>
                    <p style="margin:4px 0; font-size:14px;"><strong>Sujet :</strong> ' . htmlspecialchars($msg->subject ?? 'Général') . '</p>
                </div>
                <div style="background:rgba(255,255,255,0.08); border-radius:10px; padding:15px; font-size:14px; line-height:1.6; color:#f1f5f9;">
                    <strong>Message :</strong><br>
                    ' . nl2br(htmlspecialchars($msg->message)) . '
                </div>
                <p style="font-size:11px; color:#64748b; margin-top:20px; text-align:center;">
                    Djerba Voyage Back-Office • IP : ' . htmlspecialchars($msg->ipAddress ?? '-') . '
                </p>
            </div>
        </body>
        </html>';
    }
}
