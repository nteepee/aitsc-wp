# Phase 02: Architecture Design

**Context**: [Phase 01 Research](./phase-01-research-analysis.md) | [Plan Overview](./plan.md)
**Date**: 2026-01-04
**Priority**: High
**Status**: Planning

---

## Overview

Design the technical architecture for a universal paper stack scroll effect system, defining component structure, data flow, WordPress integration patterns, and performance optimization strategies.

---

## System Architecture

### Component Structure

```
/wp-content/themes/aitsc-pro-theme/
├── components/
│   └── paper-stack/
│       ├── paper-stack.php           # Component template (PHP)
│       ├── paper-stack.css           # Component styles (CSS)
│       ├── paper-stack.js            # Fallback logic (JS)
│       └── README.md                 # Component documentation
├── inc/
│   └── paper-stack-config.php        # WordPress integration
├── assets/js/
│   └── paper-stack-fallback.js       # Intersection Observer fallback
└── style.css                         # Global paper stack styles
```

### Data Flow

```
WordPress Admin/ACF
    ↓
Configuration Array (paper-stack-config.php)
    ↓
Component Template (paper-stack.php)
    ↓
CSS Animations (paper-stack.css) ← Primary Path
    ↓
Intersection Observer (paper-stack.js) ← Fallback Path
    ↓
DOM Updates (is-visible class)
```

---

## Component Design

### 1. PHP Component Template (`paper-stack.php`)

**Purpose**: WordPress integration wrapper, ACF field handling

```php
<?php
/**
 * Paper Stack Scroll Component
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render paper stack wrapper
 *
 * @param array $args Configuration arguments
 */
function aitsc_paper_stack($args = []) {
    $defaults = [
        'enabled' => true,
        'distance' => '100px',
        'duration' => '0.6s',
        'easing' => 'ease-out',
        'delay' => '0s',
        'class' => '',
        'id' => ''
    ];

    $args = wp_parse_args($args, $defaults);

    if (!$args['enabled']) {
        return; // Component disabled
    }

    $wrapper_classes = ['aitsc-paper-stack-wrapper'];
    if (!empty($args['class'])) {
        $wrapper_classes[] = esc_attr($args['class']);
    }

    $wrapper_id = !empty($args['id']) ? esc_attr($args['id']) : 'paper-stack-' . uniqid();

    // Output opening wrapper
    printf(
        '<div id="%s" class="%s" data-paper-stack>',
        $wrapper_id,
        implode(' ', $wrapper_classes)
    );

    // Output configuration as data attributes
    printf(
        ' data-distance="%s" data-duration="%s" data-easing="%s" data-delay="%s"',
        esc_attr($args['distance']),
        esc_attr($args['duration']),
        esc_attr($args['easing']),
        esc_attr($args['delay'])
    );

    echo '>';
}

/**
 * Close paper stack wrapper
 */
function aitsc_paper_stack_end() {
    echo '</div>';
}
```

**Usage in Templates**:
```php
<?php aitsc_paper_stack(['enabled' => true, 'distance' => '150px']); ?>
  <section class="paper-stack-section">
    <h2>Section Content</h2>
  </section>
<?php aitsc_paper_stack_end(); ?>
```

### 2. CSS Component Styles (`paper-stack.css`)

**Purpose**: Native Scroll-Driven Animations + Progressive Enhancement

