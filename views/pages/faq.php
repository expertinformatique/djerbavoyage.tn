<div class="container section">
    <div class="section-title text-center">
        <span class="badge badge--gold"><?= __('faq.badge') ?></span>
        <h1 class="heading-1"><?= __('faq.title') ?></h1>
        <p class="text-muted" style="max-width: 600px; margin: 10px auto;"><?= __('faq.subtitle') ?></p>
    </div>

    <div style="max-width: 850px; margin: 40px auto;">
        <!-- Categories Tabs -->
        <div class="tabs" style="justify-content: center; margin-bottom: 30px;">
            <button class="tab-btn active" onclick="filterFaq('all')"><?= __('faq.tab_all') ?></button>
            <button class="tab-btn" onclick="filterFaq('stay')"><?= __('faq.tab_stay') ?></button>
            <button class="tab-btn" onclick="filterFaq('guides')"><?= __('faq.tab_guides') ?></button>
            <button class="tab-btn" onclick="filterFaq('concierge')"><?= __('faq.tab_concierge') ?></button>
        </div>

        <div class="faq-list">
            <!-- Item 1 -->
            <div class="card faq-item" data-category="stay" style="margin-bottom: 15px; border-left: 4px solid var(--color-gold);">
                <h3 class="heading-3" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center; margin: 0;" onclick="toggleFaq(this)">
                    <span><?= __('faq.q1') ?></span>
                    <span style="font-size: 1.2rem;">+</span>
                </h3>
                <div class="faq-answer" style="display: none; padding-top: 15px; border-top: 1fr solid rgba(255,255,255,0.05); margin-top: 15px;">
                    <p class="text-muted"><?= __('faq.a1') ?></p>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="card faq-item" data-category="guides" style="margin-bottom: 15px; border-left: 4px solid var(--color-gold);">
                <h3 class="heading-3" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center; margin: 0;" onclick="toggleFaq(this)">
                    <span><?= __('faq.q2') ?></span>
                    <span style="font-size: 1.2rem;">+</span>
                </h3>
                <div class="faq-answer" style="display: none; padding-top: 15px; border-top: 1fr solid rgba(255,255,255,0.05); margin-top: 15px;">
                    <p class="text-muted"><?= __('faq.a2') ?></p>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="card faq-item" data-category="concierge" style="margin-bottom: 15px; border-left: 4px solid var(--color-gold);">
                <h3 class="heading-3" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center; margin: 0;" onclick="toggleFaq(this)">
                    <span><?= __('faq.q3') ?></span>
                    <span style="font-size: 1.2rem;">+</span>
                </h3>
                <div class="faq-answer" style="display: none; padding-top: 15px; border-top: 1fr solid rgba(255,255,255,0.05); margin-top: 15px;">
                    <p class="text-muted"><?= __('faq.a3') ?></p>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="card faq-item" data-category="stay" style="margin-bottom: 15px; border-left: 4px solid var(--color-gold);">
                <h3 class="heading-3" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center; margin: 0;" onclick="toggleFaq(this)">
                    <span><?= __('faq.q4') ?></span>
                    <span style="font-size: 1.2rem;">+</span>
                </h3>
                <div class="faq-answer" style="display: none; padding-top: 15px; border-top: 1fr solid rgba(255,255,255,0.05); margin-top: 15px;">
                    <p class="text-muted"><?= __('faq.a4') ?></p>
                </div>
            </div>

            <!-- Item 5 -->
            <div class="card faq-item" data-category="guides" style="margin-bottom: 15px; border-left: 4px solid var(--color-gold);">
                <h3 class="heading-3" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center; margin: 0;" onclick="toggleFaq(this)">
                    <span><?= __('faq.q5') ?></span>
                    <span style="font-size: 1.2rem;">+</span>
                </h3>
                <div class="faq-answer" style="display: none; padding-top: 15px; border-top: 1fr solid rgba(255,255,255,0.05); margin-top: 15px;">
                    <p class="text-muted"><?= __('faq.a5') ?></p>
                </div>
            </div>
        </div>

        <div class="card text-center" style="margin-top: 40px; background: linear-gradient(135deg, rgba(212,175,55,0.1) 0%, rgba(212,175,55,0.02) 100%); border: 1px solid rgba(212,175,55,0.3);">
            <h3 class="heading-3"><?= __('faq.help_title') ?></h3>
            <p class="text-muted" style="margin: 10px 0 20px;"><?= __('faq.help_desc') ?></p>
            <a href="<?= url('/contact') ?>" class="btn btn--gold"><?= __('faq.help_btn') ?></a>
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
