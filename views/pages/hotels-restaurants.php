<div class="container section" style="margin-top: 3rem; margin-bottom: 5rem;">
    <div class="section-title text-center" style="max-width: 800px; margin: 0 auto 3.5rem auto;">
        <span class="badge badge--gold" style="background: rgba(212,175,55,0.15); color: #F59E0B; padding: 6px 16px; border-radius: 50px; font-weight: 700; display: inline-block; margin-bottom: 10px;">Adresses Sélectionnées 2026</span>
        <h1 class="heading-1" style="margin-bottom: 12px;">Hôtels de Charme, Menzels & Tables Secrètes</h1>
        <p class="text-muted" style="color: var(--clr-gray-500); font-size: 1.1rem; line-height: 1.6;">
            Découvrez nos recommandations testées et approuvées par nos concierges locaux : des ryads de charme d'Erriadh aux meilleurs restaurants de poisson d'Houmt Souk.
        </p>
    </div>

    <!-- Filter Buttons -->
    <div class="tabs" style="justify-content: center; margin-bottom: 2.5rem;">
        <button class="tab-btn active" onclick="filterHotelsRestos('all', this)">Tous les établissements</button>
        <button class="tab-btn" onclick="filterHotelsRestos('hotel', this)">🏨 Hôtels & Menzels de Charme</button>
        <button class="tab-btn" onclick="filterHotelsRestos('resto', this)">🍽️ Restaurants & Gastronomie</button>
    </div>

    <!-- Cards Grid -->
    <div class="l-grid-cards l-grid-cards--3cols">

        
        <!-- Hotel 1 -->
        <article class="c-card resto-item" data-type="hotel">
            <div style="height: 220px; position: relative;">
                <img src="<?= asset('images/concierge.png') ?>" alt="Dar Dhiafa Erriadh" style="width: 100%; height: 100%; object-fit: cover;">
                <span class="c-card__badge-tag">Menzel de Charme</span>
                <span class="c-card__badge-rating">★ 4.9</span>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-size: 0.8rem; color: var(--clr-sea-600); font-weight: 700; text-transform: uppercase;">Erriadh (Djerbahood)</div>
                <h3 class="heading-3" style="margin: 6px 0 10px; font-size: 1.3rem;">Dar Dhiafa - Les Maisons du Houss</h3>
                <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.25rem;">
                    Véritable bijou d'architecture djerbienne niché au cœur d'Erriadh. Cours intérieures avec palmiers, deux piscines d'eau tiède et suites décorées d'objets d'artisanat.
                </p>
                <div style="display: flex; flex-direction: column; gap: 0.75rem; border-top: 1px solid var(--clr-sand-200); padding-top: 1rem;">
                    <div class="c-card__price-row">
                        <span class="c-card__price">À partir de <strong>110 €</strong> <span class="c-card__price-unit">/ nuit</span></span>
                        <a href="<?= url('/concierge') ?>" class="btn btn--gold c-card__btn-vip">Réserver via VIP</a>
                    </div>
                    <div class="c-card__icon-group" style="justify-content: flex-end;">
                        <button type="button" class="c-icon-btn c-icon-btn--booking" title="Voir sur Booking.com (Partenaire Officiel)" onclick="openBookingHotelsModal('Dar Dhiafa Erriadh', 'https://www.booking.com/city/tn/houmt-souk.html?aid=8073836')">
                            <i class="fi fi-rr-hotel"></i>
                        </button>
                        <button type="button" class="c-icon-btn c-icon-btn--whatsapp" title="Partager sur WhatsApp" onclick="shareOnWhatsApp('Dar Dhiafa Erriadh')">
                            <i class="fi fi-rr-paper-plane"></i>
                        </button>
                        <button type="button" class="c-icon-btn c-icon-btn--copy" title="Copier le lien" onclick="copyCardLink('Dar Dhiafa Erriadh', '', this)">
                            <i class="fi fi-rr-copy"></i>
                        </button>
                        <button type="button" class="c-icon-btn c-icon-btn--pdf" title="Fiche PDF Souvenir" onclick="openPdfModalForCard('Dar Dhiafa Erriadh')">
                            <i class="fi fi-rr-file-pdf"></i>
                        </button>
                    </div>
                </div>
            </div>
        </article>

        <!-- Hotel 2 -->
        <article class="c-card resto-item" data-type="hotel">
            <div style="height: 220px; position: relative;">
                <img src="<?= asset('images/sidi_mahres.png') ?>" alt="Radisson Blu Palace Djerba" style="width: 100%; height: 100%; object-fit: cover;">
                <span class="c-card__badge-tag">Resort & Thalasso 5★</span>
                <span class="c-card__badge-rating">★ 4.8</span>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-size: 0.8rem; color: var(--clr-sea-600); font-weight: 700; text-transform: uppercase;">Sidi Mahres Beach</div>
                <h3 class="heading-3" style="margin: 6px 0 10px; font-size: 1.3rem;">Radisson Blu Palace Thalasso</h3>
                <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.25rem;">
                    Espaces somptueux situés directement sur la plage de sable blanc. Centre de thalassothérapie Athénée Thalasso de renommée internationale.
                </p>
                <div style="display: flex; flex-direction: column; gap: 0.75rem; border-top: 1px solid var(--clr-sand-200); padding-top: 1rem;">
                    <div class="c-card__price-row">
                        <span class="c-card__price">À partir de <strong>145 €</strong> <span class="c-card__price-unit">/ nuit</span></span>
                        <a href="<?= url('/concierge') ?>" class="btn btn--gold c-card__btn-vip">Réserver via VIP</a>
                    </div>
                    <div class="c-card__icon-group" style="justify-content: flex-end;">
                        <button type="button" class="c-icon-btn c-icon-btn--booking" title="Voir sur Booking.com (Partenaire Officiel)" onclick="openBookingHotelsModal('Radisson Blu Palace', 'https://www.booking.com/city/tn/houmt-souk.html?aid=8073836')">
                            <i class="fi fi-rr-hotel"></i>
                        </button>
                        <button type="button" class="c-icon-btn c-icon-btn--whatsapp" title="Partager sur WhatsApp" onclick="shareOnWhatsApp('Radisson Blu Palace Thalasso')">
                            <i class="fi fi-rr-paper-plane"></i>
                        </button>
                        <button type="button" class="c-icon-btn c-icon-btn--copy" title="Copier le lien" onclick="copyCardLink('Radisson Blu Palace', '', this)">
                            <i class="fi fi-rr-copy"></i>
                        </button>
                        <button type="button" class="c-icon-btn c-icon-btn--pdf" title="Fiche PDF Souvenir" onclick="openPdfModalForCard('Radisson Blu Palace Thalasso')">
                            <i class="fi fi-rr-file-pdf"></i>
                        </button>
                    </div>
                </div>
            </div>
        </article>

        <!-- Restaurant 1 -->
        <article class="c-card resto-item" data-type="resto">
            <div style="height: 220px; position: relative;">
                <img src="<?= asset('images/houmt_souk.png') ?>" alt="El Fondouk Restaurant" style="width: 100%; height: 100%; object-fit: cover;">
                <span class="c-card__badge-tag">Gastronomie Traditionnelle</span>
                <span class="c-card__badge-rating">★ 5.0</span>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-size: 0.8rem; color: var(--clr-sea-600); font-weight: 700; text-transform: uppercase;">Houmt Souk (Fondouk)</div>
                <h3 class="heading-3" style="margin: 6px 0 10px; font-size: 1.3rem;">Restaurant El Fondouk</h3>
                <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.25rem;">
                    Niché dans un caravanserail du XVIIIe siècle magnifiquement restauré. Dégustez le fameux couscous au mérou et les briques djerbiennes sous les arcades.
                </p>
                <div style="display: flex; flex-direction: column; gap: 0.75rem; border-top: 1px solid var(--clr-sand-200); padding-top: 1rem;">
                    <div class="c-card__price-row">
                        <span class="c-card__price">Budget : <strong>25 € - 45 €</strong></span>
                        <a href="<?= url('/concierge') ?>" class="btn btn--gold c-card__btn-vip">Réserver via VIP</a>
                    </div>
                    <div class="c-card__icon-group" style="justify-content: flex-end;">
                        <button type="button" class="c-icon-btn c-icon-btn--booking" title="Voir sur Booking.com (Partenaire Officiel)" onclick="openBookingHotelsModal('Restaurant El Fondouk', 'https://www.booking.com/city/tn/houmt-souk.html?aid=8073836')">
                            <i class="fi fi-rr-hotel"></i>
                        </button>
                        <button type="button" class="c-icon-btn c-icon-btn--whatsapp" title="Partager sur WhatsApp" onclick="shareOnWhatsApp('Restaurant El Fondouk')">
                            <i class="fi fi-rr-paper-plane"></i>
                        </button>
                        <button type="button" class="c-icon-btn c-icon-btn--copy" title="Copier le lien" onclick="copyCardLink('Restaurant El Fondouk', '', this)">
                            <i class="fi fi-rr-copy"></i>
                        </button>
                        <button type="button" class="c-icon-btn c-icon-btn--pdf" title="Fiche PDF Souvenir" onclick="openPdfModalForCard('Restaurant El Fondouk')">
                            <i class="fi fi-rr-file-pdf"></i>
                        </button>
                    </div>
                </div>
            </div>
        </article>

        <!-- Restaurant 2 -->
        <article class="c-card resto-item" data-type="resto">
            <div style="height: 220px; position: relative;">
                <img src="<?= asset('images/hero.png') ?>" alt="Restaurant Haroun" style="width: 100%; height: 100%; object-fit: cover;">
                <span class="c-card__badge-tag">Fruits de Mer & Marina</span>
                <span class="c-card__badge-rating">★ 4.9</span>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-size: 0.8rem; color: var(--clr-sea-600); font-weight: 700; text-transform: uppercase;">Marina d'Houmt Souk</div>
                <h3 class="heading-3" style="margin: 6px 0 10px; font-size: 1.3rem;">Le Haroun - Table du Port</h3>
                <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.25rem;">
                    Installé directement au bord des bateaux de pêche. Spécialités de crevettes royales grillées, calamars farcis et poissons sauvages fraîchement pechés.
                </p>
                <div style="display: flex; flex-direction: column; gap: 0.75rem; border-top: 1px solid var(--clr-sand-200); padding-top: 1rem;">
                    <div class="c-card__price-row">
                        <span class="c-card__price">Budget : <strong>30 € - 55 €</strong></span>
                        <a href="<?= url('/concierge') ?>" class="btn btn--gold c-card__btn-vip">Réserver via VIP</a>
                    </div>
                    <div class="c-card__icon-group" style="justify-content: flex-end;">
                        <button type="button" class="c-icon-btn c-icon-btn--booking" title="Voir sur Booking.com (Partenaire Officiel)" onclick="openBookingHotelsModal('Le Haroun Table du Port', 'https://www.booking.com/city/tn/houmt-souk.html?aid=8073836')">
                            <i class="fi fi-rr-hotel"></i>
                        </button>
                        <button type="button" class="c-icon-btn c-icon-btn--whatsapp" title="Partager sur WhatsApp" onclick="shareOnWhatsApp('Le Haroun - Table du Port')">
                            <i class="fi fi-rr-paper-plane"></i>
                        </button>
                        <button type="button" class="c-icon-btn c-icon-btn--copy" title="Copier le lien" onclick="copyCardLink('Le Haroun', '', this)">
                            <i class="fi fi-rr-copy"></i>
                        </button>
                        <button type="button" class="c-icon-btn c-icon-btn--pdf" title="Fiche PDF Souvenir" onclick="openPdfModalForCard('Le Haroun Table du Port')">
                            <i class="fi fi-rr-file-pdf"></i>
                        </button>
                    </div>
                </div>
            </div>
        </article>

        <!-- Hotel 3: Guellala & Ajim -->
        <article class="c-card resto-item" data-type="hotel">
            <div style="height: 220px; position: relative;">
                <img src="<?= asset('images/guellala.png') ?>" alt="Menzel Guellala Sunset" style="width: 100%; height: 100%; object-fit: cover;">
                <span class="c-card__badge-tag">Ecolodge & Sunset</span>
                <span class="c-card__badge-rating">★ 4.9</span>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-size: 0.8rem; color: var(--clr-sea-600); font-weight: 700; text-transform: uppercase;">Guellala (Village Potiers)</div>
                <h3 class="heading-3" style="margin: 6px 0 10px; font-size: 1.3rem;">Menzel Guellala & Terres Rouges</h3>
                <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.25rem;">
                    Menzel éco-responsable dominant les collines de potiers avec vue imprenable sur les couchers de soleil du Golfe de Boughrara.
                </p>
                <div style="display: flex; flex-direction: column; gap: 0.75rem; border-top: 1px solid var(--clr-sand-200); padding-top: 1rem;">
                    <div class="c-card__price-row">
                        <span class="c-card__price">À partir de <strong>85 €</strong> <span class="c-card__price-unit">/ nuit</span></span>
                        <a href="<?= url('/concierge') ?>" class="btn btn--gold c-card__btn-vip">Réserver via VIP</a>
                    </div>
                    <div class="c-card__icon-group" style="justify-content: flex-end;">
                        <button type="button" class="c-icon-btn c-icon-btn--booking" title="Voir sur Booking.com (Partenaire Officiel)" onclick="openBookingHotelsModal('Menzel Guellala', 'https://www.booking.com/city/tn/houmt-souk.html?aid=8073836')">
                            <i class="fi fi-rr-hotel"></i>
                        </button>
                        <button type="button" class="c-icon-btn c-icon-btn--whatsapp" title="Partager sur WhatsApp" onclick="shareOnWhatsApp('Menzel Guellala & Terres Rouges')">
                            <i class="fi fi-rr-paper-plane"></i>
                        </button>
                        <button type="button" class="c-icon-btn c-icon-btn--copy" title="Copier le lien" onclick="copyCardLink('Menzel Guellala', '', this)">
                            <i class="fi fi-rr-copy"></i>
                        </button>
                        <button type="button" class="c-icon-btn c-icon-btn--pdf" title="Fiche PDF Souvenir" onclick="openPdfModalForCard('Menzel Guellala')">
                            <i class="fi fi-rr-file-pdf"></i>
                        </button>
                    </div>
                </div>
            </div>
        </article>

        <!-- Restaurant 3: Ajim Port -->
        <article class="c-card resto-item" data-type="resto">
            <div style="height: 220px; position: relative;">
                <img src="<?= asset('images/ajim.png') ?>" alt="Le Pêcheur Ajim" style="width: 100%; height: 100%; object-fit: cover;">
                <span class="c-card__badge-tag">Authentique Pêcheurs</span>
                <span class="c-card__badge-rating">★ 4.8</span>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-size: 0.8rem; color: var(--clr-sea-600); font-weight: 700; text-transform: uppercase;">Ajim & El Melga</div>
                <h3 class="heading-3" style="margin: 6px 0 10px; font-size: 1.3rem;">Bistrot de la Marine Ajim</h3>
                <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.25rem;">
                    Petite table authentique tenue par une famille de pêcheurs d'éponges. Poulpes grillés, soupe de poisson au cumin djerbien et terrasse sur le port.
                </p>
                <div style="display: flex; flex-direction: column; gap: 0.75rem; border-top: 1px solid var(--clr-sand-200); padding-top: 1rem;">
                    <div class="c-card__price-row">
                        <span class="c-card__price">Budget : <strong>18 € - 30 €</strong></span>
                        <a href="<?= url('/concierge') ?>" class="btn btn--gold c-card__btn-vip">Réserver via VIP</a>
                    </div>
                    <div class="c-card__icon-group" style="justify-content: flex-end;">
                        <button type="button" class="c-icon-btn c-icon-btn--booking" title="Voir sur Booking.com (Partenaire Officiel)" onclick="openBookingHotelsModal('Bistrot de la Marine Ajim', 'https://www.booking.com/city/tn/houmt-souk.html?aid=8073836')">
                            <i class="fi fi-rr-hotel"></i>
                        </button>
                        <button type="button" class="c-icon-btn c-icon-btn--whatsapp" title="Partager sur WhatsApp" onclick="shareOnWhatsApp('Bistrot de la Marine Ajim')">
                            <i class="fi fi-rr-paper-plane"></i>
                        </button>
                        <button type="button" class="c-icon-btn c-icon-btn--copy" title="Copier le lien" onclick="copyCardLink('Bistrot de la Marine Ajim', '', this)">
                            <i class="fi fi-rr-copy"></i>
                        </button>
                        <button type="button" class="c-icon-btn c-icon-btn--pdf" title="Fiche PDF Souvenir" onclick="openPdfModalForCard('Bistrot de la Marine Ajim')">
                            <i class="fi fi-rr-file-pdf"></i>
                        </button>
                    </div>
                </div>
            </div>
        </article>

    </div>
</div>

<script>
function filterHotelsRestos(type, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.resto-item').forEach(item => {
        if (type === 'all' || item.dataset.type === type) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}
</script>
