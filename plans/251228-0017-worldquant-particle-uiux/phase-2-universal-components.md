# Phase 2: Universal Component System

**Status**: Ready for Implementation
**Estimated Effort**: 18 hours
**Priority**: P1 (Foundation for Phase 3)
**Dependencies**: Phase 1 Complete ✅

---

## Objective

Build reusable component architecture that powers all cards, heroes, CTAs, and content sections across the entire site. Single implementation, multiple variants.

**No Content Changes** - Pure technical architecture work.

---

## Components to Build

### 1. Universal Card Component (6 hours)

**File**: `wp-content/themes/aitsc-pro-theme/components/card/card-base.php`

**Purpose**: Single component powers solution cards, case study cards, blog cards, service cards

**Variants**:
- `glass` - Glassmorphism with backdrop-filter
- `solid` - Solid background with shadow
- `outlined` - Border-only with hover fill
- `image` - Card with featured image
- `icon` - Card with icon (Material Symbols)

**Parameters**:
```php
<?php
/**
 * Universal Card Component
 *
 * @param array $args {
 *     Card configuration
 *     @type string $variant    'glass'|'solid'|'outlined'|'image'|'icon'
 *     @type string $title      Card title (required)
 *     @type string $description Card description text
 *     @type string $link       Card URL
 *     @type string $icon       Material Symbol icon name (for icon variant)
 *     @type string $image      Image URL (for image variant)
 *     @type string $cta_text   CTA button text (default: "Learn More")
 *     @type string $size       'small'|'medium'|'large' (default: 'medium')
 *     @type array  $custom_class Additional CSS classes
 * }
 */
function aitsc_render_card($args = array()) {
    // Component implementation
}
```

**Usage Examples**:
```php
// Solution card on homepage
aitsc_render_card([
    'variant' => 'glass',
    'icon' => 'memory',
    'title' => 'Custom PCB Design',
    'description' => 'End-to-end PCB design from schematic to production.',
    'link' => home_url('/solutions/custom-pcb-design'),
    'size' => 'large'
]);

// Case study card
aitsc_render_card([
    'variant' => 'image',
    'image' => get_the_post_thumbnail_url(),
    'title' => get_the_title(),
    'description' => get_the_excerpt(),
    'link' => get_permalink(),
    'cta_text' => 'Read Case Study'
]);

// Blog post card
aitsc_render_card([
    'variant' => 'solid',
    'title' => get_the_title(),
    'description' => get_the_excerpt(),
    'link' => get_permalink(),
    'cta_text' => 'Read Article'
]);
```

**CSS Structure**:
```css
/* Base card styles */
.aitsc-card {
    /* Common properties */
}

/* Variants */
.aitsc-card--glass { /* Glassmorphism */ }
.aitsc-card--solid { /* Solid background */ }
.aitsc-card--outlined { /* Border only */ }
.aitsc-card--image { /* With featured image */ }
.aitsc-card--icon { /* Icon-based */ }

/* Sizes */
.aitsc-card--small { /* Compact */ }
.aitsc-card--medium { /* Default */ }
.aitsc-card--large { /* Expanded */ }

/* Hover effects */
.aitsc-card:hover { /* 3D tilt, shimmer, glassmorphism */ }
```

**Files to Create**:
- `components/card/card-base.php` - Main component
- `components/card/card-variants.css` - Variant styles
- `components/card/card-animations.css` - Hover effects

---

### 2. Universal Hero Component (5 hours)

**File**: `wp-content/themes/aitsc-pro-theme/components/hero/hero-universal.php`

**Purpose**: Single hero component for homepage, category pages, pillar pages, about, contact

**Variants**:
- `homepage` - Large hero with particle background, centered content
- `page` - Standard page hero with background gradient
- `pillar` - Product pillar page hero with CTA
- `minimal` - Simple title + breadcrumb

**Parameters**:
```php
<?php
/**
 * Universal Hero Component
 *
 * @param array $args {
 *     Hero configuration
 *     @type string $variant      'homepage'|'page'|'pillar'|'minimal'
 *     @type string $title        Hero title (required)
 *     @type string $subtitle     Subtitle/tagline
 *     @type string $description  Description text
 *     @type string $cta_primary  Primary CTA text
 *     @type string $cta_primary_link Primary CTA URL
 *     @type string $cta_secondary Secondary CTA text
 *     @type string $cta_secondary_link Secondary CTA URL
 *     @type string $image        Background/featured image URL
 *     @type bool   $show_breadcrumb Show breadcrumb navigation
 *     @type string $height       'small'|'medium'|'large'|'full' (default: 'large')
 * }
 */
function aitsc_render_hero($args = array()) {
    // Component implementation
}
```

