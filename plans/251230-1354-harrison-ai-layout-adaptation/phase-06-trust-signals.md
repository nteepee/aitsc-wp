# Phase 6: Trust Signals Integration

**Parent**: [plan.md](./plan.md)
**Status**: Pending
**Priority**: Medium
**Estimated**: 6 hours
**Depends On**: Phase 1, Phase 3

---

## Context

Harrison.ai prominently displays partner logos and trust signals. Current AITSC theme has basic logo strip but lacks dedicated trust signal components.

### Current Trust Elements
- Basic text ticker on homepage
- No logo carousel component
- No certification badges display

### Target Trust Elements (Harrison.ai)
- **Logo Carousel**: Partner/client logos in infinite scroll
- **Certification Badges**: ISO, HIPAA, SOC2 badges
- **Stats Bar**: Key metrics inline with logos
- **Press/Media Mentions**: "As seen in" section

---

## Overview

Create dedicated trust signal components including logo carousel, certification badges, and media mentions. Essential for healthcare/enterprise B2B credibility.

---

## Key Insights

1. **Infinite Scroll** - CSS animation for smooth logo carousel
2. **Grayscale to Color** - Logos grayscale, color on hover
3. **Responsive** - Hide less important logos on mobile
4. **Accessibility** - Pause animation on hover/focus
5. **No External JS** - Pure CSS animation for performance

---

## Requirements

### Functional
- [ ] Logo carousel component with infinite scroll
- [ ] Certification badge display component
- [ ] Media mentions "As seen in" section
- [ ] Combined trust bar component (logos + stats)

### Non-Functional
- [ ] CSS-only animation (no JS library)
- [ ] Pause on hover for accessibility
- [ ] Grayscale filter with color hover
- [ ] Lazy load logos below fold

---

## Architecture

### New Components
```
components/
  trust/
    logo-carousel.php      # Infinite scrolling logos
    certification-badges.php # ISO, compliance badges
    media-mentions.php     # Press logos
    trust-bar.php          # Combined logos + stats
```

### Component API
```php
// Logo Carousel
aitsc_render_logo_carousel([
    'logos' => [
        ['src' => '/logo1.svg', 'alt' => 'Company 1', 'url' => 'https://...'],
        ['src' => '/logo2.svg', 'alt' => 'Company 2', 'url' => 'https://...'],
    ],
    'title' => 'Trusted by leading healthcare organizations',
    'speed' => 'medium', // slow|medium|fast
    'pause_on_hover' => true,
]);

// Certification Badges
aitsc_render_certifications([
    'badges' => [
        ['type' => 'iso-27001', 'label' => 'ISO 27001 Certified'],
        ['type' => 'hipaa', 'label' => 'HIPAA Compliant'],
        ['type' => 'soc2', 'label' => 'SOC 2 Type II'],
    ],
]);

// Trust Bar
aitsc_render_trust_bar([
    'logos' => [...],
    'stats' => [
        ['value' => '1M+', 'label' => 'Scans Analyzed'],
        ['value' => '50+', 'label' => 'Hospital Partners'],
    ],
]);
```

---

## Implementation Steps

### Step 1: Logo Carousel Component (2h)
Create `components/trust/logo-carousel.php`:

