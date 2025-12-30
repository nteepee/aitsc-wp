# Component Mapping: Harrison.ai to AITSC

## Mapping Strategy

Map Harrison.ai design patterns to existing AITSC universal components, adding white variants where needed.

---

## Component Mapping Table

| Harrison.ai Component | AITSC Component | Action | New Variant |
|----------------------|-----------------|--------|-------------|
| Hero (full-width photo bg) | `hero-universal.php` | ADD VARIANT | `white-fullwidth` |
| Navigation (white bg, blue CTA) | `header.php` | MODIFY | White theme |
| Three-column feature cards | `card-base.php` | ADD VARIANT | `white-feature` |
| Product showcase card | `card-base.php` | ADD VARIANT | `white-product` |
| Trust bar + text | NEW | CREATE | `trust-bar.php` |
| Logo carousel | NEW | CREATE | `logo-carousel.php` |
| Floating image composition | NEW | CREATE | `image-composition.php` |
| Stats in body copy | `stats-counter.php` | ADD VARIANT | `inline-text` |
| CTA section | `cta-block.php` | ADD VARIANT | `white-cta` |
| Testimonial | `testimonial-carousel.php` | ADD VARIANT | `white-testimonial` |

---

## Existing Components Analysis

### 1. Card Component (`card-base.php`)

**Current Variants**: glass, solid, outlined, image, icon, solution, blog

**New White Variants Needed**:

```php
// white-feature - Three-column feature card
'white-feature' => [
    'bg' => '#FFFFFF',
    'border' => '1px solid #E2E8F0',
    'shadow' => '0 4px 6px -1px rgba(0,0,0,0.1)',
    'image_position' => 'top',
    'icon_style' => 'below-image',
    'hover' => 'shadow-lg + translateY(-4px)'
]

// white-product - Product showcase card
'white-product' => [
    'bg' => '#F8FAFC',
    'border' => 'none',
    'layout' => 'horizontal',
    'image_style' => 'dark-ui-mockup',
    'cta_style' => 'text-link-arrow'
]
```

### 2. Hero Component (`hero-universal.php`)

**Current Variants**: homepage, page, pillar, minimal

**New White Variants Needed**:

```php
// white-fullwidth - Full photo background with white text overlay
'white-fullwidth' => [
    'bg_type' => 'image',
    'overlay' => 'linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.5))',
    'text_color' => '#FFFFFF',
    'text_align' => 'center',
    'headline_size' => '48-72px',
    'cta_style' => 'white-bg-blue-text'
]

// white-split - Two-column with image
'white-split' => [
    'bg' => '#FFFFFF',
    'layout' => '50/50',
    'text_color' => '#1E293B',
    'image_position' => 'right'
]
```

### 3. Stats Component (`stats-counter.php`)

**Current**: Standalone counter blocks

**New Variant Needed**:

```php
// inline-text - Stats embedded in body copy
'inline-text' => [
    'display' => 'inline',
    'number_size' => '2.5rem',
    'number_weight' => '700',
    'number_color' => '#005cb2',
    'label_style' => 'suffix-text'
]
```

---

## New Components Required

### 1. Trust Bar (`components/trust-bar/trust-bar.php`)

**Purpose**: Display trust statement with centered text

**API**:
```php
aitsc_render_trust_bar([
    'text' => 'Trusted by leading organizations...',
    'variant' => 'default|minimal',
    'background' => '#FFFFFF|#F8FAFC'
]);
```

**HTML Structure**:
```html
<div class="aitsc-trust-bar">
    <div class="aitsc-trust-bar__container">
        <p class="aitsc-trust-bar__text">...</p>
    </div>
</div>
```

### 2. Logo Carousel (`components/logo-carousel/logo-carousel.php`)

**Purpose**: Auto-scrolling partner/client logos

**API**:
```php
aitsc_render_logo_carousel([
    'logos' => [
        ['src' => '...', 'alt' => '...', 'link' => '...'],
    ],
    'speed' => 30, // seconds
    'grayscale' => true,
    'pause_on_hover' => true
]);
```

**HTML Structure**:
```html
<div class="aitsc-logo-carousel">
    <div class="aitsc-logo-carousel__track">
        <div class="aitsc-logo-carousel__slide">
            <img src="..." alt="..." />
        </div>
        <!-- Duplicated for infinite scroll -->
    </div>
</div>
```

### 3. Image Composition (`components/image-composition/image-composition.php`)

**Purpose**: Floating overlapping images (Harrison.ai mission section style)

**API**:
```php
aitsc_render_image_composition([
    'images' => [
        ['src' => '...', 'position' => 'top-left', 'size' => 'large'],
        ['src' => '...', 'position' => 'bottom-right', 'size' => 'medium'],
    ],
    'layout' => 'stacked|scattered',
    'animation' => 'float|none'
]);
```

---

## Component Variant CSS Classes

### Card White Variants

```css
.aitsc-card--white-feature {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
}

.aitsc-card--white-feature:hover {
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    transform: translateY(-4px);
}

.aitsc-card--white-product {
    background: #F8FAFC;
    border-radius: 16px;
}
```

### Hero White Variants

```css
.aitsc-hero--white-fullwidth {
    min-height: 70vh;
    background-size: cover;
    background-position: center;
}

.aitsc-hero--white-fullwidth .aitsc-hero__overlay {
    background: linear-gradient(
        180deg,
        rgba(0,0,0,0.2) 0%,
        rgba(0,0,0,0.5) 100%
    );
}

.aitsc-hero--white-fullwidth .aitsc-hero__title {
    font-size: clamp(2.5rem, 5vw, 4.5rem);
    color: #FFFFFF;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}
```

---

## Migration Priority

1. **Critical** (Phase 1-2): Card white-feature, Hero white-fullwidth
2. **High** (Phase 3): Logo Carousel, Trust Bar
3. **Medium** (Phase 4): Image Composition, Stats inline-text
4. **Low**: Additional refinements

---

## Backward Compatibility

All existing variant names remain functional:
- `glass`, `solid`, `outlined` - Still work
- `homepage`, `page`, `pillar` - Still work

New variants are additive, not replacement.
