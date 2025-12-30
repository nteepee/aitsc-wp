# Phase 3: Layout Patterns

**Parent**: [plan.md](./plan.md)
**Status**: Pending
**Priority**: High
**Estimated**: 8 hours
**Depends On**: Phase 1

---

## Context

Current AITSC theme uses Bootstrap-based grid with dark panels. Harrison.ai employs asymmetric two-column and three-column layouts with generous whitespace and large imagery.

### Current Layout Patterns
- Bootstrap row/col grid system
- 4-column solution cards grid
- Glass panel containers
- Full-width sections with dark backgrounds

### Target Layout Patterns (Harrison.ai)
- **Two-Column Asymmetric**: 60/40 split with large image + text
- **Three-Column Feature Grid**: Icon cards with descriptions
- **Product Showcase**: Dark UI mockups on light background
- **Staggered Sections**: Alternating image left/right

---

## Overview

Create reusable layout components for Harrison.ai-style sections without replacing existing Bootstrap grid. Add new template parts for common patterns.

---

## Key Insights

1. **Composition Over Replacement** - New patterns alongside Bootstrap
2. **Template Parts** - Reusable PHP includes for common layouts
3. **CSS Grid** - Modern grid for asymmetric layouts
4. **Whitespace** - Generous padding/margin for healthcare feel
5. **Content Width** - Narrower content containers (max 1200px)

---

## Requirements

### Functional
- [ ] Two-column asymmetric layout component
- [ ] Three-column feature grid component
- [ ] Staggered content sections
- [ ] Product showcase layout
- [ ] Image-text split patterns

### Non-Functional
- [ ] No Bootstrap dependency for new layouts
- [ ] Pure CSS Grid/Flexbox
- [ ] Mobile-first responsive
- [ ] Max 5 new template files

---

## Architecture

### New Template Parts
```
template-parts/
  layouts/
    layout-two-column.php      # Asymmetric 60/40 split
    layout-feature-grid.php    # 3-column icon cards
    layout-staggered.php       # Alternating image/text
    layout-product-showcase.php # Dark UI mockup display
```

### Layout API
```php
// Two-column layout
aitsc_render_layout([
    'type' => 'two-column',
    'content' => [
        'left' => [
            'type' => 'image',
            'src' => '/path/to/image.jpg',
        ],
        'right' => [
            'type' => 'text',
            'title' => 'Section Title',
            'description' => '...',
            'cta' => ['text' => 'Learn More', 'link' => '/page'],
        ],
    ],
    'reverse' => false,  // Swap left/right
    'ratio' => '60-40',  // 50-50, 60-40, 70-30
]);

// Feature grid
aitsc_render_layout([
    'type' => 'feature-grid',
    'columns' => 3,
    'items' => [
        ['icon' => 'security', 'title' => '...', 'description' => '...'],
        ['icon' => 'speed', 'title' => '...', 'description' => '...'],
        ['icon' => 'analytics', 'title' => '...', 'description' => '...'],
    ],
]);
```

---

## Implementation Steps

### Step 1: Layout Renderer Function (1.5h)
Create `inc/layouts.php`:

```php
<?php
/**
 * Layout Renderer
 * Provides reusable layout patterns for Harrison.ai-style sections
 */

if (!defined('ABSPATH')) exit;

function aitsc_render_layout($args = []) {
    $type = $args['type'] ?? 'two-column';

    switch ($type) {
        case 'two-column':
            aitsc_render_two_column($args);
            break;
        case 'feature-grid':
            aitsc_render_feature_grid($args);
            break;
        case 'staggered':
            aitsc_render_staggered($args);
            break;
        case 'product-showcase':
            aitsc_render_product_showcase($args);
            break;
    }
}
```

### Step 2: Two-Column Layout (2h)
Create `template-parts/layouts/layout-two-column.php`:

```php
<?php
function aitsc_render_two_column($args) {
    $defaults = [
        'content' => ['left' => [], 'right' => []],
        'reverse' => false,
        'ratio' => '60-40',
        'bg' => 'light',
        'spacing' => 'large',
    ];
    $args = wp_parse_args($args, $defaults);

    $ratio_class = 'aitsc-layout--ratio-' . $args['ratio'];
    $reverse_class = $args['reverse'] ? 'aitsc-layout--reverse' : '';
    $bg_class = 'aitsc-layout--bg-' . $args['bg'];
    $spacing_class = 'aitsc-layout--spacing-' . $args['spacing'];
    ?>

    <section class="aitsc-layout aitsc-layout--two-column <?php echo "$ratio_class $reverse_class $bg_class $spacing_class"; ?>">
        <div class="aitsc-layout__container">
            <div class="aitsc-layout__grid">

                <!-- Left Column -->
                <div class="aitsc-layout__col aitsc-layout__col--left">
                    <?php aitsc_render_layout_content($args['content']['left']); ?>
                </div>

                <!-- Right Column -->
                <div class="aitsc-layout__col aitsc-layout__col--right">
                    <?php aitsc_render_layout_content($args['content']['right']); ?>
                </div>

            </div>
        </div>
    </section>
    <?php
}

function aitsc_render_layout_content($content) {
    if (empty($content)) return;

    $type = $content['type'] ?? 'text';

    switch ($type) {
        case 'image':
            ?>
            <div class="aitsc-layout__image">
                <img src="<?php echo esc_url($content['src']); ?>"
                     alt="<?php echo esc_attr($content['alt'] ?? ''); ?>"
                     loading="lazy">
            </div>
            <?php
            break;

        case 'text':
            ?>
            <div class="aitsc-layout__text">
                <?php if (!empty($content['label'])): ?>
                    <span class="aitsc-layout__label"><?php echo esc_html($content['label']); ?></span>
                <?php endif; ?>

                <?php if (!empty($content['title'])): ?>
                    <h2 class="aitsc-layout__title"><?php echo wp_kses_post($content['title']); ?></h2>
                <?php endif; ?>

                <?php if (!empty($content['description'])): ?>
                    <p class="aitsc-layout__description"><?php echo wp_kses_post($content['description']); ?></p>
                <?php endif; ?>

                <?php if (!empty($content['cta'])): ?>
                    <a href="<?php echo esc_url($content['cta']['link']); ?>" class="aitsc-layout__cta">
                        <?php echo esc_html($content['cta']['text']); ?>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                <?php endif; ?>
            </div>
            <?php
            break;
    }
}
```

### Step 3: Layout CSS (2.5h)
Create `assets/css/layouts.css`:

```css
/* ==========================================================================
   LAYOUT PATTERNS - Harrison.ai Style
   ========================================================================== */

/* Container */
.aitsc-layout__container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

/* Two-Column Layout */
.aitsc-layout--two-column .aitsc-layout__grid {
    display: grid;
    gap: 4rem;
    align-items: center;
}

/* Ratio Variants */
.aitsc-layout--ratio-50-50 .aitsc-layout__grid {
    grid-template-columns: 1fr 1fr;
}

.aitsc-layout--ratio-60-40 .aitsc-layout__grid {
    grid-template-columns: 1.5fr 1fr;
}

.aitsc-layout--ratio-70-30 .aitsc-layout__grid {
    grid-template-columns: 2fr 1fr;
}

/* Reverse */
.aitsc-layout--reverse .aitsc-layout__grid {
    direction: rtl;
}

.aitsc-layout--reverse .aitsc-layout__col {
    direction: ltr;
}

/* Spacing Variants */
.aitsc-layout--spacing-small {
    padding: 3rem 0;
}

.aitsc-layout--spacing-medium {
    padding: 5rem 0;
}

.aitsc-layout--spacing-large {
    padding: 8rem 0;
}

/* Background Variants */
.aitsc-layout--bg-light {
    background: var(--hai-bg-primary);
}

.aitsc-layout--bg-secondary {
    background: var(--hai-bg-secondary);
}

.aitsc-layout--bg-dark {
    background: var(--hai-bg-dark);
}

/* Image Column */
.aitsc-layout__image {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--hai-shadow-lg);
}

.aitsc-layout__image img {
    width: 100%;
    height: auto;
    display: block;
}

/* Text Column */
.aitsc-layout__label {
    display: inline-block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--hai-brand-blue);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 1rem;
}

.aitsc-layout__title {
    font-size: clamp(2rem, 4vw, 2.75rem);
    font-weight: 700;
    line-height: 1.2;
    color: var(--hai-text-primary);
    margin-bottom: 1.5rem;
}

.aitsc-layout__description {
    font-size: 1.125rem;
    line-height: 1.7;
    color: var(--hai-text-secondary);
    margin-bottom: 2rem;
}

.aitsc-layout__cta {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
    color: var(--hai-brand-blue);
    text-decoration: none;
    transition: gap 0.2s ease;
}

.aitsc-layout__cta:hover {
    gap: 1rem;
}

/* Feature Grid */
.aitsc-layout--feature-grid .aitsc-layout__grid {
    display: grid;
    gap: 2rem;
}

.aitsc-layout--feature-grid[data-columns="3"] .aitsc-layout__grid {
    grid-template-columns: repeat(3, 1fr);
}

.aitsc-layout--feature-grid[data-columns="4"] .aitsc-layout__grid {
    grid-template-columns: repeat(4, 1fr);
}

/* Feature Card */
.aitsc-layout__feature {
    padding: 2rem;
    background: var(--hai-bg-primary);
    border: 1px solid var(--hai-border);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.aitsc-layout__feature:hover {
    border-color: var(--hai-brand-blue);
    box-shadow: var(--hai-shadow-md);
}

.aitsc-layout__feature-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 56px;
    height: 56px;
    background: rgba(59, 130, 246, 0.1);
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

.aitsc-layout__feature-icon .material-symbols-outlined {
    font-size: 28px;
    color: var(--hai-brand-blue);
}

.aitsc-layout__feature-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--hai-text-primary);
    margin-bottom: 0.75rem;
}

.aitsc-layout__feature-description {
    font-size: 1rem;
    line-height: 1.6;
    color: var(--hai-text-secondary);
}

/* Responsive */
@media (max-width: 991px) {
    .aitsc-layout--two-column .aitsc-layout__grid {
        grid-template-columns: 1fr;
        gap: 3rem;
    }

    .aitsc-layout--reverse .aitsc-layout__col--left {
        order: 2;
    }

    .aitsc-layout--feature-grid[data-columns="3"] .aitsc-layout__grid,
    .aitsc-layout--feature-grid[data-columns="4"] .aitsc-layout__grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 575px) {
    .aitsc-layout__container {
        padding: 0 1rem;
    }

    .aitsc-layout--spacing-large {
        padding: 4rem 0;
    }

    .aitsc-layout--feature-grid[data-columns="3"] .aitsc-layout__grid,
    .aitsc-layout--feature-grid[data-columns="4"] .aitsc-layout__grid {
        grid-template-columns: 1fr;
    }
}

/* Dark Theme Overrides */
.aitsc-layout--bg-dark .aitsc-layout__title {
    color: var(--hai-text-inverted);
}

.aitsc-layout--bg-dark .aitsc-layout__description {
    color: var(--hai-text-muted);
}

.aitsc-layout--bg-dark .aitsc-layout__feature {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(255, 255, 255, 0.1);
}
```

