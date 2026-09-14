<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Voucher Officiel Pass Séjour | <?= e($voucher['order_number']) ?></title>
  <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
  <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
  <style>
    @media print {
      .no-print { display: none !important; }
      body { background: #fff !important; }
    }
  </style>
</head>
<body style="background:#F8FAFC; padding:2rem 1rem;">

  <div class="l-container" style="max-width:760px; background:#fff; border-radius:20px; box-shadow:var(--shadow-soft); padding:2.5rem; border:1px solid #E2E8F0;">
    
    <!-- Top Bar with Logo & QR Code -->
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #F1F5F9; padding-bottom:1.5rem; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem;">
      <div>
        <div style="font-size:1.4rem; font-weight:800; font-family:var(--font-heading); color:var(--clr-dark-900);">
          DJERBA<span style="color:var(--clr-terracotta-500);">VOYAGE</span>
        </div>
        <div style="font-size:0.85rem; color:#64748B;">Bon d'Échange & Pass Séjour Officiel 2026</div>
        <div style="margin-top:0.5rem; font-size:1.1rem; font-weight:800; color:var(--clr-sea-900);">
          RÉF : <?= e($voucher['order_number']) ?>
        </div>
      </div>
      <div style="text-align:center;">
        <img src="<?= e($voucher['qr_code_url']) ?>" alt="QR Code Vérification" style="width:110px; height:110px; border-radius:8px; border:1px solid #E2E8F0;">
        <div style="font-size:0.7rem; color:#64748B; margin-top:2px;">Scan Partenaire</div>
      </div>
    </div>

    <!-- Client & Status Info -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:1rem; background:#F8FAFC; border-radius:12px; padding:1.25rem; margin-bottom:1.75rem;">
      <div>
        <span style="font-size:0.75rem; color:#64748B; text-transform:uppercase; font-weight:700;">Titulaire du Pass</span>
        <div style="font-weight:700; color:var(--clr-dark-900); font-size:0.95rem;"><?= e($voucher['client_email']) ?></div>
      </div>
      <div>
        <span style="font-size:0.75rem; color:#64748B; text-transform:uppercase; font-weight:700;">Statut du Règlement</span>
        <div style="font-weight:700; color:#10B981; font-size:0.95rem;"><i class="fi fi-rr-check"></i> Réglé (<?= number_format((float)$voucher['amount_paid'], 2) ?> €)</div>
      </div>
      <div>
        <span style="font-size:0.75rem; color:#64748B; text-transform:uppercase; font-weight:700;">Activités Incluses</span>
        <div style="font-weight:700; color:var(--clr-sea-900); font-size:0.95rem;"><?= $voucher['total_activities'] ?> service(s) réservé(s)</div>
      </div>
    </div>

    <!-- Airport Details if present -->
    <?php if ($voucher['airport_transfer']): ?>
      <div style="border:1px solid #BAE6FD; background:#F0F9FF; border-radius:12px; padding:1.25rem; margin-bottom:1.75rem;">
        <h3 style="font-size:1rem; color:#0369A1; margin-bottom:0.4rem; display:flex; align-items:center; gap:8px;">
          <i class="fi fi-rr-plane-arrival"></i> Accueil & Navette Privée Aéroport (DJE)
        </h3>
        <p style="font-size:0.85rem; color:#0C4A6E; line-height:1.5;">
          <strong>Vol :</strong> <?= e($voucher['airport_transfer']['flight'] ?: 'À communiquer') ?> (<?= e($voucher['airport_transfer']['airline'] ?: '') ?>) • 
          <strong>Arrivée :</strong> <?= e($voucher['airport_transfer']['date'] ?: '') ?> <?= e($voucher['airport_transfer']['time'] ? 'à ' . $voucher['airport_transfer']['time'] : '') ?><br>
          <strong>Lieu de dépose :</strong> <?= e($voucher['airport_transfer']['dropoff'] ?: 'Hôtel / Villa') ?>
        </p>
      </div>
    <?php endif; ?>

    <!-- Bookings Schedule List -->
    <h3 style="font-size:1.15rem; font-family:var(--font-heading); color:var(--clr-dark-900); margin-bottom:1rem;">
      Activités Réservées & Créneaux Confirmés
    </h3>
    <div style="display:flex; flex-direction:column; gap:0.75rem; margin-bottom:2rem;">
      <?php foreach ($bookings as $b): ?>
        <div style="display:flex; justify-content:space-between; align-items:center; padding:0.9rem; border:1px solid #E2E8F0; border-radius:10px;">
          <div>
            <strong style="color:var(--clr-dark-900); font-size:0.95rem;"><?= e($b->service ? $b->service->name : 'Activité') ?></strong>
            <div style="font-size:0.8rem; color:#64748B;">
              <?= $b->guestsCount ?> personne(s) • <?= e($b->service ? $b->service->locationLabel : 'Djerba') ?>
            </div>
          </div>
          <div style="text-align:right;">
            <?php if (!empty($b->scheduledDate)): ?>
              <span style="background:#DCFCE7; color:#15803D; padding:4px 10px; border-radius:20px; font-weight:700; font-size:0.8rem;">
                <?= e($b->scheduledDate) ?> à <?= e($b->scheduledTime) ?>
              </span>
            <?php else: ?>
              <span style="background:#FEF3C7; color:#92400E; padding:4px 10px; border-radius:20px; font-weight:700; font-size:0.8rem;">
                Date libre / À planifier
              </span>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Actions & Print -->
    <div class="no-print" style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid #E2E8F0; padding-top:1.5rem; flex-wrap:wrap; gap:1rem;">
      <a href="/reservation/planning/<?= urlencode($voucher['order_number']) ?>" class="c-button c-button--outline">
        <i class="fi fi-rr-arrow-left"></i> Retour au Planning
      </a>
      <button onclick="window.print()" class="c-button c-button--primary">
        <i class="fi fi-rr-print"></i> Imprimer / Enregistrer en PDF
      </button>
    </div>

  </div>

</body>
</html>