```php
<?php
/**
 * Logo Carousel Component
 * Infinite scrolling partner/client logos
 */

if (!defined('ABSPATH')) exit;

function aitsc_render_logo_carousel($args = []) {
    $defaults = [
        'logos' => [],
        'title' => '',
        'speed' => 'medium',
        'pause_on_hover' => true,
    ];
    $args = wp_parse_args($args, $defaults);

    if (empty($args['logos'])) return;

    $speed_class = 'aitsc-logos--speed-' . $args['speed'];
    $pause_class = $args['pause_on_hover'] ? 'aitsc-logos--pause-hover' : '';
    ?>

    <section class="aitsc-logos <?php echo "$speed_class $pause_class"; ?>">
        <div class="aitsc-logos__container">

            <?php if ($args['title']): ?>
                <p class="aitsc-logos__title"><?php echo esc_html($args['title']); ?></p>
            <?php endif; ?>

            <div class="aitsc-logos__track">
                <div class="aitsc-logos__slider">
                    <?php
                    // Duplicate logos for seamless loop
                    $all_logos = array_merge($args['logos'], $args['logos']);
                    foreach ($all_logos as $logo):
                    ?>
                        <div class="aitsc-logos__item">
                            <?php if (!empty($logo['url'])): ?>
                                <a href="<?php echo esc_url($logo['url']); ?>"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="aitsc-logos__link">
                            <?php endif; ?>

                            <img src="<?php echo esc_url($logo['src']); ?>"
                                 alt="<?php echo esc_attr($logo['alt']); ?>"
                                 loading="lazy"
                                 class="aitsc-logos__image">

                            <?php if (!empty($logo['url'])): ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </section>
    <?php
}
```

Add `components/trust/logo-carousel.css`:

```css
/* Logo Carousel */
.aitsc-logos {
    background: var(--hai-bg-secondary);
    padding: 3rem 0;
    overflow: hidden;
}

.aitsc-logos__container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
}

.aitsc-logos__title {
    text-align: center;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--hai-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 2rem;
}

.aitsc-logos__track {
    overflow: hidden;
    mask-image: linear-gradient(
        to right,
        transparent,
        black 10%,
        black 90%,
        transparent
    );
    -webkit-mask-image: linear-gradient(
        to right,
        transparent,
        black 10%,
        black 90%,
        transparent
    );
}

.aitsc-logos__slider {
    display: flex;
    gap: 4rem;
    animation: logo-scroll 30s linear infinite;
    width: max-content;
}

.aitsc-logos__item {
    flex-shrink: 0;
}

.aitsc-logos__image {
    height: 40px;
    width: auto;
    object-fit: contain;
    filter: grayscale(100%) opacity(0.6);
    transition: all 0.3s ease;
}

.aitsc-logos__item:hover .aitsc-logos__image {
    filter: grayscale(0%) opacity(1);
}

/* Speed Variants */
.aitsc-logos--speed-slow .aitsc-logos__slider {
    animation-duration: 50s;
}

.aitsc-logos--speed-medium .aitsc-logos__slider {
    animation-duration: 30s;
}

.aitsc-logos--speed-fast .aitsc-logos__slider {
    animation-duration: 15s;
}

/* Pause on Hover */
.aitsc-logos--pause-hover .aitsc-logos__track:hover .aitsc-logos__slider {
    animation-play-state: paused;
}

/* Animation */
@keyframes logo-scroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

/* Accessibility: Reduce motion */
@media (prefers-reduced-motion: reduce) {
    .aitsc-logos__slider {
        animation: none;
    }

    .aitsc-logos__track {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
}

/* Responsive */
@media (max-width: 767px) {
    .aitsc-logos__slider {
        gap: 2rem;
    }

    .aitsc-logos__image {
        height: 30px;
    }
}
```

### Step 2: Certification Badges (1.5h)
Create `components/trust/certification-badges.php`:

```php
<?php
function aitsc_render_certifications($args = []) {
    $defaults = [
        'badges' => [],
        'layout' => 'inline', // inline|grid
    ];
    $args = wp_parse_args($args, $defaults);

    if (empty($args['badges'])) return;

    $badge_icons = [
        'iso-27001' => 'verified_user',
        'iso-9001' => 'workspace_premium',
        'hipaa' => 'local_hospital',
        'soc2' => 'security',
        'gdpr' => 'shield',
        'fda' => 'medical_services',
    ];
    ?>

    <div class="aitsc-certifications aitsc-certifications--<?php echo esc_attr($args['layout']); ?>">
        <?php foreach ($args['badges'] as $badge): ?>
            <div class="aitsc-certifications__badge">
                <span class="material-symbols-outlined aitsc-certifications__icon">
                    <?php echo esc_html($badge_icons[$badge['type']] ?? 'verified'); ?>
                </span>
                <span class="aitsc-certifications__label">
                    <?php echo esc_html($badge['label']); ?>
                </span>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}
```