**Usage Examples**:
```php
// Homepage hero
aitsc_render_hero([
    'variant' => 'homepage',
    'title' => 'ELECTRONICS SOFTWARE<br>& AI SOLUTIONS',
    'subtitle' => 'Innovation. Precision. Technology.',
    'description' => 'Solving Your Most Expensive Problems',
    'cta_primary' => 'View Solutions',
    'cta_primary_link' => home_url('/solutions/'),
    'cta_secondary' => 'Free Tech Review',
    'cta_secondary_link' => home_url('/contact/'),
    'height' => 'full'
]);

// Fleet Safe Pro pillar page hero
aitsc_render_hero([
    'variant' => 'pillar',
    'title' => 'Fleet Safe Pro',
    'subtitle' => 'The Most Advanced Passenger Monitoring Solution',
    'description' => 'Real-time seatbelt monitoring, compliance reporting, and driver alerts',
    'cta_primary' => 'Request Demo',
    'cta_primary_link' => '#demo-form',
    'cta_secondary' => 'View Technical Specs',
    'cta_secondary_link' => '#specifications',
    'image' => get_template_directory_uri() . '/assets/images/fleet-safe-pro-hero.jpg',
    'height' => 'large'
]);

// Category page hero
aitsc_render_hero([
    'variant' => 'page',
    'title' => 'Passenger Monitoring Systems',
    'subtitle' => 'Advanced Safety Solutions for Transport Fleets',
    'show_breadcrumb' => true,
    'height' => 'medium'
]);
```

**Files to Create**:
- `components/hero/hero-universal.php` - Main component
- `components/hero/hero-variants.css` - Variant styles
- `components/hero/hero-animations.css` - Animations

---

### 3. CTA Component (3 hours)

**File**: `wp-content/themes/aitsc-pro-theme/components/cta/cta-block.php`

**Purpose**: Reusable call-to-action sections (forms, buttons, banners)

**Variants**:
- `form` - Contact form CTA (native WordPress form placeholder)
- `button` - Button CTA with icon
- `banner` - Full-width CTA banner with background
- `inline` - Inline CTA within content

**Parameters**:
```php
<?php
/**
 * CTA Component
 *
 * @param array $args {
 *     CTA configuration
 *     @type string $variant   'form'|'button'|'banner'|'inline'
 *     @type string $title     CTA title
 *     @type string $description Description text
 *     @type string $button_text Button text
 *     @type string $button_link Button URL
 *     @type string $form_id   WordPress form shortcode (for form variant)
 *     @type string $background Background color/gradient
 * }
 */
function aitsc_render_cta($args = array()) {
    // Component implementation
}
```

**Usage Examples**:
```php
// Form CTA (Fleet Safe Pro demo request)
aitsc_render_cta([
    'variant' => 'form',
    'title' => 'Request a Fleet Safe Pro Demo',
    'description' => 'See how real-time passenger monitoring can improve fleet safety compliance',
    'form_id' => 'contact-form-7' // Placeholder for HubSpot later
]);

// Button CTA
aitsc_render_cta([
    'variant' => 'button',
    'title' => 'Ready to Get Started?',
    'button_text' => 'Free Tech Review',
    'button_link' => home_url('/contact/')
]);

// Banner CTA
aitsc_render_cta([
    'variant' => 'banner',
    'title' => 'Solving Your Most Expensive Problems',
    'description' => 'Free onsite tech review to identify costly operational bottlenecks',
    'button_text' => 'Schedule Review',
    'button_link' => home_url('/contact/'),
    'background' => 'linear-gradient(135deg, #005cb2, #001a33)'
]);
```

**Files to Create**:
- `components/cta/cta-block.php` - Main component
- `components/cta/cta-styles.css` - Styles
- `components/cta/form-placeholder.php` - Native WordPress form (HubSpot placeholder)

---

### 4. Stats Counter Component (2 hours)

**File**: `wp-content/themes/aitsc-pro-theme/components/stats/stats-counter.php`

**Purpose**: Animated statistics counter (projects, years, industries, etc.)

**Note**: User has NO stats data currently - component built for future use

**Parameters**:
```php
<?php
/**
 * Stats Counter Component
 *
 * @param array $stats {
 *     Array of statistics
 *     @type array $stat {
 *         @type int    $number Statistic number
 *         @type string $label  Statistic label
 *         @type string $suffix Suffix (e.g., '+', '%', 'K')
 *     }
 * }
 */
function aitsc_render_stats($stats = array()) {
    // Component implementation with count-up animation
}
```

