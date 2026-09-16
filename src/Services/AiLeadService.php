<?php
namespace App\Services;

use App\Interfaces\AiLeadRepositoryInterface;
use App\Models\AiLead;
use Throwable;

class AiLeadService {
    public const TARGET_EMAIL = 'reservation@djerbavoyage.tn';

    public function __construct(
        private AiLeadRepositoryInterface $repository,
        private SmtpMailerService $mailer,
        private ?SpamProtectionService $spamService = null
    ) {}

    public function processLead(array $data, ?string $ip = null): array {
        $name = trim($data['name'] ?? '');
        $email = strtolower(trim($data['email'] ?? ''));
        $phone = trim($data['phone'] ?? '');
        $travelDate = trim($data['travel_date'] ?? '');
        $notes = trim($data['notes'] ?? '');
        $preferences = is_array($data['preferences'] ?? null) ? $data['preferences'] : [];

        if ($this->spamService) {
            $content = $notes . ' ' . json_encode($preferences);
            $check = $this->spamService->validateSubmission($data, $ip ?? '', 'ai_lead', $content, $email, 4);
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

        $lead = new AiLead(
            id: null,
            name: $name,
            email: $email,
            phone: $phone ?: null,
            travelDate: $travelDate ?: null,
            notes: $notes ?: null,
            preferences: $preferences,
            ipAddress: $ip,
            status: 'new'
        );

        $leadId = $this->repository->create($lead);
        if (!$leadId) {
            return ['success' => false, 'message' => "Erreur lors de l'enregistrement. Veuillez réessayer."];
        }

        $lead->id = $leadId;

        // Envoi de l'e-mail de notification au service réservation
        $subject = "🌴 Nouveau Projet Séjour IA : {$name} (" . ($preferences['style'] ?? 'Sur-Mesure') . ")";
        $html = $this->buildNotificationHtml($lead);
        $this->mailer->send(self::TARGET_EMAIL, $subject, $html);

        return [
            'success' => true,
            'message' => "Votre projet de voyage a été transmis avec succès à notre équipe locale !",
            'leadId'  => $leadId
        ];
    }

    public function buildNotificationHtml(AiLead $lead): string {
        $p = $lead->preferences ?? [];
        $style = htmlspecialchars($p['style'] ?? 'Non spécifié');
        $dur = htmlspecialchars($p['duration'] ?? 'Non spécifié');
        $trav = htmlspecialchars($p['traveler'] ?? 'Non spécifié');
        $hotel = htmlspecialchars($p['hotel'] ?? 'Non spécifié');
        $itinerary = htmlspecialchars($p['itineraryTitle'] ?? $p['itinerary'] ?? 'Non spécifié');

        return '
        <!DOCTYPE html>
        <html>
        <head><meta charset="utf-8"></head>
        <body style="font-family: Arial, sans-serif; background:#0f172a; color:#ffffff; padding:20px; margin:0;">
            <div style="max-width:620px; margin:0 auto; background:#1e293b; border-radius:16px; border:1px solid rgba(245,158,11,0.4); padding:25px;">
                <h2 style="color:#F59E0B; margin:0 0 15px; font-size:22px;">🌴 Nouveau Projet de Séjour généré par l\'IA</h2>
                <p style="color:#94a3b8; font-size:14px; margin-bottom:20px;">Un voyageur vient de configurer son séjour idéal sur Djerba Voyage :</p>

                <div style="background:rgba(255,255,255,0.05); border-radius:10px; padding:15px; margin-bottom:18px;">
                    <h3 style="color:#FCD34D; margin:0 0 10px; font-size:16px;">👤 Coordonnées du Client</h3>
                    <p style="margin:4px 0; font-size:14px;"><strong>Nom :</strong> ' . htmlspecialchars($lead->name) . '</p>
                    <p style="margin:4px 0; font-size:14px;"><strong>E-mail :</strong> <a href="mailto:' . htmlspecialchars($lead->email) . '" style="color:#38bdf8;">' . htmlspecialchars($lead->email) . '</a></p>
                    <p style="margin:4px 0; font-size:14px;"><strong>Téléphone / WhatsApp :</strong> ' . htmlspecialchars($lead->phone ?? 'Non renseigné') . '</p>
                    <p style="margin:4px 0; font-size:14px;"><strong>Date de Voyage Prévue :</strong> ' . htmlspecialchars($lead->travelDate ?? 'Non renseignée') . '</p>
                    ' . (!empty($lead->notes) ? '<p style="margin:6px 0 0; font-size:13px; color:#cbd5e1;"><strong>Notes :</strong> ' . nl2br(htmlspecialchars($lead->notes)) . '</p>' : '') . '
                </div>

                <div style="background:rgba(245,158,11,0.08); border:1px dashed #F59E0B; border-radius:10px; padding:15px;">
                    <h3 style="color:#FCD34D; margin:0 0 10px; font-size:16px;">✨ Profil & Recommandation IA</h3>
                    <p style="margin:4px 0; font-size:14px;"><strong>Type :</strong> ' . $trav . ' • <strong>Style :</strong> ' . $style . '</p>
                    <p style="margin:4px 0; font-size:14px;"><strong>Durée :</strong> ' . $dur . ' • <strong>Hébergement :</strong> ' . $hotel . '</p>
                    <p style="margin:6px 0 0; font-size:14px;"><strong>Itinéraire Conseillé :</strong> ' . $itinerary . '</p>
                </div>

                <p style="font-size:11px; color:#64748b; margin-top:20px; text-align:center;">
                    Djerba Voyage Back-Office • IP : ' . htmlspecialchars($lead->ipAddress ?? '-') . '
                </p>
            </div>
        </body>
        </html>';
    }
}