```css
/**
 * Paper Stack Scroll Animations
 * Uses CSS Scroll-Driven Animations (2025) with Intersection Observer fallback
 */

/* Base wrapper styles */
.aitsc-paper-stack-wrapper {
    position: relative;
    z-index: 1;
}

/* Paper stack sections */
.paper-stack-section {
    position: relative;
    contain: layout style paint; /* Isolate repaints */
    transform: translateZ(0); /* Force GPU layer */
    will-change: transform; /* Optimization hint */
}

/* ==========================================================================
   NATIVE CSS SCROLL-DRIVEN ANIMATIONS (Primary - 2025)
   ========================================================================== */

@supports (animation-timeline: view()) {
    .paper-stack-section {
        transform: translateY(var(--paper-stack-distance, 100px));
        animation: paper-stack-slide var(--paper-stack-duration, 0.6s) var(--paper-stack-easing, ease-out) both;
        animation-timeline: view();
        animation-range: entry 10% cover 50%;
    }

    @keyframes paper-stack-slide {
        to {
            transform: translateY(0);
        }
    }

    /* Remove will-change after animation */
    .paper-stack-section.animation-complete {
        will-change: auto;
    }
}

/* ==========================================================================
   INTERSECTION OBSERVER FALLBACK (Legacy)
   ========================================================================== */

@supports not (animation-timeline: view()) {
    .paper-stack-section {
        opacity: 0;
        transform: translateY(var(--paper-stack-distance, 100px));
        transition: opacity var(--paper-stack-duration, 0.6s) var(--paper-stack-easing, ease-out) var(--paper-stack-delay, 0s),
                    transform var(--paper-stack-duration, 0.6s) var(--paper-stack-easing, ease-out) var(--paper-stack-delay, 0s);
    }

    .paper-stack-section.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Stagger effect for multiple sections */
    .paper-stack-section:nth-child(1) { --paper-stack-delay: 0.0s; }
    .paper-stack-section:nth-child(2) { --paper-stack-delay: 0.1s; }
    .paper-stack-section:nth-child(3) { --paper-stack-delay: 0.2s; }
    .paper-stack-section:nth-child(4) { --paper-stack-delay: 0.3s; }
    .paper-stack-section:nth-child(5) { --paper-stack-delay: 0.4s; }
}

/* ==========================================================================
   ACCESSIBILITY (prefers-reduced-motion)
   ========================================================================== */

@media (prefers-reduced-motion: reduce) {
    .paper-stack-section {
        opacity: 1 !important;
        transform: none !important;
        transition: none !important;
        animation: none !important;
        will-change: auto !important;
    }
}

/* ==========================================================================
   RESPONSIVE VARIANTS
   ========================================================================== */

/* Mobile: Reduced distance */
@media (max-width: 767px) {
    @supports (animation-timeline: view()) {
        .paper-stack-section {
            --paper-stack-distance: 50px;
            --paper-stack-duration: 0.4s;
        }
    }

    @supports not (animation-timeline: view()) {
        .paper-stack-section {
            --paper-stack-distance: 50px;
            --paper-stack-duration: 0.4s;
        }
    }
}

/* Tablet: Medium distance */
@media (min-width: 768px) and (max-width: 991px) {
    @supports (animation-timeline: view()) {
        .paper-stack-section {
            --paper-stack-distance: 75px;
            --paper-stack-duration: 0.5s;
        }
    }
}

/* Desktop: Full distance */
@media (min-width: 992px) {
    @supports (animation-timeline: view()) {
        .paper-stack-section {
            --paper-stack-distance: 100px;
            --paper-stack-duration: 0.6s;
        }
    }
}
```

### 3. JavaScript Fallback (`paper-stack.js`)

**Purpose**: Intersection Observer for legacy browsers

```javascript
/**
 * Paper Stack Fallback (Intersection Observer)
 * Used only when CSS Scroll-Driven Animations are not supported
 *
 * @package AITSC_Pro_Theme
 */

(function() {
    'use strict';

    // Check if native support exists
    const supportsNativeCSS = CSS.supports('animation-timeline', 'view()');

    if (supportsNativeCSS) {
        return; // Use native CSS, no JS needed
    }

    // Intersection Observer configuration
    const observerOptions = {
        root: null,
        rootMargin: '0px 0px -50px 0px', // Trigger 50px before viewport entry
        threshold: 0.1
    };

    // Create Intersection Observer
    const paperStackObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const section = entry.target;

                // Apply custom delay if specified
                const delay = section.dataset.delay || '0s';
                section.style.transitionDelay = delay;

                // Add visible class
                section.classList.add('is-visible');

                // Unobserve after animation (one-time trigger)
                setTimeout(() => {
                    paperStackObserver.unobserve(section);
                    section.classList.add('animation-complete');
                }, parseFloat(delay) * 1000 + 600);
            }
        });
    }, observerOptions);

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', () => {
        // Observe all paper stack sections
        const sections = document.querySelectorAll('.paper-stack-section');
        sections.forEach(section => paperStackObserver.observe(section));

        // Respect prefers-reduced-motion
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            sections.forEach(section => {
                section.classList.add('is-visible');
                paperStackObserver.unobserve(section);
            });
        }
    });

})();
```

