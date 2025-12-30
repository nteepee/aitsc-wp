# Phase 2: Hero Component Evolution

**Parent**: [plan.md](./plan.md)
**Status**: Pending
**Priority**: High
**Estimated**: 6 hours
**Depends On**: Phase 1

---

## Context

Current hero component (`components/hero/hero-universal.php`) supports 4 variants: homepage, page, pillar, minimal. Harrison.ai requires full-width hero with large background imagery and centered text overlay.

### Current Hero Variants
| Variant | Use Case | Features |
|---------|----------|----------|
| homepage | Landing page | Particle canvas, centered text |
| page | Standard pages | Title + breadcrumb |
| pillar | Solution pages | Large title, description |
| minimal | Simple headers | Title only |

### Target Hero (Harrison.ai)
- Full-width background image
- White/gradient overlay for readability
- Centered or left-aligned headline
- Subtitle + dual CTA buttons
- Optional product mockup overlay

---

## Overview

Add new `healthcare` variant to hero-universal.php supporting full-width imagery with professional overlay treatment. Maintain backward compatibility with existing variants.

---

## Key Insights

1. **Extend, Don't Replace** - Add variant, keep existing 4 intact
2. **Image-First** - Background image is primary, not decorative
3. **Overlay Strategy** - Gradient overlay for text readability
4. **CTA Prominence** - Larger, more prominent call-to-action buttons
5. **Responsive Images** - Different crops for mobile/desktop

---

## Requirements

### Functional
- [ ] Add `healthcare` variant to hero component
- [ ] Support full-width background image with srcset
- [ ] Gradient overlay with configurable opacity
- [ ] Left/center alignment option
- [ ] Product mockup overlay support
- [ ] Responsive image handling

### Non-Functional
- [ ] Core Web Vitals: LCP < 2.5s
- [ ] No CLS from hero image loading
- [ ] Lazy loading for below-fold images only

---

## Architecture

### Component API Extension
```php
aitsc_render_hero([
    'variant' => 'healthcare',        // NEW variant
    'title' => 'AI-Powered Solutions',
    'subtitle' => 'For Healthcare Excellence',
    'description' => '...',
    'cta_primary' => 'Book a Demo',
    'cta_primary_link' => '/contact',
    'cta_secondary' => 'Learn More',
    'cta_secondary_link' => '/about',
    'image' => '/path/to/hero.jpg',
    'image_mobile' => '/path/to/hero-mobile.jpg', // NEW
    'overlay' => 'gradient-dark',     // NEW: gradient-dark|gradient-light|solid
    'alignment' => 'center',          // NEW: center|left
    'mockup_image' => '/path/to/mockup.png', // NEW: optional
]);
```

### File Changes
| File | Action | Description |
|------|--------|-------------|
| `components/hero/hero-universal.php` | MODIFY | Add healthcare variant logic |
| `components/hero/hero-variants.css` | MODIFY | Add healthcare variant styles |
| `style.css` | ADD | Healthcare hero responsive styles |

---

## Implementation Steps

### Step 1: Extend PHP Component (2h)
Add to `hero-universal.php`:

```php
// Add new defaults
$defaults = array(
    // ... existing defaults ...
    'image_mobile'  => '',
    'overlay'       => 'gradient-dark',
    'alignment'     => 'center',
    'mockup_image'  => '',
);

// Healthcare variant rendering
if ($variant === 'healthcare') {
    $overlay_class = 'aitsc-hero__overlay--' . esc_attr($args['overlay']);
    $align_class = 'aitsc-hero--align-' . esc_attr($args['alignment']);

    echo sprintf('<section class="aitsc-hero aitsc-hero--healthcare %s">', $align_class);

    // Responsive background image
    if (!empty($image)) {
        echo '<picture class="aitsc-hero__picture">';
        if (!empty($args['image_mobile'])) {
            echo sprintf('<source media="(max-width: 767px)" srcset="%s">',
                esc_url($args['image_mobile']));
        }
        echo sprintf('<img src="%s" alt="" class="aitsc-hero__bg-image" loading="eager">',
            esc_url($image));
        echo '</picture>';
    }

    // Overlay
    echo sprintf('<div class="aitsc-hero__overlay %s"></div>', $overlay_class);

    // Content container
    echo '<div class="aitsc-hero__container aitsc-hero__container--healthcare">';
    // ... title, description, CTAs ...
    echo '</div>';

    // Optional mockup
    if (!empty($args['mockup_image'])) {
        echo sprintf('<div class="aitsc-hero__mockup">
            <img src="%s" alt="Product interface" loading="lazy">
        </div>', esc_url($args['mockup_image']));
    }

    echo '</section>';
}
```

### Step 2: Add CSS Variants (2h)
Add to `components/hero/hero-variants.css`:

