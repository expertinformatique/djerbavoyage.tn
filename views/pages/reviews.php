<div class="container section">
    <div class="section-title text-center">
        <span class="badge badge--gold"><?= __('reviews.badge') ?></span>
        <h1 class="heading-1"><?= __('reviews.title') ?></h1>
        <p class="text-muted" style="max-width: 600px; margin: 10px auto;"><?= __('reviews.subtitle') ?></p>
    </div>

    <!-- Rating Summary Bar -->
    <div class="card" style="max-width: 850px; margin: 30px auto; padding: 30px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
        <div style="text-align: center; border-right: 1px solid rgba(255,255,255,0.1); padding-right: 30px;">
            <div style="font-size: 3.5rem; font-weight: 800; color: var(--color-gold); line-height: 1;">4.9</div>
            <div style="color: var(--color-gold); margin: 5px 0;">★★★★★</div>
            <div class="text-muted" style="font-size: 0.9rem;"><?= __('reviews.based_on') ?></div>
        </div>

        <div style="flex: 1; min-width: 250px;">
            <div style="display: flex; align-items: center; margin-bottom: 8px;">
                <span style="width: 60px; font-size: 0.85rem;"><?= __('reviews.stars_5') ?></span>
                <div style="flex: 1; height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px; margin: 0 10px; overflow: hidden;">
                    <div style="width: 92%; height: 100%; background: var(--color-gold);"></div>
                </div>
                <span style="font-size: 0.85rem; color: var(--color-muted);">92%</span>
            </div>
            <div style="display: flex; align-items: center; margin-bottom: 8px;">
                <span style="width: 60px; font-size: 0.85rem;"><?= __('reviews.stars_4') ?></span>
                <div style="flex: 1; height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px; margin: 0 10px; overflow: hidden;">
                    <div style="width: 6%; height: 100%; background: var(--color-gold);"></div>
                </div>
                <span style="font-size: 0.85rem; color: var(--color-muted);">6%</span>
            </div>
            <div style="display: flex; align-items: center;">
                <span style="width: 60px; font-size: 0.85rem;"><?= __('reviews.stars_3') ?></span>
                <div style="flex: 1; height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px; margin: 0 10px; overflow: hidden;">
                    <div style="width: 2%; height: 100%; background: var(--color-gold);"></div>
                </div>
                <span style="font-size: 0.85rem; color: var(--color-muted);">2%</span>
            </div>
        </div>
    </div>

    <!-- Reviews Grid -->
    <div class="grid grid-3" style="gap: 25px; max-width: 1100px; margin: 40px auto 0;">
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <div>
                    <h4 class="heading-3" style="margin: 0;"><?= __('reviews.r1_author') ?></h4>
                    <span style="font-size: 0.8rem; color: var(--color-muted);"><?= __('reviews.r1_meta') ?></span>
                </div>
                <span style="color: var(--color-gold);">★★★★★</span>
            </div>
            <p class="text-muted" style="font-size: 0.95rem; font-style: italic;"><?= __('reviews.r1_text') ?></p>
        </div>

        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <div>
                    <h4 class="heading-3" style="margin: 0;"><?= __('reviews.r2_author') ?></h4>
                    <span style="font-size: 0.8rem; color: var(--color-muted);"><?= __('reviews.r2_meta') ?></span>
                </div>
                <span style="color: var(--color-gold);">★★★★★</span>
            </div>
            <p class="text-muted" style="font-size: 0.95rem; font-style: italic;"><?= __('reviews.r2_text') ?></p>
        </div>

        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <div>
                    <h4 class="heading-3" style="margin: 0;"><?= __('reviews.r3_author') ?></h4>
                    <span style="font-size: 0.8rem; color: var(--color-muted);"><?= __('reviews.r3_meta') ?></span>
                </div>
                <span style="color: var(--color-gold);">★★★★★</span>
            </div>
            <p class="text-muted" style="font-size: 0.95rem; font-style: italic;"><?= __('reviews.r3_text') ?></p>
        </div>
    </div>
</div>