---

## WordPress Integration

### 1. Configuration System (`inc/paper-stack-config.php`)

**Purpose**: Admin settings, ACF integration

```php
<?php
/**
 * Paper Stack Configuration
 *
 * @package AITSC_Pro_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get paper stack configuration
 *
 * @return array Configuration array
 */
function aitsc_get_paper_stack_config() {
    $defaults = [
        'enabled' => true,
        'distance' => '100px',
        'duration' => '0.6s',
        'easing' => 'ease-out',
        'delay' => '0s'
    ];

    // Check if ACF is active
    if (function_exists('get_field')) {
        $acf_config = get_field('paper_stack_settings', 'option');
        if ($acf_config) {
            return wp_parse_args($acf_config, $defaults);
        }
    }

    // Check theme mod
    $theme_mod = get_theme_mod('paper_stack_settings');
    if ($theme_mod) {
        return wp_parse_args($theme_mod, $defaults);
    }

    return apply_filters('aitsc_paper_stack_config', $defaults);
}

/**
 * Enqueue paper stack assets
 */
function aitsc_enqueue_paper_stack() {
    $config = aitsc_get_paper_stack_config();

    if (!$config['enabled']) {
        return;
    }

    // Enqueue component styles
    wp_enqueue_style(
        'aitsc-paper-stack',
        get_template_directory_uri() . '/components/paper-stack/paper-stack.css',
        array(),
        AITSC_VERSION
    );

    // Enqueue fallback JS
    wp_enqueue_script(
        'aitsc-paper-stack-fallback',
        get_template_directory_uri() . '/assets/js/paper-stack-fallback.js',
        array(),
        AITSC_VERSION,
        true
    );

    // Pass configuration to JavaScript
    wp_localize_script('aitsc-paper-stack-fallback', 'paperStackConfig', $config);
}
add_action('wp_enqueue_scripts', 'aitsc_enqueue_paper_stack');
```

### 2. Template Integration Pattern

**Single Solution Pages** (`single-solutions.php`):
```php
<?php get_header(); ?>

<?php
// Enable paper stack for solution pages
aitsc_paper_stack([
    'enabled' => true,
    'distance' => '120px',
    'duration' => '0.7s'
]);
?>

<main class="solution-content">
    <?php while (have_posts()) : the_post(); ?>
        <article class="paper-stack-section">
            <?php get_template_part('template-parts/solution/overview'); ?>
        </article>

        <article class="paper-stack-section">
            <?php get_template_part('template-parts/solution/specs'); ?>
        </article>

        <article class="paper-stack-section">
            <?php get_template_part('template-parts/solution/gallery'); ?>
        </article>
    <?php endwhile; ?>
</main>

<?php aitsc_paper_stack_end(); ?>
<?php get_footer(); ?>
```

**Pillar Pages** (`page-fleet-safe-pro.php`):
```php
<?php
// Conditional paper stack based on ACF field
$enable_paper_stack = get_field('enable_paper_stack');
if ($enable_paper_stack) {
    aitsc_paper_stack(['distance' => '100px']);
}
?>

<!-- Page content -->

<?php
if ($enable_paper_stack) {
    aitsc_paper_stack_end();
}
?>
```

---

## Performance Optimization

### 1. GPU Acceleration

```css
.paper-stack-section {
    /* Force GPU layer */
    transform: translateZ(0);

    /* Hint optimization */
    will-change: transform;

    /* Isolate repaints */
    contain: layout style paint;
}

/* Remove hints after animation */
.paper-stack-section.animation-complete {
    will-change: auto;
}
```

### 2. Intersection Observer Optimization

