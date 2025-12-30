# Phase 4: Component Enhancement

**Parent**: [plan.md](./plan.md)
**Status**: Pending
**Priority**: High
**Estimated**: 10 hours
**Depends On**: Phase 1, Phase 3

---

## Context

Current universal components (Card, Hero, CTA, Stats, Testimonial) use dark theme styling. Harrison.ai requires clean healthcare variants with refined visual treatment.

### Current Component Inventory
| Component | Location | Variants | Status |
|-----------|----------|----------|--------|
| Card | `components/card/card-base.php` | glass, solid, outlined, image, icon, solution, blog | Needs light variants |
| Hero | `components/hero/hero-universal.php` | homepage, page, pillar, minimal | Adding healthcare |
| CTA | `components/cta/cta-block.php` | form, button, banner, inline | Needs light variants |
| Stats | `components/stats/stats-counter.php` | default | Needs healthcare variant |
| Testimonial | `components/testimonial/testimonial-carousel.php` | carousel | Needs healthcare variant |

### Harrison.ai Component Needs
- **Card**: Clean white cards with subtle shadows
- **CTA**: Green "Book a Demo" button prominent
- **Stats**: Minimal counters on light background
- **Testimonial**: Quote cards with profile images

---

## Overview

Enhance existing components with healthcare variants and light theme support. Add new component variants where needed. Maintain backward compatibility.

---

## Key Insights

