<!-- Modal Guide PDF Personnalisé avec Nom & Photo -->
<div class="c-modal" id="personalizedPdfModal">
  <div class="c-modal__card" style="max-width: 680px; padding: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
      <span class="badge badge--gold" style="background: rgba(212,175,55,0.15); color: #F59E0B; padding: 4px 12px; border-radius: 20px; font-weight: 700; font-size: 0.8rem;">
        ✨ Édition Unique & Souvenir
      </span>
      <button type="button" data-close-modal="personalizedPdfModal" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--clr-gray-500);">&times;</button>
    </div>

    <h2 class="heading-2" style="margin-bottom: 0.5rem; font-size: 1.5rem;">Créez votre Guide PDF avec Nom & Photo</h2>
    <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 1.5rem;">Recevez un guide de voyage complet personnalisé avec le nom de votre famille/couple, vos dates et la photo de votre choix sur la première page !</p>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; align-items: center;">
      
      <!-- Live Preview 3D Book Cover -->
      <div style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); border-radius: 16px; padding: 1.5rem; color: #fff; text-align: center; position: relative; border: 2px solid var(--clr-terracotta-500); box-shadow: 0 15px 30px rgba(0,0,0,0.3);">
        <div style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; color: var(--clr-terracotta-500); font-weight: 700; margin-bottom: 0.5rem;">Aperçu de la Couverture</div>
        
        <div id="previewCoverImgBox" style="height: 140px; border-radius: 8px; overflow: hidden; margin-bottom: 1rem; position: relative;">
          <img id="previewCoverImg" src="<?= asset('images/pdf_custom.png') ?>" alt="Photo de couverture" style="width: 100%; height: 100%; object-fit: cover;">
        </div>

        <h3 id="previewTitle" style="font-size: 1.1rem; font-weight: 800; color: #fff; margin-bottom: 4px; line-height: 1.2;">
          Guide Djerba de Marie & Julien
        </h3>
        <p id="previewDates" style="font-size: 0.8rem; color: var(--clr-sand-500); font-style: italic;">
          Séjour du 15 au 22 Octobre 2026
        </p>

        <div style="margin-top: 1rem; font-size: 0.65rem; color: rgba(255,255,255,0.5); text-transform: uppercase; border-top: 1px dashed rgba(255,255,255,0.2); padding-top: 0.5rem;">
          Édition Spéciale Djerba Voyage PDF • 2026
        </div>
      </div>

      <!-- Form Controls -->
      <div>
        <form id="formPersonalizedPdf" onsubmit="submitPersonalizedPdf(event)">
          <div style="margin-bottom: 1rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 4px; color: var(--clr-dark-900);">Vos Noms sur la couverture :</label>
            <input type="text" id="customName" placeholder="ex: Famille Dupont ou Marie & Julien" required
                   style="width: 100%; padding: 0.65rem 0.85rem; border-radius: 8px; border: 1px solid var(--clr-sand-300); font-size: 0.9rem;"
                   oninput="updatePdfPreview()">
          </div>

          <div style="margin-bottom: 1rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 4px; color: var(--clr-dark-900);">Vos dates de séjour (optionnel) :</label>
            <input type="text" id="customDates" placeholder="ex: Octobre 2026"
                   style="width: 100%; padding: 0.65rem 0.85rem; border-radius: 8px; border: 1px solid var(--clr-sand-300); font-size: 0.9rem;"
                   oninput="updatePdfPreview()">
          </div>

          <div style="margin-bottom: 1rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 4px; color: var(--clr-dark-900);">Choisissez la photo de couverture :</label>
            <select id="customPhotoSelect" style="width: 100%; padding: 0.65rem 0.85rem; border-radius: 8px; border: 1px solid var(--clr-sand-300); font-size: 0.9rem; background: #fff;" onchange="updatePdfPreview()">
              <option value="<?= asset('images/pdf_custom.png') ?>">Plage & Menzel VIP</option>
              <option value="<?= asset('images/djerbahood.png') ?>">Djerbahood Street Art</option>
              <option value="<?= asset('images/sidi_mahres.png') ?>">Plage Turquoise Sidi Mahres</option>
              <option value="<?= asset('images/guellala.png') ?>">Poterie & Sunset Guellala</option>
              <option value="<?= asset('images/ajim.png') ?>">Port & Bateaux de Pêche Ajim</option>
            </select>
          </div>

          <div style="margin-bottom: 1.25rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 4px; color: var(--clr-dark-900);">Votre E-mail de réception :</label>
            <input type="email" id="customEmail" placeholder="votre.email@exemple.com" required
                   style="width: 100%; padding: 0.65rem 0.85rem; border-radius: 8px; border: 1px solid var(--clr-sand-300); font-size: 0.9rem;">
          </div>

          <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--clr-sand-200); padding-top: 1rem;">
            <div>
              <span style="font-size: 0.75rem; color: var(--clr-gray-500);">Prix Spécial</span>
              <div style="font-weight: 800; font-size: 1.4rem; color: var(--clr-terracotta-500);">9,90 €</div>
            </div>
            <button type="submit" class="c-button c-button--primary" style="padding: 0.75rem 1.25rem; font-size: 0.9rem;">
              Commander mon PDF <i class="fi fi-rr-arrow-right"></i>
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
function updatePdfPreview() {
    const nameVal = document.getElementById('customName').value.trim();
    const datesVal = document.getElementById('customDates').value.trim();
    const photoVal = document.getElementById('customPhotoSelect').value;

    const titleElem = document.getElementById('previewTitle');
    const datesElem = document.getElementById('previewDates');
    const imgElem = document.getElementById('previewCoverImg');

    titleElem.textContent = nameVal ? 'Guide Djerba de ' + nameVal : 'Guide Djerba de Marie & Julien';
    datesElem.textContent = datesVal ? 'Séjour : ' + datesVal : 'Séjour du 15 au 22 Octobre 2026';
    if (photoVal) {
        imgElem.src = photoVal;
    }
}

function submitPersonalizedPdf(e) {
    e.preventDefault();
    const name = document.getElementById('customName').value;
    const dates = document.getElementById('customDates').value;
    const email = document.getElementById('customEmail').value;

    if (!name || !email) return;

    fetch('<?= url('/api/checkout/session') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            product_id: 1, // Special personalized PDF product ID
            email: email,
            custom_name: name,
            custom_dates: dates
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.redirect_url) {
            window.location.href = data.redirect_url;
        } else {
            alert(data.error || 'Erreur de paiement.');
        }
    })
    .catch(err => alert('Erreur réseau.'));
}
</script>
