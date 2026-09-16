<div class="container section">
    <div class="section-title text-center">
        <span class="badge badge--gold">Support & Informations</span>
        <h1 class="heading-1">Foire Aux Questions (FAQ)</h1>
        <p class="text-muted" style="max-width: 600px; margin: 10px auto;">Retrouvez toutes les réponses essentielles pour préparer votre séjour de rêve à Djerba.</p>
    </div>

    <div style="max-width: 850px; margin: 40px auto;">
        <!-- Categories Tabs -->
        <div class="tabs" style="justify-content: center; margin-bottom: 30px;">
            <button class="tab-btn active" onclick="filterFaq('all')">Toutes les questions</button>
            <button class="tab-btn" onclick="filterFaq('stay')">Séjour & Climat</button>
            <button class="tab-btn" onclick="filterFaq('guides')">Guides PDF</button>
            <button class="tab-btn" onclick="filterFaq('concierge')">Conciergerie VIP</button>
        </div>

        <div class="faq-list">
            <!-- Item 1 -->
            <div class="card faq-item" data-category="stay" style="margin-bottom: 15px; border-left: 4px solid var(--color-gold);">
                <h3 class="heading-3" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center; margin: 0;" onclick="toggleFaq(this)">
                    <span>☀️ Quelle est la meilleure période pour visiter Djerba ?</span>
                    <span style="font-size: 1.2rem;">+</span>
                </h3>
                <div class="faq-answer" style="display: none; padding-top: 15px; border-top: 1fr solid rgba(255,255,255,0.05); margin-top: 15px;">
                    <p class="text-muted">Djerba jouit de plus de 300 jours de soleil par an ! La période optimale se situe d'Avril à Novembre avec une mer chaude (25°C à 29°C) et un climat très agréable. Le printemps et l'automne offerent le parfait compromis entre douceur et tranquillité.</p>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="card faq-item" data-category="guides" style="margin-bottom: 15px; border-left: 4px solid var(--color-gold);">
                <h3 class="heading-3" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center; margin: 0;" onclick="toggleFaq(this)">
                    <span>📄 Comment puis-je télécharger mes guides PDF après achat ?</span>
                    <span style="font-size: 1.2rem;">+</span>
                </h3>
                <div class="faq-answer" style="display: none; padding-top: 15px; border-top: 1fr solid rgba(255,255,255,0.05); margin-top: 15px;">
                    <p class="text-muted">Dès la validation de votre paiement sécurisé via Stripe, vous êtes automatiquement redirigé vers une page de téléchargement instantané. De plus, un e-mail sécurisé contenant votre lien de téléchargement unique vous est immédiatement envoyé.</p>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="card faq-item" data-category="concierge" style="margin-bottom: 15px; border-left: 4px solid var(--color-gold);">
                <h3 class="heading-3" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center; margin: 0;" onclick="toggleFaq(this)">
                    <span>💎 En quoi consiste le service Conciergerie Sur-Mesure ?</span>
                    <span style="font-size: 1.2rem;">+</span>
                </h3>
                <div class="faq-answer" style="display: none; padding-top: 15px; border-top: 1fr solid rgba(255,255,255,0.05); margin-top: 15px;">
                    <p class="text-muted">Notre service Conciergerie (29,00 €) vous donne accès direct à un expert local dédié sur WhatsApp pendant tout votre séjour. Nous nous occupons de vos réservations de quads, bateaux privatifs, tables secrètes, transferts aéroport VIP et demandes spéciales.</p>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="card faq-item" data-category="stay" style="margin-bottom: 15px; border-left: 4px solid var(--color-gold);">
                <h3 class="heading-3" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center; margin: 0;" onclick="toggleFaq(this)">
                    <span>🚗 Comment se déplacer à Djerba de façon sécurisée ?</span>
                    <span style="font-size: 1.2rem;">+</span>
                </h3>
                <div class="faq-answer" style="display: none; padding-top: 15px; border-top: 1fr solid rgba(255,255,255,0.05); margin-top: 15px;">
                    <p class="text-muted">Les taxis jaunes sont très abordables et munis de compteurs. Vous pouvez aussi louer une voiture directement depuis l'aéroport DJE. Notre guide complet contient notre liste de loueurs partenaires locaux recommandés avec véhicules récents.</p>
                </div>
            </div>

            <!-- Item 5 -->
            <div class="card faq-item" data-category="guides" style="margin-bottom: 15px; border-left: 4px solid var(--color-gold);">
                <h3 class="heading-3" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center; margin: 0;" onclick="toggleFaq(this)">
                    <span>🔒 Les paiements sont-ils sécurisés ?</span>
                    <span style="font-size: 1.2rem;">+</span>
                </h3>
                <div class="faq-answer" style="display: none; padding-top: 15px; border-top: 1fr solid rgba(255,255,255,0.05); margin-top: 15px;">
                    <p class="text-muted">Absolument. Toutes les transactions bancaires sont cryptées et gérées par Stripe, le leader mondial du paiement en ligne. Aucune donnée bancaire n'est stockée sur nos serveurs.</p>
                </div>
            </div>
        </div>

        <div class="card text-center" style="margin-top: 40px; background: linear-gradient(135deg, rgba(212,175,55,0.1) 0%, rgba(212,175,55,0.02) 100%); border: 1px solid rgba(212,175,55,0.3);">
            <h3 class="heading-3">Vous ne trouvez pas réponse à votre question ?</h3>
            <p class="text-muted" style="margin: 10px 0 20px;">Notre équipe d'assistance est joignable 7j/7 pour vous aider.</p>
            <a href="<?= url('/contact') ?>" class="btn btn--gold">Écrire au Support</a>
        </div>
    </div>
</div>

<script>
function toggleFaq(element) {
    const answer = element.nextElementSibling;
    const icon = element.querySelector('span:last-child');
    if (answer.style.display === 'none' || !answer.style.display) {
        answer.style.display = 'block';
        icon.textContent = '−';
    } else {
        answer.style.display = 'none';
        icon.textContent = '+';
    }
}

function filterFaq(cat) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    document.querySelectorAll('.faq-item').forEach(item => {
        if (cat === 'all' || item.dataset.category === cat) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}
</script>