```css
/* Healthcare Hero Variant */
.aitsc-hero--healthcare {
  position: relative;
  min-height: 80vh;
  display: flex;
  align-items: center;
  overflow: hidden;
}

.aitsc-hero__picture {
  position: absolute;
  inset: 0;
  z-index: 0;
}

.aitsc-hero__bg-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
}

/* Overlay Variants */
.aitsc-hero__overlay--gradient-dark {
  background: linear-gradient(
    to right,
    rgba(15, 23, 42, 0.9) 0%,
    rgba(15, 23, 42, 0.7) 50%,
    rgba(15, 23, 42, 0.3) 100%
  );
}

.aitsc-hero__overlay--gradient-light {
  background: linear-gradient(
    to right,
    rgba(255, 255, 255, 0.95) 0%,
    rgba(255, 255, 255, 0.8) 50%,
    rgba(255, 255, 255, 0.4) 100%
  );
}

.aitsc-hero__overlay--solid {
  background: rgba(15, 23, 42, 0.7);
}

/* Alignment */
.aitsc-hero--align-left .aitsc-hero__container--healthcare {
  max-width: 600px;
  text-align: left;
  margin-left: 5%;
}

.aitsc-hero--align-center .aitsc-hero__container--healthcare {
  max-width: 800px;
  text-align: center;
  margin: 0 auto;
}

/* Healthcare Content Styles */
.aitsc-hero--healthcare .aitsc-hero__title {
  font-size: clamp(2.5rem, 5vw, 4rem);
  font-weight: 700;
  line-height: 1.1;
  margin-bottom: 1.5rem;
}

.aitsc-hero--healthcare .aitsc-hero__subtitle {
  font-size: clamp(1rem, 2vw, 1.25rem);
  color: var(--hai-brand-cyan);
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  margin-bottom: 1rem;
}

.aitsc-hero--healthcare .aitsc-hero__description {
  font-size: clamp(1rem, 1.5vw, 1.25rem);
  line-height: 1.6;
  margin-bottom: 2rem;
  max-width: 600px;
}

/* Healthcare CTAs */
.aitsc-hero--healthcare .aitsc-hero__ctas {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.aitsc-hero--healthcare .aitsc-btn--primary {
  background: var(--hai-brand-green);
  color: white;
  padding: 1rem 2rem;
  font-weight: 600;
  border-radius: 8px;
  transition: all 0.2s ease;
}

.aitsc-hero--healthcare .aitsc-btn--primary:hover {
  background: #047857;
  transform: translateY(-2px);
}

/* Mockup Overlay */
.aitsc-hero__mockup {
  position: absolute;
  right: 5%;
  bottom: -10%;
  width: 45%;
  max-width: 600px;
  z-index: 5;
}

.aitsc-hero__mockup img {
  width: 100%;
  height: auto;
  filter: drop-shadow(0 25px 50px rgba(0,0,0,0.3));
}
```

### Step 3: Responsive Styles (1.5h)
```css
/* Tablet */
@media (max-width: 991px) {
  .aitsc-hero--healthcare {
    min-height: 70vh;
  }

  .aitsc-hero__mockup {
    display: none;
  }

  .aitsc-hero--align-left .aitsc-hero__container--healthcare {
    max-width: 80%;
    margin: 0 auto;
    text-align: center;
  }
}

/* Mobile */
@media (max-width: 767px) {
  .aitsc-hero--healthcare {
    min-height: 60vh;
  }

  .aitsc-hero--healthcare .aitsc-hero__ctas {
    flex-direction: column;
  }

  .aitsc-hero--healthcare .aitsc-btn--primary,
  .aitsc-hero--healthcare .aitsc-btn--secondary {
    width: 100%;
    justify-content: center;
  }
}
```

### Step 4: Light Theme Integration (0.5h)
```css
[data-theme="light"] .aitsc-hero--healthcare .aitsc-hero__title {
  color: var(--hai-text-primary);
}

[data-theme="light"] .aitsc-hero--healthcare .aitsc-hero__overlay--gradient-light {
  background: linear-gradient(
    to right,
    rgba(248, 250, 252, 0.95) 0%,
    rgba(248, 250, 252, 0.7) 50%,
    transparent 100%
  );
}
```

---

## Todo Checklist

- [ ] Add new defaults to hero-universal.php
- [ ] Add healthcare variant rendering logic
- [ ] Create responsive picture element support
- [ ] Add overlay variant CSS (gradient-dark/light/solid)
- [ ] Add alignment variant CSS
- [ ] Style healthcare CTAs
- [ ] Add mockup overlay CSS
- [ ] Add responsive breakpoints
- [ ] Light theme integration
- [ ] Test with actual healthcare imagery
- [ ] Verify LCP < 2.5s
- [ ] Verify no CLS

---

## Success Criteria

1. **New Variant Works** - `healthcare` variant renders correctly
2. **Responsive Images** - Mobile/desktop srcset works
3. **Overlay Readable** - Text legible over any image
4. **CTA Prominent** - Green CTA stands out
5. **No Regression** - Existing 4 variants unchanged
6. **Performance** - LCP < 2.5s, no CLS

---

## Risk Assessment

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|------------|
| LCP regression | Medium | High | Use loading="eager", optimize images |
| CLS from image | Medium | Medium | Set aspect-ratio in CSS |
| Overlay contrast | Low | Medium | Test with various images |
| Mockup complexity | Low | Low | Make mockup optional |

---

## Rollback Procedure

1. Remove healthcare variant case from PHP
2. Remove healthcare CSS from hero-variants.css
3. Component API additions are backward compatible (no removal needed)

---

## Dependencies

- Phase 1 (Design System) must be complete for light theme integration
