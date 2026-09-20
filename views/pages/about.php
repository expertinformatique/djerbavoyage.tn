<section class="c-hero" style="padding:4rem 0;">
  <div class="l-container" data-animate>
    <div class="c-hero__badge">
      <i class="fi fi-rr-heart" style="color:#E07A5F;"></i> <?= __('about.hero_badge') ?>
    </div>
    <h1 class="c-hero__title"><?= __('about.hero_title') ?></h1>
    <p class="c-hero__subtitle">
      <?= __('about.hero_subtitle') ?>
    </p>
  </div>
</section>

<div class="l-container" style="margin:4rem auto;">
  <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:3rem; align-items:center; margin-bottom:4rem;">
    <div data-animate>
      <span style="color:var(--clr-sea-600); font-weight:700; text-transform:uppercase; letter-spacing:1px; font-size:0.85rem;"><?= __('about.story_badge') ?></span>
      <h2 style="font-family:var(--font-heading); font-size:2.2rem; margin:0.5rem 0 1.5rem 0; color:var(--clr-dark-900);">
        <?= __('about.story_title') ?>
      </h2>
      <p style="color:var(--clr-gray-500); line-height:1.8; margin-bottom:1rem;">
        <?= __('about.story_p1') ?>
      </p>
      <p style="color:var(--clr-gray-500); line-height:1.8;">
        <?= __('about.story_p2') ?>
      </p>
    </div>
    <div data-animate>
      <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80" alt="Djerba Architecture" style="border-radius:var(--radius-card); box-shadow:var(--shadow-hover);">
    </div>
  </div>

  <div style="background:var(--clr-sand-200); border-radius:var(--radius-card); padding:3rem; margin:4rem 0; text-align:center;">
    <h2 style="font-family:var(--font-heading); margin-bottom:2rem;"><?= __('about.numbers_title') ?></h2>
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:2rem;">
      <div>
        <h3 style="font-size:2.8rem; font-family:var(--font-heading); color:var(--clr-sea-600);">+450</h3>
        <p style="color:var(--clr-gray-500); font-weight:600;"><?= __('about.stat_travelers') ?></p>
      </div>
      <div>
        <h3 style="font-size:2.8rem; font-family:var(--font-heading); color:var(--clr-terracotta-500);">100%</h3>
        <p style="color:var(--clr-gray-500); font-weight:600;"><?= __('about.stat_independent') ?></p>
      </div>
      <div>
        <h3 style="font-size:2.8rem; font-family:var(--font-heading); color:var(--clr-sea-900);">4.9 / 5</h3>
        <p style="color:var(--clr-gray-500); font-weight:600;"><?= __('about.stat_satisfaction') ?></p>
      </div>
    </div>
  </div>
</div>
