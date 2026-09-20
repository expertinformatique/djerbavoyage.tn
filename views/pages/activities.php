<!-- Hero Section Activités -->
<section class="c-hero" style="background: linear-gradient(180deg, rgba(15, 23, 42, 0.78) 0%, rgba(15, 23, 42, 0.94) 100%), url('<?= asset('images/sidi_mahres.png') ?>') center/cover no-repeat;">
  <div class="l-container" data-animate style="text-align: center; max-width: 820px;">
    <div class="c-hero__badge" style="background: rgba(245, 158, 11, 0.15); border: 1px solid var(--clr-terracotta-500); color: #F59E0B; display: inline-flex; align-items: center; gap: 8px; padding: 6px 16px; border-radius: 50px; font-weight: 700; margin-bottom: 1.25rem;">
      <i class="fi fi-rr-compass" style="color:#F59E0B;"></i> <?= __('activities.hero_badge') ?>
    </div>
    <h1 class="c-hero__title" style="color: #FFFFFF; margin-bottom: 1rem;">
      <?= __('activities.hero_title') ?>
    </h1>
    <p class="c-hero__subtitle" style="color: var(--clr-sand-100); margin-bottom: 2rem;">
      <?= __('activities.hero_subtitle') ?>
    </p>
  </div>
</section>