**Usage Example** (for future when stats available):
```php
aitsc_render_stats([
    ['number' => 150, 'label' => 'Projects Completed', 'suffix' => '+'],
    ['number' => 10, 'label' => 'Years Experience', 'suffix' => '+'],
    ['number' => 25, 'label' => 'Industries Served', 'suffix' => '+'],
    ['number' => 98, 'label' => 'Client Satisfaction', 'suffix' => '%']
]);
```

**Files to Create**:
- `components/stats/stats-counter.php` - Main component
- `components/stats/stats-counter.js` - Count-up animation (Intersection Observer)
- `components/stats/stats-styles.css` - Styles

**Current Implementation**: Create component structure, add placeholder comment "Stats data pending - component ready for integration"

---

### 5. Testimonial Carousel Component (2 hours)

**File**: `wp-content/themes/aitsc-pro-theme/components/testimonial/testimonial-carousel.php`

**Purpose**: Client testimonial slider

**Note**: User has NO testimonials currently - component built for future use

**Parameters**:
```php
<?php
/**
 * Testimonial Carousel Component
 *
 * @param array $testimonials {
 *     Array of testimonials
 *     @type array $testimonial {
 *         @type string $quote    Testimonial text
 *         @type string $author   Author name
 *         @type string $company  Company name
 *         @type string $role     Author role/title
 *         @type string $image    Author headshot URL
 *     }
 * }
 */
function aitsc_render_testimonials($testimonials = array()) {
    // Component implementation with carousel
}
```

**Usage Example** (for future when testimonials available):
```php
aitsc_render_testimonials([
    [
        'quote' => 'AITSC delivered a custom PCB solution that exceeded our expectations.',
        'author' => 'John Smith',
        'company' => 'Tech Corp',
        'role' => 'Engineering Manager',
        'image' => 'https://example.com/headshot.jpg'
    ]
]);
```

**Files to Create**:
- `components/testimonial/testimonial-carousel.php` - Main component
- `components/testimonial/carousel.js` - Carousel logic (vanilla JS)
- `components/testimonial/carousel-styles.css` - Styles

**Current Implementation**: Create component structure, add placeholder comment "Testimonials pending - component ready for integration"

---

## Template Consolidation

### Before (19 template-parts files):
```
template-parts/
├── case-studies-preview.php
├── contact-form-advanced.php
├── content-case-studies-enhanced.php
├── content-case-studies.php
├── content-none.php
├── content-solutions-enhanced.php
├── content-solutions.php
├── content.php
├── cta-advanced.php
├── hero-advanced.php
├── hero-mobile-optimized.php
├── navigation.php
├── services-mobile-optimized.php
├── single-case-studies.php
├── single-solutions.php
├── solutions-showcase.php
├── stats-section.php
├── testimonials.php
└── theme-toggle.php
```

### After (Use universal components):
```
components/
├── card/
│   ├── card-base.php (replaces: content-*.php, solutions-showcase.php)
│   ├── card-variants.css
│   └── card-animations.css
├── hero/
│   ├── hero-universal.php (replaces: hero-*.php)
│   ├── hero-variants.css
│   └── hero-animations.css
├── cta/
│   ├── cta-block.php (replaces: cta-advanced.php, contact-form-advanced.php)
│   ├── cta-styles.css
│   └── form-placeholder.php
├── stats/
│   ├── stats-counter.php (replaces: stats-section.php)
│   ├── stats-counter.js
│   └── stats-styles.css
└── testimonial/
    ├── testimonial-carousel.php (replaces: testimonials.php)
    ├── carousel.js
    └── carousel-styles.css

template-parts/ (KEEP only these)
├── content-none.php (404/no results)
├── navigation.php (menu structure)
└── theme-toggle.php (dark mode - if keeping)
```

---

## Component Registration & Enqueuing

**File**: `wp-content/themes/aitsc-pro-theme/inc/components.php` (NEW)

```php
<?php
/**
 * Component System Registration
 *
 * @package AITSC_Pro_Theme
 * @since 3.1.0
 */

// Register component autoloader
spl_autoload_register(function($class) {
    if (strpos($class, 'AITSC_Component_') === 0) {
        $component = strtolower(str_replace('AITSC_Component_', '', $class));
        $file = get_template_directory() . '/components/' . $component . '/' . $component . '-base.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
});

// Enqueue component styles
function aitsc_enqueue_component_styles() {
    $components = ['card', 'hero', 'cta', 'stats', 'testimonial'];

    foreach ($components as $component) {
        $css_file = get_template_directory() . '/components/' . $component . '/' . $component . '-styles.css';
        if (file_exists($css_file)) {
            wp_enqueue_style(
                'aitsc-component-' . $component,
                get_template_directory_uri() . '/components/' . $component . '/' . $component . '-styles.css',
                array(),
                AITSC_VERSION
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'aitsc_enqueue_component_styles');

// Enqueue component scripts
function aitsc_enqueue_component_scripts() {
    $components = ['stats', 'testimonial'];

    foreach ($components as $component) {
        $js_file = get_template_directory() . '/components/' . $component . '/' . $component . '.js';
        if (file_exists($js_file)) {
            wp_enqueue_script(
                'aitsc-component-' . $component,
                get_template_directory_uri() . '/components/' . $component . '/' . $component . '.js',
                array(),
                AITSC_VERSION,
                true
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'aitsc_enqueue_component_scripts');
```

