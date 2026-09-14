<h1 style="font-family:var(--font-heading); margin-bottom:1.5rem;">Configuration Dynamique du Site (settings)</h1>

<?php if (!empty($success)): ?>
  <div style="background:#e6fffa; color:#234e52; padding:1rem; border-radius:8px; margin-bottom:1.5rem; border:1px solid #b2f5ea;">
    <?= e($success) ?>
  </div>
<?php endif; ?>

<div style="background:#fff; padding:2rem; border-radius:12px; box-shadow:var(--shadow-soft);">
  <form method="POST" action="/admin/settings">
    <h3 style="margin-bottom:1rem; font-family:var(--font-heading);">Paramètres Généraux</h3>
    <div style="margin-bottom:1rem;">
      <label style="display:block; font-weight:600; margin-bottom:0.4rem;">Nom du Site</label>
      <input type="text" name="site_name" value="<?= e($settings->get('site_name')) ?>" style="width:100%; padding:0.7rem; border:1px solid #ccc; border-radius:8px;">
    </div>
    <div style="margin-bottom:1rem;">
      <label style="display:block; font-weight:600; margin-bottom:0.4rem;">E-mail de Contact</label>
      <input type="email" name="contact_email" value="<?= e($settings->get('contact_email')) ?>" style="width:100%; padding:0.7rem; border:1px solid #ccc; border-radius:8px;">
    </div>

    <h3 style="margin:2rem 0 1rem 0; font-family:var(--font-heading);">Tarification & Affiliation</h3>
    <div style="margin-bottom:1rem;">
      <label style="display:block; font-weight:600; margin-bottom:0.4rem;">Prix Conciergerie (EUR)</label>
      <input type="text" name="concierge_price" value="<?= e($settings->get('concierge_price')) ?>" style="width:100%; padding:0.7rem; border:1px solid #ccc; border-radius:8px;">
    </div>
    <div style="margin-bottom:1rem;">
      <label style="display:block; font-weight:600; margin-bottom:0.4rem;">ID Partenaire Booking.com</label>
      <input type="text" name="booking_partner_id" value="<?= e($settings->get('booking_partner_id')) ?>" style="width:100%; padding:0.7rem; border:1px solid #ccc; border-radius:8px;">
    </div>

    <button type="submit" class="c-button c-button--primary" style="margin-top:1rem;">
      Enregistrer les Paramètres <i class="fi fi-rr-disk"></i>
    </button>
  </form>
</div>