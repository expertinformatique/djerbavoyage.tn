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
    <div class="l-grid-cards" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem;">
        
        <!-- Hotel 1 -->
        <article class="c-card resto-item" data-type="hotel" style="background: #fff; border-radius: 20px; overflow: hidden; border: 1px solid var(--clr-sand-300);">
            <div style="height: 220px; position: relative;">
                <img src="<?= asset('images/concierge.png') ?>" alt="Dar Dhiafa Erriadh" style="width: 100%; height: 100%; object-fit: cover;">
                <span style="position: absolute; top: 12px; left: 12px; background: rgba(15,23,42,0.8); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Menzel de Charme</span>
                <span style="position: absolute; top: 12px; right: 12px; background: var(--clr-terracotta-500); color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: 700;">★ 4.9</span>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-size: 0.8rem; color: var(--clr-sea-600); font-weight: 700; text-transform: uppercase;">Erriadh (Djerbahood)</div>
                <h3 class="heading-3" style="margin: 6px 0 10px; font-size: 1.3rem;">Dar Dhiafa - Les Maisons du Houss</h3>
                <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.25rem;">
                    Véritable bijou d'architecture djerbienne niché au cœur d'Erriadh. Cours intérieures avec palmiers, deux piscines d'eau tiède et suites décorées d'objets d'artisanat.
                </p>
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--clr-sand-200); padding-top: 1rem;">
                    <span style="font-weight: 800; font-size: 1.2rem; color: var(--clr-sea-900);">À partir de 110 € <span style="font-size: 0.8rem; font-weight: normal;">/ nuit</span></span>
                    <a href="<?= url('/concierge') ?>" class="btn btn--gold" style="padding: 6px 14px; font-size: 0.85rem;">Réserver via VIP</a>
                </div>
            </div>
        </article>

        <!-- Hotel 2 -->
        <article class="c-card resto-item" data-type="hotel" style="background: #fff; border-radius: 20px; overflow: hidden; border: 1px solid var(--clr-sand-300);">
            <div style="height: 220px; position: relative;">
                <img src="<?= asset('images/sidi_mahres.png') ?>" alt="Radisson Blu Palace Djerba" style="width: 100%; height: 100%; object-fit: cover;">
                <span style="position: absolute; top: 12px; left: 12px; background: rgba(15,23,42,0.8); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Resort & Thalasso 5★</span>
                <span style="position: absolute; top: 12px; right: 12px; background: var(--clr-terracotta-500); color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: 700;">★ 4.8</span>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-size: 0.8rem; color: var(--clr-sea-600); font-weight: 700; text-transform: uppercase;">Sidi Mahres Beach</div>
                <h3 class="heading-3" style="margin: 6px 0 10px; font-size: 1.3rem;">Radisson Blu Palace Thalasso</h3>
                <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.25rem;">
                    Espaces somptueux situés directement sur la plage de sable blanc. Centre de thalassothérapie Athénée Thalasso de renommée internationale.
                </p>
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--clr-sand-200); padding-top: 1rem;">
                    <span style="font-weight: 800; font-size: 1.2rem; color: var(--clr-sea-900);">À partir de 145 € <span style="font-size: 0.8rem; font-weight: normal;">/ nuit</span></span>
                    <a href="<?= url('/concierge') ?>" class="btn btn--gold" style="padding: 6px 14px; font-size: 0.85rem;">Réserver via VIP</a>
                </div>
            </div>
        </article>

        <!-- Restaurant 1 -->
        <article class="c-card resto-item" data-type="resto" style="background: #fff; border-radius: 20px; overflow: hidden; border: 1px solid var(--clr-sand-300);">
            <div style="height: 220px; position: relative;">
                <img src="<?= asset('images/houmt_souk.png') ?>" alt="El Fondouk Restaurant" style="width: 100%; height: 100%; object-fit: cover;">
                <span style="position: absolute; top: 12px; left: 12px; background: rgba(15,23,42,0.8); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Gastronomie Traditionnelle</span>
                <span style="position: absolute; top: 12px; right: 12px; background: var(--clr-terracotta-500); color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: 700;">★ 5.0</span>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-size: 0.8rem; color: var(--clr-sea-600); font-weight: 700; text-transform: uppercase;">Houmt Souk (Fondouk)</div>
                <h3 class="heading-3" style="margin: 6px 0 10px; font-size: 1.3rem;">Restaurant El Fondouk</h3>
                <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.25rem;">
                    Niché dans un caravanserail du XVIIIe siècle magnifiquement restauré. Dégustez le fameux couscous au mérou et les briques djerbiennes sous les arcades.
                </p>
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--clr-sand-200); padding-top: 1rem;">
                    <span style="font-weight: 800; font-size: 1.1rem; color: var(--clr-sea-900);">Budget : 25 € - 45 €</span>
                    <a href="<?= url('/concierge') ?>" class="btn btn--gold" style="padding: 6px 14px; font-size: 0.85rem;">Réserver une Table</a>
                </div>
            </div>
        </article>

        <!-- Restaurant 2 -->
        <article class="c-card resto-item" data-type="resto" style="background: #fff; border-radius: 20px; overflow: hidden; border: 1px solid var(--clr-sand-300);">
            <div style="height: 220px; position: relative;">
                <img src="<?= asset('images/hero.png') ?>" alt="Restaurant Haroun" style="width: 100%; height: 100%; object-fit: cover;">
                <span style="position: absolute; top: 12px; left: 12px; background: rgba(15,23,42,0.8); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Fruits de Mer & Marina</span>
                <span style="position: absolute; top: 12px; right: 12px; background: var(--clr-terracotta-500); color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: 700;">★ 4.9</span>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-size: 0.8rem; color: var(--clr-sea-600); font-weight: 700; text-transform: uppercase;">Marina d'Houmt Souk</div>
                <h3 class="heading-3" style="margin: 6px 0 10px; font-size: 1.3rem;">Le Haroun - Table du Port</h3>
                <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.25rem;">
                    Installé directement au bord des bateaux de pêche. Spécialités de crevettes royales grillées, calamars farcis et poissons sauvages fraîchement pechés.
                </p>
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--clr-sand-200); padding-top: 1rem;">
                    <span style="font-weight: 800; font-size: 1.1rem; color: var(--clr-sea-900);">Budget : 30 € - 55 €</span>
                    <a href="<?= url('/concierge') ?>" class="btn btn--gold" style="padding: 6px 14px; font-size: 0.85rem;">Réserver une Table</a>
                </div>
            </div>
        </article>

        <!-- Hotel 3: Guellala & Ajim -->
        <article class="c-card resto-item" data-type="hotel" style="background: #fff; border-radius: 20px; overflow: hidden; border: 1px solid var(--clr-sand-300);">
            <div style="height: 220px; position: relative;">
                <img src="<?= asset('images/guellala.png') ?>" alt="Menzel Guellala Sunset" style="width: 100%; height: 100%; object-fit: cover;">
                <span style="position: absolute; top: 12px; left: 12px; background: rgba(15,23,42,0.8); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Ecolodge & Sunset</span>
                <span style="position: absolute; top: 12px; right: 12px; background: var(--clr-terracotta-500); color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: 700;">★ 4.9</span>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-size: 0.8rem; color: var(--clr-sea-600); font-weight: 700; text-transform: uppercase;">Guellala (Village Potiers)</div>
                <h3 class="heading-3" style="margin: 6px 0 10px; font-size: 1.3rem;">Menzel Guellala & Terres Rouges</h3>
                <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.25rem;">
                    Menzel éco-responsable dominant les collines de potiers avec vue imprenable sur les couchers de soleil du Golfe de Boughrara.
                </p>
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--clr-sand-200); padding-top: 1rem;">
                    <span style="font-weight: 800; font-size: 1.2rem; color: var(--clr-sea-900);">À partir de 85 € <span style="font-size: 0.8rem; font-weight: normal;">/ nuit</span></span>
                    <a href="<?= url('/concierge') ?>" class="btn btn--gold" style="padding: 6px 14px; font-size: 0.85rem;">Réserver via VIP</a>
                </div>
            </div>
        </article>

        <!-- Restaurant 3: Ajim Port -->
        <article class="c-card resto-item" data-type="resto" style="background: #fff; border-radius: 20px; overflow: hidden; border: 1px solid var(--clr-sand-300);">
            <div style="height: 220px; position: relative;">
                <img src="<?= asset('images/ajim.png') ?>" alt="Le Pêcheur Ajim" style="width: 100%; height: 100%; object-fit: cover;">
                <span style="position: absolute; top: 12px; left: 12px; background: rgba(15,23,42,0.8); color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Authentique Pêcheurs</span>
                <span style="position: absolute; top: 12px; right: 12px; background: var(--clr-terracotta-500); color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: 700;">★ 4.8</span>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-size: 0.8rem; color: var(--clr-sea-600); font-weight: 700; text-transform: uppercase;">Ajim & El Melga</div>
                <h3 class="heading-3" style="margin: 6px 0 10px; font-size: 1.3rem;">Bistrot de la Marine Ajim</h3>
                <p class="text-muted" style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.25rem;">
                    Petite table authentique tenue par une famille de pêcheurs d'éponges. Poulpes grillés, soupe de poisson au cumin djerbien et terrasse sur le port.
                </p>
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--clr-sand-200); padding-top: 1rem;">
                    <span style="font-weight: 800; font-size: 1.1rem; color: var(--clr-sea-900);">Budget : 18 € - 30 €</span>
                    <a href="<?= url('/concierge') ?>" class="btn btn--gold" style="padding: 6px 14px; font-size: 0.85rem;">Réserver une Table</a>
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