**Add to functions.php**:
```php
// Component System
require_once get_template_directory() . '/inc/components.php';
```

---

## Testing Requirements

### Component Testing

1. **Card Component**:
   - [ ] Test all 5 variants (glass, solid, outlined, image, icon)
   - [ ] Test all 3 sizes (small, medium, large)
   - [ ] Verify hover effects (3D tilt, glassmorphism, shimmer)
   - [ ] Test on solution cards, case study cards, blog cards
   - [ ] Verify responsive behavior (mobile, tablet, desktop)

2. **Hero Component**:
   - [ ] Test all 4 variants (homepage, page, pillar, minimal)
   - [ ] Test all 4 heights (small, medium, large, full)
   - [ ] Verify particle background integration (homepage variant)
   - [ ] Test breadcrumb display
   - [ ] Verify CTA buttons (primary, secondary)

3. **CTA Component**:
   - [ ] Test all 4 variants (form, button, banner, inline)
   - [ ] Verify form placeholder works (Contact Form 7 or native)
   - [ ] Test button links and hover states
   - [ ] Verify banner background gradients

4. **Stats Counter**:
   - [ ] Verify count-up animation triggers on scroll (Intersection Observer)
   - [ ] Test with placeholder data
   - [ ] Verify suffix display (+, %, K)

5. **Testimonial Carousel**:
   - [ ] Test carousel navigation (prev/next)
   - [ ] Verify auto-play (if enabled)
   - [ ] Test with placeholder data
   - [ ] Verify responsive behavior

### Integration Testing

- [ ] Replace homepage solution cards with universal card component
- [ ] Replace homepage hero with universal hero component
- [ ] Add CTA component to contact page
- [ ] Verify all components work together without conflicts
- [ ] Test component CSS isolation (no style bleeding)

### Performance Testing

- [ ] Verify component CSS is optimized (no duplicates)
- [ ] Test component JS performance (no blocking)
- [ ] Verify lazy loading for images in components
- [ ] Test on mobile devices (performance impact)

---

## Files to Create (Summary)

### Component Files (15 new files):
```
components/
├── card/
│   ├── card-base.php ✅
│   ├── card-variants.css ✅
│   └── card-animations.css ✅
├── hero/
│   ├── hero-universal.php ✅
│   ├── hero-variants.css ✅
│   └── hero-animations.css ✅
├── cta/
│   ├── cta-block.php ✅
│   ├── cta-styles.css ✅
│   └── form-placeholder.php ✅
├── stats/
│   ├── stats-counter.php ✅
│   ├── stats-counter.js ✅
│   └── stats-styles.css ✅
└── testimonial/
    ├── testimonial-carousel.php ✅
    ├── carousel.js ✅
    └── carousel-styles.css ✅
```

### System Files (1 new file):
```
inc/
└── components.php ✅ (Component registration & enqueuing)
```

### Files to Modify (1):
```
functions.php (add component system require)
```

---

## Success Criteria

- [ ] All 5 components built and functional
- [ ] Component system registered and enqueuing correctly
- [ ] 19 template-parts consolidated to 3 + components
- [ ] All variants working for each component
- [ ] Hover effects and animations smooth (60fps)
- [ ] Components responsive across all breakpoints
- [ ] No CSS conflicts or style bleeding
- [ ] Component architecture documented
- [ ] Ready for Phase 3 content integration

---

## Notes for Implementation

1. **YAGNI Principle**: Build only what's needed, no over-engineering
2. **DRY Principle**: Single source of truth for each component
3. **KISS Principle**: Keep implementation simple and maintainable
4. **Performance**: Optimize CSS/JS, lazy load images, use CSS variables
5. **Accessibility**: WCAG 2.1 AA compliance, keyboard navigation, ARIA labels
6. **Documentation**: Comment all component parameters and usage examples

---

**Next Phase**: Phase 3 - Content Extraction & Integration (Fleet Safe Pro pillar page priority)
