<!-- Hero Section Itinéraires -->
<section class="c-hero" style="background: linear-gradient(180deg, rgba(15, 23, 42, 0.78) 0%, rgba(15, 23, 42, 0.94) 100%), url('<?= asset('images/hero.png') ?>') center/cover no-repeat;">
  <div class="l-container" data-animate style="text-align: center; max-width: 820px;">
    <div class="c-hero__badge" style="background: rgba(245, 158, 11, 0.15); border: 1px solid var(--clr-terracotta-500); color: #F59E0B; display: inline-flex; align-items: center; gap: 8px; padding: 6px 16px; border-radius: 50px; font-weight: 700; margin-bottom: 1.25rem;">
      <i class="fi fi-rr-calendar" style="color:#F59E0B;"></i> Plannings Clé en Main 2026
    </div>
    <h1 class="c-hero__title" style="color: #FFFFFF; margin-bottom: 1rem;">
      Itinéraires Sur-Mesure à Djerba
    </h1>
    <p class="c-hero__subtitle" style="color: var(--clr-sand-100); margin-bottom: 2rem;">
      Circuits optimisés 3, 5 et 7 jours élaborés par des résidents passionnés pour vivre le meilleur de Djerba sans perdre de temps.
    </p>
  </div>
</section>

<!-- Content Container -->
<div class="l-container" style="margin: 3.5rem auto 5rem auto; max-width: 960px;">

  <!-- Tabs Selector -->
  <div class="tabs c-scroll-tabs" style="margin-bottom: 3rem;">
    <button class="tab-btn active" onclick="switchItinerary('it-3', this)">
      <i class="fi fi-rr-clock"></i> 3 Jours (Week-end Express)
    </button>
    <button class="tab-btn" onclick="switchItinerary('it-5', this)">
      <i class="fi fi-rr-sun"></i> 5 Jours (Équilibre & Culture)
    </button>
    <button class="tab-btn" onclick="switchItinerary('it-7', this)">
      <i class="fi fi-rr-crown"></i> 7 Jours (Immersion & Sud Tunisien)
    </button>
  </div>

  <!-- ITINÉRAIRE 3 JOURS -->
  <div id="it-3" class="itinerary-pane" style="display: block;">
    <div class="c-card" style="margin-bottom: 2.5rem; background: linear-gradient(135deg, #FDFBF7 0%, #F4ECE1 100%); border-left: 5px solid var(--clr-sea-600);">
      <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
          <span class="badge badge--sea" style="margin-bottom: 0.5rem;">Idéal Court Séjour</span>
          <h2 style="font-size: 1.6rem; color: var(--clr-dark-900);">🌴 Circuit 3 Jours : L'Essentiel de Djerba</h2>
        </div>
        <div style="display: flex; gap: 1.5rem; font-size: 0.88rem; color: var(--clr-gray-500);">
          <div><strong style="color: var(--clr-dark-900); display: block;">Rythme</strong> Modéré</div>
          <div><strong style="color: var(--clr-dark-900); display: block;">Transport</strong> Taxis ou Scooter</div>
          <div><strong style="color: var(--clr-dark-900); display: block;">Budget</strong> ~120 € / pers</div>
        </div>
      </div>
    </div>

    <div class="c-timeline">
      <div class="c-timeline__item">
        <div class="c-timeline__dot">1</div>
        <div class="c-timeline__card">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; flex-wrap: wrap; gap: 0.5rem;">
            <h3 class="heading-3" style="color: var(--clr-dark-900);">Jour 1 : Houmt Souk, Fondouks & Forteresse Maritime</h3>
            <a href="<?= url('/destinations/houmt-souk') ?>" class="badge badge--sea">Voir Houmt Souk</a>
          </div>
          <p class="text-muted" style="line-height: 1.6; margin-bottom: 0.75rem;">
            <strong>Matin :</strong> Flânerie dans les souks piétons (épices, poteries, bijoux d'argent). Déjeuner typique au Fondouk El Attarine.<br>
            <strong>Après-midi :</strong> Visite de la forteresse médiévale Borj Ghazi Moustapha et promenade le long de la marina bordée de bateaux de pêcheurs.<br>
            <strong>Soir :</strong> Dîner poisson grillé dans une gargote du port.
          </p>
          <div style="background: rgba(0, 119, 182, 0.06); padding: 0.75rem 1rem; border-radius: 10px; font-size: 0.88rem; color: var(--clr-sea-900);">
            💡 <strong>Conseil d'Initié :</strong> Assistez à la criée du marché aux poissons à 10h tapantes pour voir les pêcheurs djerbiens en pleine action !
          </div>
        </div>
      </div>

      <div class="c-timeline__item">
        <div class="c-timeline__dot">2</div>
        <div class="c-timeline__card">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; flex-wrap: wrap; gap: 0.5rem;">
            <h3 class="heading-3" style="color: var(--clr-dark-900);">Jour 2 : Street Art à Djerbahood & Synagogue de la Ghriba</h3>
            <a href="<?= url('/destinations/midoun') ?>" class="badge badge--gold">Voir Djerbahood</a>
          </div>
          <p class="text-muted" style="line-height: 1.6; margin-bottom: 0.75rem;">
            <strong>Matin :</strong> Immersion artistique à Erriadh à la découverte des 250 fresques murales mondiales de Djerbahood.<br>
            <strong>Après-midi :</strong> Recueillement dans la majestueuse Synagogue de la Ghriba, la plus ancienne d'Afrique, aux faïences bleues sublimes.<br>
            <strong>Soir :</strong> Thé à la menthe et pâtisseries aux amandes au café traditionnel d'Erriadh.
          </p>
          <div style="background: rgba(245, 158, 11, 0.08); padding: 0.75rem 1rem; border-radius: 10px; font-size: 0.88rem; color: #B45309;">
            💡 <strong>Conseil d'Initié :</strong> Visitez Djerbahood entre 8h30 et 10h30 pour profiter d'une lumière rasante idéale pour vos photos.
          </div>
        </div>
      </div>

      <div class="c-timeline__item">
        <div class="c-timeline__dot">3</div>
        <div class="c-timeline__card">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; flex-wrap: wrap; gap: 0.5rem;">
            <h3 class="heading-3" style="color: var(--clr-dark-900);">Jour 3 : Plage de Sidi Mahres & Coucher de Soleil à Guellala</h3>
            <a href="<?= url('/destinations/sidi-mahres') ?>" class="badge badge--terracotta">Voir Sidi Mahres</a>
          </div>
          <p class="text-muted" style="line-height: 1.6; margin-bottom: 0.75rem;">
            <strong>Matin :</strong> Baignade et farniente sur le sable blanc et fin de la plage de Sidi Mahres.<br>
            <strong>Après-midi :</strong> Découverte des ateliers troglodytes de Guellala et visite du grand musée des traditions populaires.<br>
            <strong>Soir :</strong> Admirer le coucher de soleil flamboyant sur le golfe de Boughrara depuis la colline de Guellala.
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- ITINÉRAIRE 5 JOURS -->
  <div id="it-5" class="itinerary-pane" style="display: none;">
    <div class="c-card" style="margin-bottom: 2.5rem; background: linear-gradient(135deg, #FDFBF7 0%, #F4ECE1 100%); border-left: 5px solid var(--clr-terracotta-500);">
      <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
          <span class="badge badge--terracotta" style="margin-bottom: 0.5rem;">Formule la Plus Populaire</span>
          <h2 style="font-size: 1.6rem; color: var(--clr-dark-900);">⛵ Circuit 5 Jours : Culture, Mer & Évasion</h2>
        </div>
        <div style="display: flex; gap: 1.5rem; font-size: 0.88rem; color: var(--clr-gray-500);">
          <div><strong style="color: var(--clr-dark-900); display: block;">Rythme</strong> Équilibré</div>
          <div><strong style="color: var(--clr-dark-900); display: block;">Transport</strong> Voiture recommandée</div>
          <div><strong style="color: var(--clr-dark-900); display: block;">Budget</strong> ~220 € / pers</div>
        </div>
      </div>
    </div>

    <div class="c-timeline">
      <div class="c-timeline__item">
        <div class="c-timeline__dot">1-2</div>
        <div class="c-timeline__card">
          <h3 class="heading-3" style="color: var(--clr-dark-900); margin-bottom: 0.5rem;">Jours 1 & 2 : Cœur Historique & Street Art</h3>
          <p class="text-muted" style="line-height: 1.6;">
            Immersion complète à Houmt Souk (fondouks, marchands de tapis, musée du patrimoine) puis journée entière dédiée à Erriadh / Djerbahood et la Ghriba.
          </p>
        </div>
      </div>

      <div class="c-timeline__item">
        <div class="c-timeline__dot">3</div>
        <div class="c-timeline__card">
          <h3 class="heading-3" style="color: var(--clr-dark-900); margin-bottom: 0.5rem;">Jour 3 : Excursion Maritime à l'Île aux Flamants Roses</h3>
          <p class="text-muted" style="line-height: 1.6;">
            Journée complète en mer sur la presqu'île de Ras Rmel avec déjeuner poissons grillés sous paillote et baignade turquoise.
          </p>
        </div>
      </div>

      <div class="c-timeline__item">
        <div class="c-timeline__dot">4</div>
        <div class="c-timeline__card">
          <h3 class="heading-3" style="color: var(--clr-dark-900); margin-bottom: 0.5rem;">Jour 4 : Sports Nautiques à Aghir & Hammam Traditionnel</h3>
          <p class="text-muted" style="line-height: 1.6;">
            Session initiation kitesurf ou kayak dans la lagune d'Aghir. En soirée, rituel de bien-être oriental dans un hammam historique au savon noir.
          </p>
        </div>
      </div>

      <div class="c-timeline__item">
        <div class="c-timeline__dot">5</div>
        <div class="c-timeline__card">
          <h3 class="heading-3" style="color: var(--clr-dark-900); margin-bottom: 0.5rem;">Jour 5 : Marché de Midoun & Saveurs Gastronomiques</h3>
          <p class="text-muted" style="line-height: 1.6;">
            Visite du grand marché hebdomadaire de Midoun, achat d'huile d'olive pressée à froid et dégustation d'un couscous au mérou.
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- ITINÉRAIRE 7 JOURS -->
  <div id="it-7" class="itinerary-pane" style="display: none;">
    <div class="c-card" style="margin-bottom: 2.5rem; background: linear-gradient(135deg, #FDFBF7 0%, #F4ECE1 100%); border-left: 5px solid #F59E0B;">
      <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
          <span class="badge badge--gold" style="margin-bottom: 0.5rem;">Grand Tour VIP</span>
          <h2 style="font-size: 1.6rem; color: var(--clr-dark-900);">👑 Circuit 7 Jours : Djerba & Échappée Sud Tunisien</h2>
        </div>
        <div style="display: flex; gap: 1.5rem; font-size: 0.88rem; color: var(--clr-gray-500);">
          <div><strong style="color: var(--clr-dark-900); display: block;">Rythme</strong> Grand Voyageur</div>
          <div><strong style="color: var(--clr-dark-900); display: block;">Transport</strong> Voiture ou Chauffeur 4x4</div>
          <div><strong style="color: var(--clr-dark-900); display: block;">Budget</strong> ~350 € / pers</div>
        </div>
      </div>
    </div>

    <div class="c-timeline">
      <div class="c-timeline__item">
        <div class="c-timeline__dot">1-4</div>
        <div class="c-timeline__card">
          <h3 class="heading-3" style="color: var(--clr-dark-900); margin-bottom: 0.5rem;">Jours 1 à 4 : L'Île aux Rêves de Bout en Bout</h3>
          <p class="text-muted" style="line-height: 1.6;">
            Visite intégrale des 6 destinations phares : Houmt Souk, Djerbahood, Sidi Mahres, Aghir, Guellala et les pêcheurs d'éponges d'Ajim.
          </p>
        </div>
      </div>

      <div class="c-timeline__item">
        <div class="c-timeline__dot">5</div>
        <div class="c-timeline__card">
          <h3 class="heading-3" style="color: var(--clr-dark-900); margin-bottom: 0.5rem;">Jour 5 : Traversée Chaussée Romaine & Oasis de Ksar Ghilane</h3>
          <p class="text-muted" style="line-height: 1.6;">
            Passage sur le continent via la Chaussée Romaine millénaire d'El Kantara, route vers le Grand Erg Oriental, baignade dans la source chaude thermale de Ksar Ghilane et nuitée sous les étoiles du Sahara.
          </p>
        </div>
      </div>

      <div class="c-timeline__item">
        <div class="c-timeline__dot">6-7</div>
        <div class="c-timeline__card">
          <h3 class="heading-3" style="color: var(--clr-dark-900); margin-bottom: 0.5rem;">Jours 6 & 7 : Maisons Troglodytes de Matmata & Retour Serein</h3>
          <p class="text-muted" style="line-height: 1.6;">
            Exploration des paysages lunaires de Matmata et des habitations troglodytes berbères (décors Star Wars), retour à Djerba par le bac d'Ajim et soirée festive d'adieu.
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Call to Action Banner -->
  <div style="background: linear-gradient(135deg, var(--clr-sea-600) 0%, var(--clr-sea-900) 100%); color: #fff; padding: 2.5rem; border-radius: 20px; text-align: center; margin-top: 4rem;">
    <h2 style="font-size: 1.8rem; margin-bottom: 0.75rem; color: #fff;">Emportez vos Itinéraires avec Coordonnées GPS & Cartes Hors-Ligne</h2>
    <p style="color: var(--clr-sand-100); max-width: 650px; margin: 0 auto 2rem auto; font-size: 1rem; line-height: 1.6;">
      Téléchargez le guide complet au format PDF haute résolution avec adresses secrètes, horaires et réductions locales incluses.
    </p>
    <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
      <a href="<?= url('/shop') ?>" class="c-button c-button--primary" style="padding: 0.85rem 1.75rem; font-size: 1rem;">
        <i class="fi fi-rr-download"></i> Pack Voyageur Complet PDF (7,90 €)
      </a>
      <a href="<?= url('/concierge') ?>" class="c-button" style="background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.4); padding: 0.85rem 1.75rem; font-size: 1rem;">
        <i class="fi fi-rr-compass"></i> Conciergerie Sur-Mesure (29 €)
      </a>
    </div>
  </div>

</div>

<script>
function switchItinerary(paneId, btn) {
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');

  document.querySelectorAll('.itinerary-pane').forEach(pane => {
    pane.style.display = 'none';
  });

  const activePane = document.getElementById(paneId);
  if (activePane) {
    activePane.style.display = 'block';
  }
}
</script>