### Step 4: Feature Grid Component (1h)
Add to `inc/layouts.php`:

```php
function aitsc_render_feature_grid($args) {
    $defaults = [
        'columns' => 3,
        'items' => [],
        'bg' => 'secondary',
        'title' => '',
        'subtitle' => '',
    ];
    $args = wp_parse_args($args, $defaults);
    ?>

    <section class="aitsc-layout aitsc-layout--feature-grid aitsc-layout--bg-<?php echo esc_attr($args['bg']); ?> aitsc-layout--spacing-large"
             data-columns="<?php echo esc_attr($args['columns']); ?>">
        <div class="aitsc-layout__container">

            <?php if ($args['title'] || $args['subtitle']): ?>
                <div class="aitsc-layout__header">
                    <?php if ($args['subtitle']): ?>
                        <span class="aitsc-layout__label"><?php echo esc_html($args['subtitle']); ?></span>
                    <?php endif; ?>
                    <?php if ($args['title']): ?>
                        <h2 class="aitsc-layout__title"><?php echo wp_kses_post($args['title']); ?></h2>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="aitsc-layout__grid">
                <?php foreach ($args['items'] as $item): ?>
                    <div class="aitsc-layout__feature">
                        <div class="aitsc-layout__feature-icon">
                            <span class="material-symbols-outlined"><?php echo esc_html($item['icon']); ?></span>
                        </div>
                        <h3 class="aitsc-layout__feature-title"><?php echo esc_html($item['title']); ?></h3>
                        <p class="aitsc-layout__feature-description"><?php echo esc_html($item['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>
    <?php
}
```

### Step 5: Staggered Layout (1h)
Add alternating sections support:

```php
function aitsc_render_staggered($args) {
    $defaults = [
        'sections' => [],
    ];
    $args = wp_parse_args($args, $defaults);

    foreach ($args['sections'] as $index => $section) {
        $reverse = ($index % 2 === 1);
        aitsc_render_two_column([
            'content' => $section,
            'reverse' => $reverse,
            'ratio' => '60-40',
            'bg' => $reverse ? 'secondary' : 'light',
        ]);
    }
}
```

---

## Todo Checklist

- [ ] Create inc/layouts.php with render function
- [ ] Create layout-two-column.php template
- [ ] Create layout-feature-grid.php template
- [ ] Create assets/css/layouts.css
- [ ] Add ratio variants (50-50, 60-40, 70-30)
- [ ] Add spacing variants
- [ ] Add background variants
- [ ] Add feature grid component
- [ ] Add staggered layout component
- [ ] Add responsive breakpoints
- [ ] Enqueue layouts.css in inc/enqueue.php
- [ ] Test two-column with various images
- [ ] Test feature grid with 3/4 columns
- [ ] Verify mobile stacking

---

## Success Criteria

1. **Two-Column Works** - Asymmetric layouts render correctly
2. **Feature Grid Works** - 3/4 column icon cards display
3. **Staggered Works** - Alternating sections auto-reverse
4. **Responsive** - Graceful degradation to single column
5. **Theme Compatible** - Works with both dark/light themes

---

## Risk Assessment

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|------------|
| Grid browser support | Low | Low | CSS Grid has 97%+ support |
| Conflict with Bootstrap | Medium | Medium | Use distinct class names |
| Image aspect ratios | Medium | Low | Object-fit: cover |
| Content overflow | Low | Medium | Test with long content |

---

## Rollback Procedure

1. Remove inc/layouts.php
2. Remove template-parts/layouts/ directory
3. Remove assets/css/layouts.css
4. Remove enqueue from inc/enqueue.php

---

## Dependencies

- Phase 1 (Design System) for CSS variables