<!-- Content Container -->
<div class="l-container" style="margin: 3.5rem auto 5rem auto;">

  <!-- Category Filter Tabs -->
  <div class="tabs c-scroll-tabs" style="margin-bottom: 2.5rem;">
    <button class="tab-btn active" onclick="filterActivities('all', this)">
      <i class="fi fi-rr-apps"></i> <?= __('activities.tab_all') ?>
    </button>
    <button class="tab-btn" onclick="filterActivities('nautisme', this)">
      <i class="fi fi-rr-water"></i> <?= __('activities.tab_nautisme') ?>
    </button>
    <button class="tab-btn" onclick="filterActivities('culture', this)">
      <i class="fi fi-rr-palette"></i> <?= __('activities.tab_culture') ?>
    </button>
    <button class="tab-btn" onclick="filterActivities('bateau', this)">
      <i class="fi fi-rr-ship"></i> <?= __('activities.tab_bateau') ?>
    </button>
    <button class="tab-btn" onclick="filterActivities('aventure', this)">
      <i class="fi fi-rr-motorcycle"></i> <?= __('activities.tab_aventure') ?>
    </button>
  </div>

  <!-- Activities Grid -->
  <div class="l-grid-cards">
    <!-- Activity 1: Kitesurf -->
    <article class="c-card activity-card" data-category="nautisme" style="display: flex; flex-direction: column; justify-content: space-between;">
      <div>
        <div style="position: relative; border-radius: 14px; overflow: hidden; height: 210px; margin-bottom: 1.25rem;">
          <img src="<?= asset('images/sidi_mahres.png') ?>" alt="Kitesurf Sidi Mahres" style="width: 100%; height: 100%; object-fit: cover;">
          <span class="badge badge--sea" style="position: absolute; top: 12px; left: 12px;">Nautisme</span>
          <span style="position: absolute; top: 12px; right: 12px; background: rgba(15,23,42,0.85); color: #F59E0B; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.85rem;">★ 4.9</span>
        </div>
        <div style="font-size: 0.8rem; color: var(--clr-sea-600); font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Plage Sidi Mahres & Aghir</div>
        <h3 class="heading-3" style="margin-bottom: 0.5rem; color: var(--clr-dark-900);">Session Kitesurf dans la Lagune</h3>
        <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">
          Profitez de l'un des spots d'eau plate et tiède les plus réputés de Méditerranée avec des instructeurs certifiés IKO. Matériel pro fourni.
        </p>
         <div style="border-top: 1px solid var(--clr-sand-300); padding-top: 1rem; display: flex; flex-direction: column; gap: 0.75rem;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <span style="font-size: 0.75rem; color: var(--clr-gray-500); text-transform: uppercase;"><?= __('activities.from_price') ?></span>
            <div style="font-weight: 800; font-size: 1.25rem; color: var(--clr-sea-900);"><?= money(45) ?> <span style="font-size: 0.85rem; font-weight: normal; color: var(--clr-gray-500);"><?= __('activities.per_person') ?></span></div>
          </div>
          <a href="<?= url('/concierge') ?>" class="c-button c-button--primary" style="padding: 0.6rem 1.15rem; font-size: 0.88rem;">
            <?= __('activities.book_vip') ?> <i class="fi fi-rr-arrow-right"></i>
          </a>
        </div>
        <div class="c-card__icon-group" style="justify-content: flex-end;">
          <button type="button" class="c-icon-btn c-icon-btn--booking" title="Hôtels & Hébergements Proches sur Booking.com" onclick="openBookingHotelsModal('Lagune Sidi Mahres', 'https://www.booking.com/city/tn/houmt-souk.html?aid=8073836')">
            <i class="fi fi-rr-hotel"></i>
          </button>
          <button type="button" class="c-icon-btn c-icon-btn--whatsapp" title="Partager l'activité sur WhatsApp" onclick="shareOnWhatsApp('Session Kitesurf dans la Lagune Djerba')">
            <i class="fi fi-rr-paper-plane"></i>
          </button>
          <button type="button" class="c-icon-btn c-icon-btn--copy" title="Copier le lien de l'activité" onclick="copyCardLink('Session Kitesurf Lagune', '', this)">
            <i class="fi fi-rr-copy"></i>
          </button>
          <button type="button" class="c-icon-btn c-icon-btn--pdf" title="Exporter Fiche Activité PDF" onclick="openPdfModalForCard('Session Kitesurf Lagune')">
            <i class="fi fi-rr-file-pdf"></i>
          </button>
        </div>
      </div>
    </article>

    <!-- Activity 2: Djerbahood -->
    <article class="c-card activity-card" data-category="culture" style="display: flex; flex-direction: column; justify-content: space-between;">
      <div>
        <div style="position: relative; border-radius: 14px; overflow: hidden; height: 210px; margin-bottom: 1.25rem;">
          <img src="<?= asset('images/djerbahood.png') ?>" alt="Djerbahood Street Art" style="width: 100%; height: 100%; object-fit: cover;">
          <span class="badge badge--gold" style="position: absolute; top: 12px; left: 12px;">Culture & Art</span>
          <span style="position: absolute; top: 12px; right: 12px; background: rgba(15,23,42,0.85); color: #F59E0B; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.85rem;">★ 5.0</span>
        </div>
        <div style="font-size: 0.8rem; color: var(--clr-sea-600); font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Village d'Erriadh</div>
        <h3 class="heading-3" style="margin-bottom: 0.5rem; color: var(--clr-dark-900);">Visite Guidée Privée Djerbahood</h3>
        <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">
          Déambulez dans les ruelles blanchies à la chaux et percez tous les secrets des 250 fresques de street art mondial créées par 150 artistes.
        </p>
      </div>
      <div style="border-top: 1px solid var(--clr-sand-300); padding-top: 1rem; display: flex; flex-direction: column; gap: 0.75rem;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <span style="font-size: 0.75rem; color: var(--clr-gray-500); text-transform: uppercase;"><?= __('activities.from_price') ?></span>
            <div style="font-weight: 800; font-size: 1.25rem; color: var(--clr-sea-900);"><?= money(30) ?> <span style="font-size: 0.85rem; font-weight: normal; color: var(--clr-gray-500);"><?= __('activities.per_group') ?></span></div>
          </div>
          <a href="<?= url('/concierge') ?>" class="c-button c-button--primary" style="padding: 0.6rem 1.15rem; font-size: 0.88rem;">
            <?= __('activities.book_vip') ?> <i class="fi fi-rr-arrow-right"></i>
          </a>
        </div>
        <div class="c-card__icon-group" style="justify-content: flex-end;">
          <button type="button" class="c-icon-btn c-icon-btn--booking" title="Hôtels & Ryads Erriadh sur Booking.com" onclick="openBookingHotelsModal('Hôtels Erriadh Djerbahood', 'https://www.booking.com/city/tn/houmt-souk.html?aid=8073836')">
            <i class="fi fi-rr-hotel"></i>
          </button>
          <button type="button" class="c-icon-btn c-icon-btn--whatsapp" title="Partager l'activité sur WhatsApp" onclick="shareOnWhatsApp('Visite Guidée Privée Djerbahood')">
            <i class="fi fi-rr-paper-plane"></i>
          </button>
          <button type="button" class="c-icon-btn c-icon-btn--copy" title="Copier le lien de l'activité" onclick="copyCardLink('Visite Privée Djerbahood', '', this)">
            <i class="fi fi-rr-copy"></i>
          </button>
          <button type="button" class="c-icon-btn c-icon-btn--pdf" title="Exporter Fiche Activité PDF" onclick="openPdfModalForCard('Visite Privée Djerbahood')">
            <i class="fi fi-rr-file-pdf"></i>
          </button>
        </div>
      </div>
    </article>

    <!-- Activity 3: Bateau Pirate -->
    <article class="c-card activity-card" data-category="bateau" style="display: flex; flex-direction: column; justify-content: space-between;">
      <div>
        <div style="position: relative; border-radius: 14px; overflow: hidden; height: 210px; margin-bottom: 1.25rem;">
          <img src="<?= asset('images/hero.png') ?>" alt="Bateau Île Flamants Roses" style="width: 100%; height: 100%; object-fit: cover;">
          <span class="badge badge--sea" style="position: absolute; top: 12px; left: 12px;">Bateau & Mer</span>
          <span style="position: absolute; top: 12px; right: 12px; background: rgba(15,23,42,0.85); color: #F59E0B; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.85rem;">★ 4.8</span>
        </div>
        <div style="font-size: 0.8rem; color: var(--clr-sea-600); font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Port de Houmt Souk</div>
        <h3 class="heading-3" style="margin-bottom: 0.5rem; color: var(--clr-dark-900);">Bateau Pirate & Île aux Flamants Roses</h3>
        <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">
          Journée complète sur la presqu'île de Ras Rmel : eaux cristallines, baignade, déjeuner poissons grillés et animation musicale djerbienne.
        </p>
      </div>
      <div style="border-top: 1px solid var(--clr-sand-300); padding-top: 1rem; display: flex; flex-direction: column; gap: 0.75rem;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <span style="font-size: 0.75rem; color: var(--clr-gray-500); text-transform: uppercase;"><?= __('activities.from_price') ?></span>
            <div style="font-weight: 800; font-size: 1.25rem; color: var(--clr-sea-900);"><?= money(35) ?> <span style="font-size: 0.85rem; font-weight: normal; color: var(--clr-gray-500);"><?= __('activities.per_person') ?></span></div>
          </div>
          <a href="<?= url('/concierge') ?>" class="c-button c-button--primary" style="padding: 0.6rem 1.15rem; font-size: 0.88rem;">
            <?= __('activities.book_vip') ?> <i class="fi fi-rr-arrow-right"></i>
          </a>
        </div>
        <div class="c-card__icon-group" style="justify-content: flex-end;">
          <button type="button" class="c-icon-btn c-icon-btn--booking" title="Hôtels Houmt Souk Port sur Booking.com" onclick="openBookingHotelsModal('Hôtels Houmt Souk Port', 'https://www.booking.com/city/tn/houmt-souk.html?aid=8073836')">
            <i class="fi fi-rr-hotel"></i>
          </button>
          <button type="button" class="c-icon-btn c-icon-btn--whatsapp" title="Partager l'activité sur WhatsApp" onclick="shareOnWhatsApp('Bateau Pirate Île aux Flamants Roses')">
            <i class="fi fi-rr-paper-plane"></i>
          </button>
          <button type="button" class="c-icon-btn c-icon-btn--copy" title="Copier le lien de l'activité" onclick="copyCardLink('Bateau Pirate Île Flamants Roses', '', this)">
            <i class="fi fi-rr-copy"></i>
          </button>
          <button type="button" class="c-icon-btn c-icon-btn--pdf" title="Exporter Fiche Activité PDF" onclick="openPdfModalForCard('Bateau Pirate Île Flamants Roses')">
            <i class="fi fi-rr-file-pdf"></i>
          </button>
        </div>
      </div>
    </article>

    <!-- Activity 4: Quad -->
    <article class="c-card activity-card" data-category="aventure" style="display: flex; flex-direction: column; justify-content: space-between;">
      <div>
        <div style="position: relative; border-radius: 14px; overflow: hidden; height: 210px; margin-bottom: 1.25rem;">
          <img src="<?= asset('images/concierge.png') ?>" alt="Quad au Coucher de Soleil" style="width: 100%; height: 100%; object-fit: cover;">
          <span class="badge badge--terracotta" style="position: absolute; top: 12px; left: 12px;">Aventure</span>
          <span style="position: absolute; top: 12px; right: 12px; background: rgba(15,23,42,0.85); color: #F59E0B; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.85rem;">★ 4.9</span>
        </div>
        <div style="font-size: 0.8rem; color: var(--clr-sea-600); font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Pistes de la Lagune</div>
        <h3 class="heading-3" style="margin-bottom: 0.5rem; color: var(--clr-dark-900);">Randonnée Quad au Coucher du Soleil</h3>
        <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">
          Parcourez les sentiers côtiers entre palmeraies et plages sauvages. Pause thé à la menthe traditionnel face au soleil couchant sur la lagune.
        </p>
      </div>
      <div style="border-top: 1px solid var(--clr-sand-300); padding-top: 1rem; display: flex; flex-direction: column; gap: 0.75rem;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <span style="font-size: 0.75rem; color: var(--clr-gray-500); text-transform: uppercase;"><?= __('activities.from_price') ?></span>
            <div style="font-weight: 800; font-size: 1.25rem; color: var(--clr-sea-900);"><?= money(40) ?> <span style="font-size: 0.85rem; font-weight: normal; color: var(--clr-gray-500);"><?= __('activities.per_quad') ?></span></div>
          </div>
          <a href="<?= url('/concierge') ?>" class="c-button c-button--primary" style="padding: 0.6rem 1.15rem; font-size: 0.88rem;">
            <?= __('activities.book_vip') ?> <i class="fi fi-rr-arrow-right"></i>
          </a>
        </div>
        <div class="c-card__icon-group" style="justify-content: flex-end;">
          <button type="button" class="c-icon-btn c-icon-btn--booking" title="Hôtels Zone Touristique sur Booking.com" onclick="openBookingHotelsModal('Hôtels Zone Touristique Djerba', 'https://www.booking.com/city/tn/houmt-souk.html?aid=8073836')">
            <i class="fi fi-rr-hotel"></i>
          </button>
          <button type="button" class="c-icon-btn c-icon-btn--whatsapp" title="Partager l'activité sur WhatsApp" onclick="shareOnWhatsApp('Randonnée Quad au Coucher du Soleil Djerba')">
            <i class="fi fi-rr-paper-plane"></i>
          </button>
          <button type="button" class="c-icon-btn c-icon-btn--copy" title="Copier le lien de l'activité" onclick="copyCardLink('Quad Coucher du Soleil Djerba', '', this)">
            <i class="fi fi-rr-copy"></i>
          </button>
          <button type="button" class="c-icon-btn c-icon-btn--pdf" title="Exporter Fiche Activité PDF" onclick="openPdfModalForCard('Randonnée Quad Coucher du Soleil')">
            <i class="fi fi-rr-file-pdf"></i>
          </button>
        </div>
      </div>
    </article>

    <!-- Activity 5: Poterie Guellala -->
    <article class="c-card activity-card" data-category="culture" style="display: flex; flex-direction: column; justify-content: space-between;">
      <div>
        <div style="position: relative; border-radius: 14px; overflow: hidden; height: 210px; margin-bottom: 1.25rem;">
          <img src="<?= asset('images/guellala.png') ?>" alt="Poterie Guellala" style="width: 100%; height: 100%; object-fit: cover;">
          <span class="badge badge--gold" style="position: absolute; top: 12px; left: 12px;">Artisanat</span>
          <span style="position: absolute; top: 12px; right: 12px; background: rgba(15,23,42,0.85); color: #F59E0B; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.85rem;">★ 4.9</span>
        </div>
        <div style="font-size: 0.8rem; color: var(--clr-sea-600); font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Village de Guellala</div>
        <h3 class="heading-3" style="margin-bottom: 0.5rem; color: var(--clr-dark-900);">Atelier Poterie & Musée des Traditions</h3>
        <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">
          Visitez les ateliers troglodytes des maîtres potiers, façonnez votre propre souvenir en argile et admirez le panorama depuis le musée perché.
        </p>
      </div>
      <div style="border-top: 1px solid var(--clr-sand-300); padding-top: 1rem; display: flex; flex-direction: column; gap: 0.75rem;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <span style="font-size: 0.75rem; color: var(--clr-gray-500); text-transform: uppercase;"><?= __('activities.from_price') ?></span>
            <div style="font-weight: 800; font-size: 1.25rem; color: var(--clr-sea-900);"><?= money(25) ?> <span style="font-size: 0.85rem; font-weight: normal; color: var(--clr-gray-500);"><?= __('activities.per_person') ?></span></div>
          </div>
          <a href="<?= url('/concierge') ?>" class="c-button c-button--primary" style="padding: 0.6rem 1.15rem; font-size: 0.88rem;">
            <?= __('activities.book_vip') ?> <i class="fi fi-rr-arrow-right"></i>
          </a>
        </div>
        <div class="c-card__icon-group" style="justify-content: flex-end;">
          <button type="button" class="c-icon-btn c-icon-btn--booking" title="Menzels & Hébergements Guellala sur Booking.com" onclick="openBookingHotelsModal('Hôtels Guellala Sunset', 'https://www.booking.com/city/tn/houmt-souk.html?aid=8073836')">
            <i class="fi fi-rr-hotel"></i>
          </button>
          <button type="button" class="c-icon-btn c-icon-btn--whatsapp" title="Partager l'activité sur WhatsApp" onclick="shareOnWhatsApp('Atelier Poterie & Musée des Traditions Guellala')">
            <i class="fi fi-rr-paper-plane"></i>
          </button>
          <button type="button" class="c-icon-btn c-icon-btn--copy" title="Copier le lien de l'activité" onclick="copyCardLink('Atelier Poterie Guellala', '', this)">
            <i class="fi fi-rr-copy"></i>
          </button>
          <button type="button" class="c-icon-btn c-icon-btn--pdf" title="Exporter Fiche Activité PDF" onclick="openPdfModalForCard('Atelier Poterie Guellala')">
            <i class="fi fi-rr-file-pdf"></i>
          </button>
        </div>
      </div>
    </article>

    <!-- Activity 6: Pêche aux éponges Ajim -->
    <article class="c-card activity-card" data-category="bateau" style="display: flex; flex-direction: column; justify-content: space-between;">
      <div>
        <div style="position: relative; border-radius: 14px; overflow: hidden; height: 210px; margin-bottom: 1.25rem;">
          <img src="<?= asset('images/ajim.png') ?>" alt="Port d'Ajim" style="width: 100%; height: 100%; object-fit: cover;">
          <span class="badge badge--sea" style="position: absolute; top: 12px; left: 12px;">Maritime</span>
          <span style="position: absolute; top: 12px; right: 12px; background: rgba(15,23,42,0.85); color: #F59E0B; padding: 4px 10px; border-radius: 20px; font-weight: 700; font-size: 0.85rem;">★ 4.7</span>
        </div>
        <div style="font-size: 0.8rem; color: var(--clr-sea-600); font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Port d'Ajim & El Melga</div>
        <h3 class="heading-3" style="margin-bottom: 0.5rem; color: var(--clr-dark-900);">Pêche aux Éponges & Décor Star Wars</h3>
        <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">
          Rencontrez les derniers pêcheurs d'éponges naturelles, montez à bord d'une embarcation traditionnelle et découvrez le site culte de tournage Star Wars.
        </p>
      </div>
      <div style="border-top: 1px solid var(--clr-sand-300); padding-top: 1rem; display: flex; flex-direction: column; gap: 0.75rem;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <div>
            <span style="font-size: 0.75rem; color: var(--clr-gray-500); text-transform: uppercase;"><?= __('activities.from_price') ?></span>
            <div style="font-weight: 800; font-size: 1.25rem; color: var(--clr-sea-900);"><?= money(45) ?> <span style="font-size: 0.85rem; font-weight: normal; color: var(--clr-gray-500);"><?= __('activities.per_person') ?></span></div>
          </div>
          <a href="<?= url('/concierge') ?>" class="c-button c-button--primary" style="padding: 0.6rem 1.15rem; font-size: 0.88rem;">
            <?= __('activities.book_vip') ?> <i class="fi fi-rr-arrow-right"></i>
          </a>
        </div>
        <div class="c-card__icon-group" style="justify-content: flex-end;">
          <button type="button" class="c-icon-btn c-icon-btn--booking" title="Hôtels Ajim & Port sur Booking.com" onclick="openBookingHotelsModal('Hôtels Port d Ajim', 'https://www.booking.com/city/tn/houmt-souk.html?aid=8073836')">
            <i class="fi fi-rr-hotel"></i>
          </button>
          <button type="button" class="c-icon-btn c-icon-btn--whatsapp" title="Partager l'activité sur WhatsApp" onclick="shareOnWhatsApp('Pêche aux Éponges & Décor Star Wars Ajim')">
            <i class="fi fi-rr-paper-plane"></i>
          </button>
          <button type="button" class="c-icon-btn c-icon-btn--copy" title="Copier le lien de l'activité" onclick="copyCardLink('Pêche Éponges Ajim', '', this)">
            <i class="fi fi-rr-copy"></i>
          </button>
          <button type="button" class="c-icon-btn c-icon-btn--pdf" title="Exporter Fiche Activité PDF" onclick="openPdfModalForCard('Pêche Éponges Ajim Star Wars')">
            <i class="fi fi-rr-file-pdf"></i>
          </button>
        </div>
      </div>
    </article>
  </div>

  <!-- Concierge VIP Support Banner -->
  <div style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); color: #fff; padding: 2.5rem; border-radius: 20px; margin-top: 4rem; border: 1px solid var(--clr-terracotta-500); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 2rem;">
    <div style="max-width: 650px;">
      <span class="badge badge--gold" style="margin-bottom: 0.75rem;"><?= __('activities.banner_badge') ?></span>
      <h2 style="font-size: 1.8rem; margin-bottom: 0.5rem; color: #fff;"><?= __('activities.banner_title') ?></h2>
      <p style="color: var(--clr-sand-500); line-height: 1.6; font-size: 0.95rem;">
        <?= __('activities.banner_desc') ?>
      </p>
    </div>
    <a href="<?= url('/concierge') ?>" class="c-button c-button--primary" style="padding: 0.9rem 1.75rem; font-size: 1rem;">
      <i class="fi fi-rr-comment-alt"></i> <?= __('activities.banner_btn') ?>
    </a>
  </div>

</div>

<script>
function filterActivities(category, btn) {
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');

  const cards = document.querySelectorAll('.activity-card');
  cards.forEach(card => {
    if (category === 'all' || card.dataset.category === category) {
      card.style.display = 'flex';
    } else {
      card.style.display = 'none';
    }
  });
}
</script>
