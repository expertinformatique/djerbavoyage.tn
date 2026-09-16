<?php
namespace App\Services;

class PersonalizedPdfService {
    public function generateCoverPdf(string $name, string $message, string $dates, string $photoUrl = ''): string {
        $cleanName = htmlspecialchars(trim($name) ?: 'Voyageur Djerba');
        $cleanMessage = htmlspecialchars(trim($message) ?: 'Un séjour inoubliable sur l\'île des rêves.');
        $cleanDates = htmlspecialchars(trim($dates) ?: date('F Y'));

        // Génération d'un document HTML haute fidélité prêt à l'impression / export PDF
        return '<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Guide Djerba de ' . $cleanName . '</title>
<style>
  @page { size: A4 portrait; margin: 0; }
  body { margin: 0; padding: 0; font-family: "Helvetica Neue", Arial, sans-serif; background: #0F172A; color: #FFFFFF; }
  .cover { width: 210mm; height: 297mm; box-sizing: border-box; padding: 25mm 20mm; display: flex; flex-direction: column; justify-content: space-between; text-align: center; position: relative; background: linear-gradient(145deg, #0F172A 0%, #1E293B 100%); }
  .badge { display: inline-block; background: rgba(245,158,11,0.2); border: 1px solid #F59E0B; color: #FCD34D; padding: 6px 18px; border-radius: 30px; font-size: 13px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; }
  .photo-box { width: 100%; height: 95mm; border-radius: 12px; overflow: hidden; border: 2px solid rgba(245,158,11,0.5); box-shadow: 0 10px 30px rgba(0,0,0,0.5); margin-bottom: 20px; }
  .photo-box img { width: 100%; height: 100%; object-fit: cover; }
  .title { font-size: 32px; font-weight: 800; color: #FFFFFF; margin: 0 0 10px; line-height: 1.2; letter-spacing: -0.5px; }
  .dates { font-size: 16px; color: #F59E0B; font-weight: 600; margin-bottom: 20px; }
  .message-box { background: rgba(255,255,255,0.06); border-left: 4px solid #F59E0B; border-radius: 8px; padding: 16px 20px; margin: 15px auto; max-width: 85%; text-align: left; font-style: italic; font-size: 15px; line-height: 1.6; color: #E2E8F0; }
  .footer { border-top: 1px solid rgba(255,255,255,0.15); padding-top: 15px; font-size: 11px; color: #94A3B8; text-transform: uppercase; letter-spacing: 1px; }
  @media print { body { -webkit-print-color-adjust: exact; print-color-adjust: exact; } .no-print { display: none !important; } }
  .print-bar { position: fixed; top: 10px; right: 10px; background: #E07A5F; color: #fff; padding: 10px 20px; border-radius: 8px; font-weight: bold; cursor: pointer; z-index: 1000; border: none; }
</style>
</head>
<body>
<button class="print-bar no-print" onclick="window.print()">📥 Imprimer / Enregistrer en PDF</button>
<div class="cover">
  <div>
    <div class="badge">✨ Édition Privée & Souvenir Personnalisé</div>
    <div class="photo-box">
      <img src="' . htmlspecialchars($photoUrl ?: '/images/pdf_custom.png') . '" alt="Photo Couverture">
    </div>
    <h1 class="title">Guide Djerba de ' . $cleanName . '</h1>
    <div class="dates">Séjour : ' . $cleanDates . '</div>
    <div class="message-box">
      « ' . nl2br($cleanMessage) . ' »
    </div>
  </div>
  <div class="footer">
    Djerba Voyage 2026 • Guide Officiel Personnalisé • www.djerbavoyage.tn
  </div>
</div>
</body>
</html>';
    }
}