```javascript
// Use passive listeners
const observer = new IntersectionObserver(callback, {
    threshold: 0.1,
    rootMargin: '50px' // Trigger before viewport
});

// Unobserve after animation (one-time trigger)
observer.unobserve(element);
```

### 3. CSS Containment

```css
.paper-stack-section {
    /* Isolate layout, style, and paint calculations */
    contain: layout style paint;
}
```

---

## Accessibility Considerations

### 1. Respect `prefers-reduced-motion`

```css
@media (prefers-reduced-motion: reduce) {
    .paper-stack-section {
        opacity: 1 !important;
        transform: none !important;
        transition: none !important;
        animation: none !important;
    }
}
```

### 2. Keyboard Navigation

- Ensure scroll position is maintained
- Provide skip links if needed
- Test with screen readers

### 3. Focus Management

```css
/* Ensure focus indicators are visible */
.paper-stack-section:focus-within {
    z-index: 10;
}
```

---

## Mobile Responsiveness

### Breakpoint Strategy

```css
/* Mobile (0-575px): Minimal animations */
@media (max-width: 767px) {
    .paper-stack-section {
        --paper-stack-distance: 50px;
        --paper-stack-duration: 0.4s;
    }
}

/* Tablet (768-991px): Medium animations */
@media (min-width: 768px) and (max-width: 991px) {
    .paper-stack-section {
        --paper-stack-distance: 75px;
        --paper-stack-duration: 0.5s;
    }
}

/* Desktop (992px+): Full animations */
@media (min-width: 992px) {
    .paper-stack-section {
        --paper-stack-distance: 100px;
        --paper-stack-duration: 0.6s;
    }
}
```

---

## Testing Strategy

### 1. Browser Testing
- Chrome 115+ (primary)
- Safari 18.2+ (primary)
- Firefox 129+ (primary)
- Edge 115+ (primary)
- Legacy browsers (fallback)

### 2. Device Testing
- Desktop (1920x1080)
- Laptop (1366x768)
- Tablet (768x1024)
- Mobile (375x667)

### 3. Performance Testing
- Lighthouse audit (90+ score)
- Chrome DevTools Performance (60fps)
- Network throttling (slow 3G)

---

## Implementation Steps

1. [ ] Create component directory structure
2. [ ] Implement PHP component template
3. [ ] Write CSS Scroll-Driven Animations
4. [ ] Implement Intersection Observer fallback
5. [ ] Create WordPress integration layer
6. [ ] Add admin configuration (ACF or theme mods)
7. [ ] Integrate with existing templates
8. [ ] Test on modern browsers
9. [ ] Test on legacy browsers
10. [ ] Performance audit and optimization

---

## Success Criteria

- [ ] Component architecture defined and documented
- [ ] WordPress integration pattern established
- [ ] Performance optimization strategy implemented
- [ ] Accessibility compliance verified
- [ ] Mobile responsiveness designed
- [ ] Testing strategy outlined

---

## Risk Assessment

**Low Risk**:
- Component-based architecture is proven pattern
- Progressive enhancement ensures graceful degradation
- Performance optimizations are standard best practices

**Medium Risk**:
- Mobile performance on older devices (mitigation: reduced animations)
- WordPress plugin conflicts (mitigation: namespace isolation)

**High Risk**:
- None identified

---

## Security Considerations

- Output escaping in PHP templates (`esc_attr()`, `esc_html()`)
- Nonce verification for admin settings
- Capability checks for configuration access
- No external dependencies (reduced attack surface)

---

## Next Steps

Proceed to **[Phase 03: Core Implementation](./phase-03-core-implementation.md)** for detailed component implementation.

---

## Related Code Files

- `/wp-content/themes/aitsc-pro-theme/components/paper-stack/`
- `/wp-content/themes/aitsc-pro-theme/inc/paper-stack-config.php`
- `/wp-content/themes/aitsc-pro-theme/assets/js/paper-stack-fallback.js`
- `/wp-content/themes/aitsc-pro-theme/style.css`
- `/wp-content/themes/aitsc-pro-theme/single-solutions.php`
- `/wp-content/themes/aitsc-pro-theme/page-fleet-safe-pro.php`
