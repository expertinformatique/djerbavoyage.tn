<div class="container section">
    <div class="section-title text-center">
        <span class="badge badge--gold">Planning Clé en Main</span>
        <h1 class="heading-1">Itinéraires Sur-Mesure à Djerba</h1>
        <p class="text-muted" style="max-width: 650px; margin: 10px auto;">Optimisez chaque instant de vos vacances grâce à nos circuits élaborés par des résidents et passionnés de l'île.</p>
    </div>

    <div style="max-width: 900px; margin: 40px auto;">
        <!-- Tabs -->
        <div class="tabs" style="justify-content: center; margin-bottom: 30px;">
            <button class="tab-btn active" onclick="switchItinerary('it-3')">3 Jours (Week-end Express)</button>
            <button class="tab-btn" onclick="switchItinerary('it-5')">5 Jours (Équilibre Parfait)</button>
            <button class="tab-btn" onclick="switchItinerary('it-7')">7 Jours (Immersion Totale)</button>
        </div>

        <!-- 3 Days Itinerary -->
        <div id="it-3" class="itinerary-content card" style="display: block;">
            <h2 class="heading-2" style="color: var(--color-gold); margin-bottom: 20px;">🌴 Circuit 3 Jours : L'Essentiel de Djerba</h2>
            
            <div style="border-left: 2px solid var(--color-gold); padding-left: 20px; margin-bottom: 25px;">
                <h3 class="heading-3">Jour 1 : Houmt Souk & Traditions</h3>
                <p class="text-muted" style="margin-top: 5px;">Matinée exploration des souks (épices, poteries, bijoux en argent). Déjeuner au Fondouk El Attarine. Après-midi visite du Fort Ghazi Moustapha et promenade sur la marina.</p>
            </div>

            <div style="border-left: 2px solid var(--color-gold); padding-left: 20px; margin-bottom: 25px;">
                <h3 class="heading-3">Jour 2 : Street Art à Djerbahood & Synagogue de la Ghriba</h3>
                <p class="text-muted" style="margin-top: 5px;">Matinée magique à Erriadh pour contempler les fresques de Djerbahood. Déjeuner couscous au poisson traditionnel. Visite de la plus ancienne synagogue d'Afrique (La Ghriba).</p>
            </div>

            <div style="border-left: 2px solid var(--color-gold); padding-left: 20px;">
                <h3 class="heading-3">Jour 3 : Détente à Sidi Mahres & Coucher de soleil à Guellala</h3>
                <p class="text-muted" style="margin-top: 5px;">Matinée baignade et relaxation sur les sables fins de Sidi Mahres. Fin d'après-midi au musée de Guellala suivi du plus beau coucher de soleil sur le golfe de Boughrara.</p>
            </div>
        </div>

        <!-- 5 Days Itinerary -->
        <div id="it-5" class="itinerary-content card" style="display: none;">
            <h2 class="heading-2" style="color: var(--color-gold); margin-bottom: 20px;">⛵ Circuit 5 Jours : Culture & Évasion Marine</h2>
            
            <div style="border-left: 2px solid var(--color-gold); padding-left: 20px; margin-bottom: 25px;">
                <h3 class="heading-3">Jours 1 & 2 : Houmt Souk & Djerbahood</h3>
                <p class="text-muted" style="margin-top: 5px;">Découverte culturelle approfondie, marché au poisson d'Houmt Souk avec criée traditionnelle, et musée du patrimoine d'Erriadh.</p>
            </div>

            <div style="border-left: 2px solid var(--color-gold); padding-left: 20px; margin-bottom: 25px;">
                <h3 class="heading-3">Jour 3 : Excursion Île aux Flamants Roses (Ras Rmel)</h3>
                <p class="text-muted" style="margin-top: 5px;">Traversée en bateau bois pittoresque, observation de la faune sauvage, baignade turquoise et festin sous paillote.</p>
            </div>

            <div style="border-left: 2px solid var(--color-gold); padding-left: 20px; margin-bottom: 25px;">
                <h3 class="heading-3">Jour 4 : Sports Nautiques & Hammam Éco-Ryad</h3>
                <p class="text-muted" style="margin-top: 5px;">Initiation Kitesurf ou Stand-Up Paddle à Aghir. En soirée, rituel de bien-être oriental dans un hammam traditionnel au savon noir.</p>
            </div>

            <div style="border-left: 2px solid var(--color-gold); padding-left: 20px;">
                <h3 class="heading-3">Jour 5 : Marché de Midoun & Souvenirs Artisanaux</h3>
                <p class="text-muted" style="margin-top: 5px;">Visite du marché animé de Midoun, dégustation d'huile d'olive fraîche djerbienne et emplettes artisanales.</p>
            </div>
        </div>

        <!-- 7 Days Itinerary -->
        <div id="it-7" class="itinerary-content card" style="display: none;">
            <h2 class="heading-2" style="color: var(--color-gold); margin-bottom: 20px;">👑 Circuit 7 Jours : L'Expérience VIP Globale</h2>
            <p class="text-muted" style="margin-bottom: 20px;">Un séjour complet incluant les joyaux cachés de Djerba + une journée d'escapade désertique dans le Sud Tunisien (Ksar Ghilane / Matmata).</p>

            <div style="border-left: 2px solid var(--color-gold); padding-left: 20px; margin-bottom: 20px;">
                <h3 class="heading-3">Jours 1 à 4 : L'Île aux Rêves</h3>
                <p class="text-muted">Circuit complet Houmt Souk, Djerbahood, Guellala, Sidi Mahres et dîner astronomique sous la voûte djerbienne.</p>
            </div>

            <div style="border-left: 2px solid var(--color-gold); padding-left: 20px; margin-bottom: 20px;">
                <h3 class="heading-3">Jour 5 : Incursion Porte du Désert (Ksar Ghilane)</h3>
                <p class="text-muted">Passage de la Chaussée Romaine vers le continent, baignade dans la source chaude du désert et nuitée en campement berbère de luxe.</p>
            </div>

            <div style="border-left: 2px solid var(--color-gold); padding-left: 20px;">
                <h3 class="heading-3">Jours 6 & 7 : Matmata Troglodyte & Retour Serein</h3>
                <p class="text-muted">Visite des maisons troglodytes de Matmata (décors Star Wars), retour à Djerba pour une dernière journée détente spa & fruits de mer.</p>
            </div>
        </div>

        <div class="text-center" style="margin-top: 40px;">
            <a href="<?= asset('shop') ?>" class="btn btn--gold">Télécharger le Pack Complet PDF (7,90 €)</a>
        </div>
    </div>
</div>

<script>
function switchItinerary(id) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    document.querySelectorAll('.itinerary-content').forEach(content => {
        content.style.display = 'none';
    });
    document.getElementById(id).style.display = 'block';
}
</script>