Add CSS:

```css
/* Certification Badges */
.aitsc-certifications {
    display: flex;
    gap: 2rem;
    justify-content: center;
    padding: 2rem 0;
}

.aitsc-certifications--grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1.5rem;
    justify-items: center;
}

.aitsc-certifications__badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: var(--hai-bg-primary);
    border: 1px solid var(--hai-border);
    border-radius: 8px;
    transition: all 0.2s ease;
}

.aitsc-certifications__badge:hover {
    border-color: var(--hai-brand-blue);
    box-shadow: var(--hai-shadow-sm);
}

.aitsc-certifications__icon {
    font-size: 24px;
    color: var(--hai-brand-blue);
}

.aitsc-certifications__label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--hai-text-primary);
}

@media (max-width: 575px) {
    .aitsc-certifications {
        flex-wrap: wrap;
        gap: 1rem;
    }

    .aitsc-certifications__badge {
        flex: 1 1 45%;
        min-width: 140px;
    }
}
```

### Step 3: Trust Bar Combined (1.5h)
Create `components/trust/trust-bar.php`:

```php
<?php
function aitsc_render_trust_bar($args = []) {
    $defaults = [
        'logos' => [],
        'stats' => [],
        'bg' => 'secondary',
    ];
    $args = wp_parse_args($args, $defaults);
    ?>

    <section class="aitsc-trust-bar aitsc-trust-bar--bg-<?php echo esc_attr($args['bg']); ?>">
        <div class="aitsc-trust-bar__container">

            <?php if (!empty($args['logos'])): ?>
                <div class="aitsc-trust-bar__logos">
                    <?php foreach ($args['logos'] as $logo): ?>
                        <img src="<?php echo esc_url($logo['src']); ?>"
                             alt="<?php echo esc_attr($logo['alt']); ?>"
                             class="aitsc-trust-bar__logo">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($args['stats'])): ?>
                <div class="aitsc-trust-bar__stats">
                    <?php foreach ($args['stats'] as $stat): ?>
                        <div class="aitsc-trust-bar__stat">
                            <span class="aitsc-trust-bar__value"><?php echo esc_html($stat['value']); ?></span>
                            <span class="aitsc-trust-bar__label"><?php echo esc_html($stat['label']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </section>
    <?php
}
```

Add CSS:

```css
/* Trust Bar */
.aitsc-trust-bar {
    padding: 4rem 2rem;
    border-top: 1px solid var(--hai-border);
    border-bottom: 1px solid var(--hai-border);
}

.aitsc-trust-bar--bg-secondary {
    background: var(--hai-bg-secondary);
}

.aitsc-trust-bar--bg-dark {
    background: var(--hai-bg-dark);
}

.aitsc-trust-bar__container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 4rem;
}

.aitsc-trust-bar__logos {
    display: flex;
    align-items: center;
    gap: 3rem;
    flex-wrap: wrap;
}

.aitsc-trust-bar__logo {
    height: 32px;
    width: auto;
    filter: grayscale(100%) opacity(0.6);
    transition: all 0.3s ease;
}

.aitsc-trust-bar__logo:hover {
    filter: grayscale(0%) opacity(1);
}

.aitsc-trust-bar__stats {
    display: flex;
    gap: 3rem;
}

.aitsc-trust-bar__stat {
    text-align: center;
}

.aitsc-trust-bar__value {
    display: block;
    font-size: 2rem;
    font-weight: 700;
    color: var(--hai-brand-blue);
    line-height: 1;
}

.aitsc-trust-bar__label {
    font-size: 0.875rem;
    color: var(--hai-text-secondary);
}

/* Dark variant */
.aitsc-trust-bar--bg-dark .aitsc-trust-bar__logo {
    filter: grayscale(100%) brightness(2) opacity(0.6);
}

.aitsc-trust-bar--bg-dark .aitsc-trust-bar__label {
    color: var(--hai-text-muted);
}

@media (max-width: 991px) {
    .aitsc-trust-bar__container {
        flex-direction: column;
        gap: 2rem;
    }

    .aitsc-trust-bar__logos {
        justify-content: center;
    }

    .aitsc-trust-bar__stats {
        justify-content: center;
    }
}

@media (max-width: 575px) {
    .aitsc-trust-bar__logos {
        gap: 1.5rem;
    }

    .aitsc-trust-bar__logo {
        height: 24px;
    }

    .aitsc-trust-bar__stats {
        gap: 1.5rem;
    }

    .aitsc-trust-bar__value {
        font-size: 1.5rem;
    }
}
```

