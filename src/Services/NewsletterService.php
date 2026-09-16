<?php
namespace App\Services;

use App\Interfaces\NewsletterRepositoryInterface;
use Throwable;

class NewsletterService {
    public function __construct(
        private NewsletterRepositoryInterface $repository,
        private SmtpMailerService $mailer,
        private ?SpamProtectionService $spamService = null
    ) {}

    public function subscribe(string $email, ?string $ip = null, string $baseUrl = 'https://djerbavoyage.tn', array $extra = []): array {
        $cleanEmail = strtolower(trim($email));

        if (!filter_var($cleanEmail, FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'status'  => 'invalid_email',
                'message' => "L'adresse e-mail renseignée n'est pas valide."
            ];
        }

        if ($this->spamService) {
            $check = $this->spamService->validateSubmission($extra, $ip ?? '', 'newsletter', '', $cleanEmail, 3);
            if ($check['is_spam']) {
                return [
                    'success' => false,
                    'status'  => 'spam_blocked',
                    'message' => $check['message']
                ];
            }
        }

        $token = bin2hex(random_bytes(24));
        $status = $this->repository->subscribe($cleanEmail, $token, $ip);

        if ($status === 'already_active') {
            return [
                'success' => true,
                'status'  => 'already_active',
                'message' => "Vous êtes déjà inscrit à la newsletter Djerba Voyage !"
            ];
        }

        if ($status === 'error') {
            return [
                'success' => false,
                'status'  => 'error',
                'message' => "Une erreur est survenue lors de l'enregistrement. Veuillez réessayer."
            ];
        }

        // Envoi de l'email de bienvenue
        $unsubUrl = rtrim($baseUrl, '/') . "/newsletter/unsubscribe/" . $token;
        $html = $this->buildWelcomeEmailHtml($cleanEmail, $unsubUrl);
        $subject = "✨ Bienvenue au Club Privé Djerba Voyage — Votre Avantage Exclusif";

        $this->mailer->send($cleanEmail, $subject, $html);

        $msg = $status === 'reactivated'
            ? "Ravi de vous revoir ! Votre abonnement a été réactivé avec succès."
            : "Félicitations ! Vous êtes inscrit à la newsletter. Un e-mail de bienvenue vous a été envoyé.";

        return [
            'success' => true,
            'status'  => $status,
            'message' => $msg
        ];
    }

    public function unsubscribe(string $token): bool {
        if (empty($token) || strlen($token) < 16) {
            return false;
        }
        return $this->repository->unsubscribe($token);
    }

    private function buildWelcomeEmailHtml(string $email, string $unsubUrl): string {
        return '
        <!DOCTYPE html>
        <html>
        <head><meta charset="utf-8"></head>
        <body style="font-family: Arial, sans-serif; background:#0f172a; color:#ffffff; padding:20px; margin:0;">
            <div style="max-width:600px; margin:0 auto; background:#1e293b; border-radius:16px; border:1px solid rgba(245,158,11,0.3); padding:30px; text-align:center;">
                <h1 style="color:#F59E0B; margin-bottom:10px; font-size:24px;">🌴 Club Privé Djerba Voyage</h1>
                <p style="color:#e2e8f0; font-size:15px; line-height:1.6;">
                    Merci d\'avoir rejoint notre communauté de voyageurs passionnés !
                </p>
                <div style="background:rgba(245,158,11,0.15); border:1px dashed #F59E0B; border-radius:12px; padding:15px; margin:20px 0;">
                    <p style="margin:0; font-size:14px; color:#FCD34D;">🎁 Votre Code Privilège Exclusif :</p>
                    <p style="margin:8px 0 0 0; font-size:22px; font-weight:bold; color:#ffffff; letter-spacing:2px;">CLUB-DJERBA-10</p>
                    <p style="margin:5px 0 0 0; font-size:12px; color:#cbd5e1;">-10% sur toutes nos activités nautiques, quads et excursions désert.</p>
                </div>
                <p style="color:#94a3b8; font-size:13px; line-height:1.5;">
                    Vous recevrez chaque mois nos pépites secrètes, adresses insolites et guides PDF de Djerba en avant-première.
                </p>
                <hr style="border:none; border-top:1px solid rgba(255,255,255,0.1); margin:25px 0;">
                <p style="font-size:11px; color:#64748b; margin:0;">
                    Djerba Voyage • <a href="' . htmlspecialchars($unsubUrl) . '" style="color:#38bdf8; text-decoration:underline;">Se désinscrire en 1 clic</a>
                </p>
            </div>
        </body>
        </html>';
    }
}