1. **Variant-Based** - Add `healthcare` variant to existing components
2. **Light Theme Native** - New variants designed for light backgrounds
3. **CTA Focus** - Green (#059669) CTA buttons for conversions
4. **Subtle Animations** - Refined hover states, less dramatic
5. **Profile Integration** - Testimonials with author photos

---

## Requirements

### Functional
- [ ] Card: Add `healthcare` variant with clean styling
- [ ] CTA: Add `healthcare` variant with green button
- [ ] Stats: Add `healthcare` variant with minimal styling
- [ ] Testimonial: Add `healthcare` variant with photos
- [ ] All: Light theme compatibility

### Non-Functional
- [ ] No JavaScript changes for variants
- [ ] CSS-only variant switching
- [ ] < 10KB CSS addition per component

---

## Architecture

### Component Variant Matrix
```
Card Variants:
  - glass (existing, dark)
  - solid (existing, dark)
  - healthcare (new, light)
  - healthcare-featured (new, light + emphasis)

CTA Variants:
  - button (existing)
  - banner (existing)
  - healthcare (new, green button)
  - healthcare-inline (new, inline with form)

Stats Variants:
  - default (existing, dark)
  - healthcare (new, light, minimal)

Testimonial Variants:
  - carousel (existing)
  - healthcare (new, photo cards)
```

---

## Implementation Steps

### Step 1: Card Healthcare Variant (2h)
Update `components/card/card-base.php`:

```php
case 'healthcare':
case 'healthcare-featured':
    $output .= '<div class="aitsc-card__body">';

    // Title
    $output .= sprintf(
        '<h3 class="aitsc-card__title">%s</h3>',
        $title
    );

    // Description
    if (!empty($description)) {
        $output .= sprintf(
            '<p class="aitsc-card__description">%s</p>',
            $description
        );
    }

    // CTA with arrow
    if (!empty($link) && !empty($cta_text)) {
        $output .= sprintf(
            '<span class="aitsc-card__cta aitsc-card__cta--arrow">
                %s
                <span class="material-symbols-outlined">arrow_forward</span>
            </span>',
            $cta_text
        );
    }

    $output .= '</div>';
    break;
```

Add to `components/card/card-variants.css`:

```css
/* Healthcare Card Variant */
.aitsc-card--healthcare {
    background: var(--hai-bg-primary);
    border: 1px solid var(--hai-border);
    border-radius: 12px;
    padding: 2rem;
    transition: all 0.3s ease;
}

.aitsc-card--healthcare:hover {
    border-color: var(--hai-brand-blue);
    box-shadow: var(--hai-shadow-md);
    transform: translateY(-4px);
}

.aitsc-card--healthcare .aitsc-card__title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--hai-text-primary);
    margin-bottom: 0.75rem;
}

.aitsc-card--healthcare .aitsc-card__description {
    font-size: 1rem;
    line-height: 1.6;
    color: var(--hai-text-secondary);
    margin-bottom: 1.5rem;
}

.aitsc-card--healthcare .aitsc-card__cta--arrow {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--hai-brand-blue);
    transition: gap 0.2s ease;
}

.aitsc-card--healthcare:hover .aitsc-card__cta--arrow {
    gap: 1rem;
}

/* Featured variant */
.aitsc-card--healthcare-featured {
    background: linear-gradient(135deg, var(--hai-bg-primary) 0%, var(--hai-bg-secondary) 100%);
    border: 2px solid var(--hai-brand-blue);
    padding: 2.5rem;
}

.aitsc-card--healthcare-featured::before {
    content: 'Featured';
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: var(--hai-brand-blue);
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.75rem;
    border-radius: 4px;
}
```

### Step 2: CTA Healthcare Variant (2h)
Update `components/cta/cta-block.php`:

```php
case 'healthcare':
case 'healthcare-inline':
    echo '<section class="aitsc-cta aitsc-cta--healthcare">';
    echo '<div class="aitsc-cta__container">';

    echo '<div class="aitsc-cta__content">';
    if (!empty($title)) {
        echo sprintf('<h2 class="aitsc-cta__title">%s</h2>', $title);
    }
    if (!empty($description)) {
        echo sprintf('<p class="aitsc-cta__description">%s</p>', $description);
    }
    echo '</div>';

    echo '<div class="aitsc-cta__action">';
    if (!empty($button_text) && !empty($button_link)) {
        echo sprintf(
            '<a href="%s" class="aitsc-cta__button aitsc-cta__button--healthcare">%s</a>',
            $button_link,
            $button_text
        );
    }
    echo '</div>';

    echo '</div>';
    echo '</section>';
    break;
```

Add to `components/cta/cta-styles.css`:

```css
/* Healthcare CTA */
.aitsc-cta--healthcare {
    background: var(--hai-bg-secondary);
    padding: 5rem 2rem;
}

.aitsc-cta--healthcare .aitsc-cta__container {
    max-width: 1000px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 3rem;
}

.aitsc-cta--healthcare .aitsc-cta__title {
    font-size: clamp(1.75rem, 3vw, 2.5rem);
    font-weight: 700;
    color: var(--hai-text-primary);
    margin-bottom: 0.5rem;
}

.aitsc-cta--healthcare .aitsc-cta__description {
    font-size: 1.125rem;
    color: var(--hai-text-secondary);
}

.aitsc-cta__button--healthcare {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--hai-brand-green);
    color: white;
    font-size: 1.125rem;
    font-weight: 600;
    padding: 1rem 2rem;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.aitsc-cta__button--healthcare:hover {
    background: #047857;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(5, 150, 105, 0.3);
}

/* Responsive */
@media (max-width: 767px) {
    .aitsc-cta--healthcare .aitsc-cta__container {
        flex-direction: column;
        text-align: center;
    }

    .aitsc-cta__button--healthcare {
        width: 100%;
        justify-content: center;
    }
}
```

### Step 3: Stats Healthcare Variant (2h)
Update `components/stats/stats-counter.php`:

```php
function aitsc_render_stats($stats = [], $variant = 'default') {
    if (empty($stats)) return;

    $variant_class = 'aitsc-stats--' . $variant;
    ?>
    <section class="aitsc-stats <?php echo esc_attr($variant_class); ?>">
        <div class="aitsc-stats__container">
            <div class="aitsc-stats__grid">
                <?php foreach ($stats as $stat): ?>
                    <div class="aitsc-stats__item">
                        <span class="aitsc-stats__value" data-target="<?php echo esc_attr($stat['value']); ?>">
                            <?php echo esc_html($stat['prefix'] ?? ''); ?>0<?php echo esc_html($stat['suffix'] ?? ''); ?>
                        </span>
                        <span class="aitsc-stats__label"><?php echo esc_html($stat['label']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}
```

Add to `components/stats/stats-styles.css`:

```css
/* Healthcare Stats */
.aitsc-stats--healthcare {
    background: var(--hai-bg-primary);
    padding: 5rem 2rem;
    border-top: 1px solid var(--hai-border);
    border-bottom: 1px solid var(--hai-border);
}

.aitsc-stats--healthcare .aitsc-stats__grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 3rem;
    max-width: 1000px;
    margin: 0 auto;
}

.aitsc-stats--healthcare .aitsc-stats__item {
    text-align: center;
}

.aitsc-stats--healthcare .aitsc-stats__value {
    display: block;
    font-size: clamp(2.5rem, 4vw, 4rem);
    font-weight: 700;
    color: var(--hai-brand-blue);
    line-height: 1;
    margin-bottom: 0.5rem;
}

.aitsc-stats--healthcare .aitsc-stats__label {
    font-size: 1rem;
    color: var(--hai-text-secondary);
}

@media (max-width: 767px) {
    .aitsc-stats--healthcare .aitsc-stats__grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }
}
```

### Step 4: Testimonial Healthcare Variant (2.5h)
Update `components/testimonial/testimonial-carousel.php`:

```php
function aitsc_render_testimonials($testimonials = [], $variant = 'default') {
    if (empty($testimonials)) return;

    $variant_class = 'aitsc-testimonials--' . $variant;
    ?>
    <section class="aitsc-testimonials <?php echo esc_attr($variant_class); ?>">
        <div class="aitsc-testimonials__container">
            <div class="aitsc-testimonials__grid">
                <?php foreach ($testimonials as $testimonial): ?>
                    <div class="aitsc-testimonials__card">
                        <blockquote class="aitsc-testimonials__quote">
                            <?php echo wp_kses_post($testimonial['quote']); ?>
                        </blockquote>
                        <div class="aitsc-testimonials__author">
                            <?php if (!empty($testimonial['photo'])): ?>
                                <img src="<?php echo esc_url($testimonial['photo']); ?>"
                                     alt="<?php echo esc_attr($testimonial['name']); ?>"
                                     class="aitsc-testimonials__photo">
                            <?php endif; ?>
                            <div class="aitsc-testimonials__info">
                                <span class="aitsc-testimonials__name"><?php echo esc_html($testimonial['name']); ?></span>
                                <span class="aitsc-testimonials__role"><?php echo esc_html($testimonial['role']); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}
```

Add to `components/testimonial/carousel-styles.css`:

```css
/* Healthcare Testimonials */
.aitsc-testimonials--healthcare {
    background: var(--hai-bg-secondary);
    padding: 6rem 2rem;
}

.aitsc-testimonials--healthcare .aitsc-testimonials__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.aitsc-testimonials--healthcare .aitsc-testimonials__card {
    background: var(--hai-bg-primary);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--hai-shadow-sm);
    transition: all 0.3s ease;
}

.aitsc-testimonials--healthcare .aitsc-testimonials__card:hover {
    box-shadow: var(--hai-shadow-md);
    transform: translateY(-4px);
}

.aitsc-testimonials--healthcare .aitsc-testimonials__quote {
    font-size: 1.125rem;
    line-height: 1.7;
    color: var(--hai-text-primary);
    margin-bottom: 1.5rem;
    position: relative;
    padding-left: 1.5rem;
    border-left: 3px solid var(--hai-brand-blue);
}

.aitsc-testimonials--healthcare .aitsc-testimonials__author {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.aitsc-testimonials--healthcare .aitsc-testimonials__photo {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
}

.aitsc-testimonials--healthcare .aitsc-testimonials__name {
    display: block;
    font-weight: 600;
    color: var(--hai-text-primary);
}

.aitsc-testimonials--healthcare .aitsc-testimonials__role {
    font-size: 0.875rem;
    color: var(--hai-text-secondary);
}

@media (max-width: 991px) {
    .aitsc-testimonials--healthcare .aitsc-testimonials__grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 575px) {
    .aitsc-testimonials--healthcare .aitsc-testimonials__grid {
        grid-template-columns: 1fr;
    }
}
```

### Step 5: Component Documentation (1.5h)
Create `docs/components-healthcare.md`:

```markdown
# Healthcare Component Variants

## Card
```php
aitsc_render_card([
    'variant' => 'healthcare',
    'title' => 'AI Diagnosis',
    'description' => 'Automated image analysis for faster results.',
    'link' => '/solutions/diagnosis',
    'cta_text' => 'Learn More',
]);
```

## CTA
```php
aitsc_render_cta([
    'variant' => 'healthcare',
    'title' => 'Ready to transform your practice?',
    'description' => 'Join leading healthcare providers using our AI.',
    'button_text' => 'Book a Demo',
    'button_link' => '/contact',
]);
```

## Stats
```php
aitsc_render_stats([
    ['value' => 1000000, 'label' => 'Scans Analyzed', 'suffix' => '+'],
    ['value' => 99.2, 'label' => 'Accuracy Rate', 'suffix' => '%'],
    ['value' => 50, 'label' => 'Hospital Partners', 'suffix' => '+'],
    ['value' => 15, 'label' => 'Countries', 'suffix' => ''],
], 'healthcare');
```

## Testimonials
```php
aitsc_render_testimonials([
    [
        'quote' => 'Harrison.ai transformed our radiology workflow.',
        'name' => 'Dr. Sarah Chen',
        'role' => 'Chief Radiologist, Metro Hospital',
        'photo' => '/images/testimonials/sarah.jpg',
    ],
], 'healthcare');
```
```

---

## Todo Checklist

- [ ] Add healthcare card variant to card-base.php
- [ ] Add healthcare card CSS to card-variants.css
- [ ] Add healthcare-featured card variant
- [ ] Add healthcare CTA variant to cta-block.php
- [ ] Add healthcare CTA CSS to cta-styles.css
- [ ] Update stats-counter.php for variant support
- [ ] Add healthcare stats CSS
- [ ] Update testimonial-carousel.php for variant support
- [ ] Add healthcare testimonial CSS with photo support
- [ ] Create docs/components-healthcare.md
- [ ] Test all variants in light theme
- [ ] Test all variants in dark theme (should still work)
- [ ] Verify responsive behavior

---

## Success Criteria

1. **All Variants Work** - Healthcare variants render correctly
2. **Backward Compatible** - Existing variants unchanged
3. **Light Theme Native** - New variants designed for light
4. **Green CTA** - #059669 CTA button visible
5. **Photos Work** - Testimonial photos display correctly
6. **Responsive** - All variants work on mobile

---

## Risk Assessment

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|------------|
| Variant naming collision | Low | Medium | Use healthcare- prefix |
| CSS specificity issues | Medium | Low | Use variant class selectors |
| Photo loading performance | Medium | Medium | Lazy load, optimize images |
| Dark theme regression | Low | High | Test all existing variants |

---

## Rollback Procedure

1. Remove healthcare case blocks from PHP
2. Remove healthcare CSS from component stylesheets
3. Component API additions are backward compatible

---

## Dependencies

- Phase 1 (Design System) for CSS variables
- Phase 3 (Layout Patterns) for section styling consistency