### Step 4: Component Registration (0.5h)
Update `inc/components.php`:

```php
// Load trust components
require_once $component_dir . '/trust/logo-carousel.php';
require_once $component_dir . '/trust/certification-badges.php';
require_once $component_dir . '/trust/trust-bar.php';
```

### Step 5: Documentation (0.5h)
Add to `docs/components-healthcare.md`:

```markdown
## Trust Signal Components

### Logo Carousel
```php
aitsc_render_logo_carousel([
    'logos' => [
        ['src' => '/logo1.svg', 'alt' => 'Partner 1'],
        ['src' => '/logo2.svg', 'alt' => 'Partner 2'],
    ],
    'title' => 'Trusted by leading organizations',
    'speed' => 'medium',
    'pause_on_hover' => true,
]);
```

### Certification Badges
```php
aitsc_render_certifications([
    'badges' => [
        ['type' => 'iso-27001', 'label' => 'ISO 27001'],
        ['type' => 'hipaa', 'label' => 'HIPAA'],
        ['type' => 'soc2', 'label' => 'SOC 2'],
    ],
    'layout' => 'inline',
]);
```

### Trust Bar
```php
aitsc_render_trust_bar([
    'logos' => [...],
    'stats' => [
        ['value' => '1M+', 'label' => 'Users'],
        ['value' => '50+', 'label' => 'Partners'],
    ],
    'bg' => 'secondary',
]);
```
```

---

## Todo Checklist

- [ ] Create components/trust/ directory
- [ ] Create logo-carousel.php component
- [ ] Create logo-carousel.css styles
- [ ] Add infinite scroll CSS animation
- [ ] Add grayscale to color hover effect
- [ ] Add pause on hover functionality
- [ ] Create certification-badges.php
- [ ] Create certification badges CSS
- [ ] Create trust-bar.php combined component
- [ ] Create trust-bar.css styles
- [ ] Register components in inc/components.php
- [ ] Add shortcodes for trust components
- [ ] Update documentation
- [ ] Test reduced motion preference
- [ ] Verify responsive behavior

---

## Success Criteria

1. **Logo Carousel Works** - Infinite scroll animation smooth
2. **Pause on Hover** - Animation pauses for accessibility
3. **Grayscale Effect** - Logos gray, color on hover
4. **Badges Display** - Certification badges render correctly
5. **Trust Bar Works** - Combined logos + stats work
6. **Reduced Motion** - Respects prefers-reduced-motion

---

## Risk Assessment

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|------------|
| Animation jank | Medium | Low | Use transform, will-change |
| Logo aspect ratio | Medium | Low | Object-fit: contain |
| Too many logos | Low | Low | Mask gradient fades edges |
| Accessibility | Low | High | Pause on hover, reduced motion |

---

## Rollback Procedure

1. Remove components/trust/ directory
2. Remove trust component requires from inc/components.php
3. Remove trust-related CSS files

---

## Dependencies

- Phase 1 (Design System) for CSS variables
- Phase 3 (Layout Patterns) for section styling
