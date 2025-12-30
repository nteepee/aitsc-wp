# Phase 2: White Component Variants

**Status**: Not Started
**Priority**: Critical
**Dependencies**: Phase 1 (CSS Variables)

---

## Context

Add white theme variants to existing universal components while maintaining backward compatibility with existing variant APIs.

---

## Components to Update

1. **Card** - Add `white-feature`, `white-product` variants
2. **Hero** - Add `white-fullwidth`, `white-split` variants
3. **CTA** - Add `white-cta` variant
4. **Stats** - Add `inline-text` variant
5. **Testimonial** - Add `white-testimonial` variant

---

## 1. Card Component Updates

### File: `components/card/card-base.php`

**Add to switch statement**:

```php
case 'white-feature':
    // Three-column feature card (Harrison.ai style)
    // Large photo top, icon below, title, description
    if (!empty($image)) {
        $output .= sprintf(
            '<div class="aitsc-card__image">' .
                '<img src="%s" alt="%s" loading="lazy" />' .
            '</div>',
            $image,
            esc_attr($title)
        );
    }
    if (!empty($icon)) {
        $output .= sprintf(
            '<div class="aitsc-card__icon-badge">' .
                '<span class="material-symbols-outlined">%s</span>' .
            '</div>',
            $icon
        );
    }
    break;

case 'white-product':
    // Product showcase card (dark UI mockup on light bg)
    if (!empty($image)) {
        $output .= sprintf(
            '<div class="aitsc-card__product-image">' .
                '<img src="%s" alt="%s" loading="lazy" />' .
            '</div>',
            $image,
            esc_attr($title)
        );
    }
    break;
```

### File: `components/card/card-variants.css`

**Add new variant styles**:

```css
/* ==========================================================================
   Variant: White Feature (Harrison.ai three-column card)
   ========================================================================== */

.aitsc-card--white-feature {
    background: var(--aitsc-bg-primary);
    border: 1px solid var(--aitsc-border);
    box-shadow: var(--aitsc-shadow-md);
    border-radius: var(--aitsc-radius-lg);
    overflow: hidden;
}

.aitsc-card--white-feature:hover {
    box-shadow: var(--aitsc-shadow-lg);
    transform: translateY(-4px);
    border-color: var(--aitsc-primary);
}

.aitsc-card--white-feature .aitsc-card__image {
    position: relative;
    width: 100%;
    height: 220px;
    overflow: hidden;
}

.aitsc-card--white-feature .aitsc-card__image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.aitsc-card--white-feature:hover .aitsc-card__image img {
    transform: scale(1.05);
}

.aitsc-card--white-feature .aitsc-card__icon-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    background: var(--aitsc-primary-light);
    color: var(--aitsc-primary);
    border-radius: var(--aitsc-radius-md);
    margin: -24px auto 1rem;
    position: relative;
    z-index: 1;
}

.aitsc-card--white-feature .aitsc-card__body {
    padding: 1rem 1.5rem 1.5rem;
    text-align: center;
}

.aitsc-card--white-feature .aitsc-card__title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--aitsc-text-primary);
    margin-bottom: 0.75rem;
}

.aitsc-card--white-feature .aitsc-card__description {
    font-size: 0.95rem;
    color: var(--aitsc-text-secondary);
    line-height: 1.6;
}

.aitsc-card--white-feature .aitsc-card__cta {
    color: var(--aitsc-primary);
    margin-top: 1rem;
}

/* ==========================================================================
   Variant: White Product (Product showcase)
   ========================================================================== */

.aitsc-card--white-product {
    background: var(--aitsc-bg-secondary);
    border-radius: var(--aitsc-radius-xl);
    padding: 2rem;
    display: flex;
    flex-direction: row;
    gap: 2rem;
    align-items: center;
}

.aitsc-card--white-product .aitsc-card__product-image {
    flex: 0 0 55%;
    border-radius: var(--aitsc-radius-lg);
    overflow: hidden;
    box-shadow: var(--aitsc-shadow-xl);
}

.aitsc-card--white-product .aitsc-card__product-image img {
    width: 100%;
    height: auto;
    display: block;
}

.aitsc-card--white-product .aitsc-card__body {
    flex: 1;
}

.aitsc-card--white-product .aitsc-card__title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--aitsc-text-primary);
    margin-bottom: 1rem;
}

.aitsc-card--white-product .aitsc-card__description {
    color: var(--aitsc-text-secondary);
    line-height: 1.7;
    margin-bottom: 1.5rem;
}

.aitsc-card--white-product .aitsc-card__cta {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--aitsc-primary);
    font-weight: 600;
}

@media (max-width: 47.9375rem) {
    .aitsc-card--white-product {
        flex-direction: column;
    }

    .aitsc-card--white-product .aitsc-card__product-image {
        flex: none;
        width: 100%;
    }
}
```

---

## 2. Hero Component Updates

### File: `components/hero/hero-universal.php`

**Add to variant handling**:

```php
// After line ~130 (variant-specific output)

case 'white-fullwidth':
    // Full-width photo background hero
    echo '<div class="aitsc-hero__overlay"></div>';
    break;

case 'white-split':
    // Two-column layout
    // Content goes in left column, image in right
    break;
```

### File: `components/hero/hero-variants.css`

**Add new variant styles**:

```css
/* ==========================================================================
   Variant: White Fullwidth (Full photo background)
   ========================================================================== */

.aitsc-hero--white-fullwidth {
    min-height: 70vh;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    color: #FFFFFF;
    text-align: center;
}

.aitsc-hero--white-fullwidth .aitsc-hero__overlay {
    background: linear-gradient(
        180deg,
        rgba(0, 0, 0, 0.2) 0%,
        rgba(0, 0, 0, 0.5) 100%
    );
}

.aitsc-hero--white-fullwidth .aitsc-hero__content {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

.aitsc-hero--white-fullwidth .aitsc-hero__subtitle {
    font-size: 0.875rem;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 1rem;
}

.aitsc-hero--white-fullwidth .aitsc-hero__title {
    font-size: clamp(2.5rem, 5vw, 4.5rem);
    font-weight: 700;
    line-height: 1.1;
    color: #FFFFFF;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    margin-bottom: 1.5rem;
}

.aitsc-hero--white-fullwidth .aitsc-hero__description {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.95);
    max-width: 700px;
    margin: 0 auto 2rem;
}

.aitsc-hero--white-fullwidth .aitsc-hero__ctas {
    justify-content: center;
}

.aitsc-hero--white-fullwidth .aitsc-btn--primary {
    background: #FFFFFF;
    color: var(--aitsc-primary);
    border: none;
}

.aitsc-hero--white-fullwidth .aitsc-btn--primary:hover {
    background: var(--aitsc-bg-secondary);
    transform: translateY(-2px);
}

.aitsc-hero--white-fullwidth .aitsc-btn--secondary {
    background: transparent;
    color: #FFFFFF;
    border: 2px solid #FFFFFF;
}

.aitsc-hero--white-fullwidth .aitsc-btn--secondary:hover {
    background: rgba(255, 255, 255, 0.1);
}

/* ==========================================================================
   Variant: White Split (Two-column layout)
   ========================================================================== */

.aitsc-hero--white-split {
    background: var(--aitsc-bg-primary);
    min-height: 60vh;
}

.aitsc-hero--white-split .aitsc-hero__container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: center;
}

.aitsc-hero--white-split .aitsc-hero__content {
    text-align: left;
}

.aitsc-hero--white-split .aitsc-hero__title {
    color: var(--aitsc-text-primary);
    font-size: clamp(2rem, 4vw, 3.5rem);
}

.aitsc-hero--white-split .aitsc-hero__subtitle {
    color: var(--aitsc-primary);
}

.aitsc-hero--white-split .aitsc-hero__description {
    color: var(--aitsc-text-secondary);
}

.aitsc-hero--white-split .aitsc-hero__ctas {
    justify-content: flex-start;
}

@media (max-width: 47.9375rem) {
    .aitsc-hero--white-split .aitsc-hero__container {
        grid-template-columns: 1fr;
    }

    .aitsc-hero--white-fullwidth .aitsc-hero__title {
        font-size: 2rem;
    }
}
```

---

## 3. Stats Component Updates

### File: `components/stats/stats-counter.php`

**Add inline variant support**:

```php
function aitsc_render_stats($stats = array(), $variant = 'default') {
    if (empty($stats)) return;

    $wrapper_class = 'aitsc-stats';
    if ($variant === 'inline-text') {
        $wrapper_class .= ' aitsc-stats--inline';
    }

    echo '<div class="' . esc_attr($wrapper_class) . '">';

    foreach ($stats as $stat) {
        if ($variant === 'inline-text') {
            echo sprintf(
                '<span class="aitsc-stat-inline">' .
                    '<span class="aitsc-stat-inline__number">%s</span> %s' .
                '</span>',
                esc_html($stat['number']),
                esc_html($stat['label'])
            );
        } else {
            // Default counter block output
            // ... existing code
        }
    }

    echo '</div>';
}
```

### File: `components/stats/stats-styles.css`

**Add inline variant**:

```css
/* ==========================================================================
   Variant: Inline Text Stats
   ========================================================================== */

.aitsc-stats--inline {
    display: inline;
}

.aitsc-stat-inline {
    display: inline;
}

.aitsc-stat-inline__number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--aitsc-primary);
    margin-right: 0.25rem;
}
```

---

## Todo List

- [ ] Update card-base.php with white-feature variant
- [ ] Update card-base.php with white-product variant
- [ ] Add card CSS for white variants
- [ ] Update hero-universal.php with white-fullwidth
- [ ] Update hero-universal.php with white-split
- [ ] Add hero CSS for white variants
- [ ] Add stats inline-text variant
- [ ] Add CTA white variant
- [ ] Add testimonial white variant
- [ ] Test all new variants render correctly
- [ ] Test existing variants still work
- [ ] Responsive testing for new variants

---

## Success Criteria

1. All new variants render without PHP errors
2. Existing variants unchanged (backward compatible)
3. New variants follow Harrison.ai aesthetic
4. All variants responsive across 5 breakpoints
5. Component shortcodes support new variants
