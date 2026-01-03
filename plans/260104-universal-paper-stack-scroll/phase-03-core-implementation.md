# Phase 03: Core Implementation

**Context**: [Phase 02 Architecture](./phase-02-architecture-design.md) | [Plan Overview](./plan.md)
**Date**: 2026-01-04
**Priority**: High
**Status**: Planning

---

## Overview

Implement the universal paper stack scroll component with native CSS Scroll-Driven Animations (primary) and Intersection Observer fallback (legacy), following WordPress best practices and component-based architecture.

---

## Key Insights

### 1. File Structure

```
/wp-content/themes/aitsc-pro-theme/
├── components/
│   └── paper-stack/
│       ├── paper-stack.php           # PHP component template
│       ├── paper-stack.css           # CSS animations
│       └── README.md                 # Documentation
├── inc/
│   └── paper-stack-config.php        # WordPress integration
├── assets/js/
│   └── paper-stack-fallback.js       # Intersection Observer JS
└── style.css                         # Global styles (append)
```

### 2. Implementation Order

**Priority 1**: CSS Scroll-Driven Animations (primary path)
**Priority 2**: Intersection Observer fallback (progressive enhancement)
**Priority 3**: WordPress integration (PHP templates, admin settings)
**Priority 4**: Template integration (existing page templates)

### 3. Testing Strategy

**Unit Tests**: Individual component files
**Integration Tests**: Component + WordPress integration
**E2E Tests**: Complete page templates with animations

---

## Requirements

### Functional Requirements
1. Universal component usable across all templates
2. Configurable parameters (distance, duration, easing, delay)
3. Enable/disable via WordPress admin or ACF fields
4. Mobile-responsive with touch-optimized behavior

### Non-Functional Requirements
1. Performance: 60fps on modern devices
2. Accessibility: Respect `prefers-reduced-motion`
3. SEO: No layout shift (CLS 0)
4. Compatibility: WordPress 6.0+, PHP 8.0+

### Technical Constraints
1. Component-based architecture
2. Enqueue system integration
3. No external dependencies
4. Minimal JavaScript (YAGNI)

---

## Architecture

### Component Flow

```
Template File (single-solutions.php)
    ↓
PHP Helper Function (aitsc_paper_stack())
    ↓
Component Wrapper (data attributes)
    ↓
CSS Animations (paper-stack.css) ← Primary
    ↓
Intersection Observer (paper-stack-fallback.js) ← Fallback
    ↓
DOM Updates (is-visible class)
```

### Data Flow

```php
// Configuration array
$config = [
    'enabled' => true,
    'distance' => '100px',
    'duration' => '0.6s',
    'easing' => 'ease-out',
    'delay' => '0s'
];

// Pass to component
aitsc_paper_stack($config);

// Output as data attributes
<div class="aitsc-paper-stack-wrapper"
     data-paper-stack
     data-distance="100px"
     data-duration="0.6s"
     data-easing="ease-out"
     data-delay="0s">
```

---

## Implementation Steps

### Step 1: Create Component Directory

```bash
mkdir -p /wp-content/themes/aitsc-pro-theme/components/paper-stack
```

### Step 2: Implement PHP Component Template

**File**: `/components/paper-stack/paper-stack.php`

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
 * Open paper stack wrapper
 *
 * @param array $args Configuration arguments
 * @return void
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

    // Allow filtering
    $args = apply_filters('aitsc_paper_stack_args', $args);

    if (!$args['enabled']) {
        return;
    }

    $wrapper_classes = ['aitsc-paper-stack-wrapper'];
    if (!empty($args['class'])) {
        $wrapper_classes[] = esc_attr($args['class']);
    }

    $wrapper_id = !empty($args['id']) ? esc_attr($args['id']) : 'paper-stack-' . uniqid();

    // Output opening wrapper
    printf(
        '<div id="%s" class="%s" data-paper-stack',
        $wrapper_id,
        implode(' ', $wrapper_classes)
    );

    // Output configuration as data attributes
    printf(
        ' data-distance="%s" data-duration="%s" data-easing="%s" data-delay="%s">',
        esc_attr($args['distance']),
        esc_attr($args['duration']),
        esc_attr($args['easing']),
        esc_attr($args['delay'])
    );

    // Fire action hook
    do_action('aitsc_paper_stack_open', $args);
}

/**
 * Close paper stack wrapper
 *
 * @return void
 */
function aitsc_paper_stack_end() {
    do_action('aitsc_paper_stack_close');
    echo '</div>';
}
```

### Step 3: Implement CSS Animations

**File**: `/components/paper-stack/paper-stack.css`

```css
/**
 * Paper Stack Scroll Animations
 * Uses CSS Scroll-Driven Animations (2025) with Intersection Observer fallback
 *
 * @package AITSC_Pro_Theme
 */

/* ==========================================================================
   BASE STYLES
   ========================================================================== */

.aitsc-paper-stack-wrapper {
    position: relative;
    z-index: 1;
}

.paper-stack-section {
    position: relative;
    contain: layout style paint;
    transform: translateZ(0);
    will-change: transform;
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

    .paper-stack-section.animation-complete {
        will-change: auto;
    }

    /* Stagger effect */
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

@media (max-width: 767px) {
    .paper-stack-section {
        --paper-stack-distance: 50px;
        --paper-stack-duration: 0.4s;
    }
}

@media (min-width: 768px) and (max-width: 991px) {
    .paper-stack-section {
        --paper-stack-distance: 75px;
        --paper-stack-duration: 0.5s;
    }
}

@media (min-width: 992px) {
    .paper-stack-section {
        --paper-stack-distance: 100px;
        --paper-stack-duration: 0.6s;
    }
}
```

### Step 4: Implement Intersection Observer Fallback

**File**: `/assets/js/paper-stack-fallback.js`

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
        rootMargin: '0px 0px -50px 0px',
        threshold: 0.1
    };

    // Create Intersection Observer
    const paperStackObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const section = entry.target;

                // Apply custom delay from data attribute
                const delay = section.dataset.delay || '0s';
                section.style.transitionDelay = delay;

                // Add visible class
                section.classList.add('is-visible');

                // Unobserve after animation
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

### Step 5: Create WordPress Integration

**File**: `/inc/paper-stack-config.php`

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

/**
 * Register component for template usage
 */
function aitsc_register_paper_stack_component() {
    // Load component template functions
    require_once get_template_directory() . '/components/paper-stack/paper-stack.php';
}
add_action('after_setup_theme', 'aitsc_register_paper_stack_component');
```

### Step 6: Update Enqueue System

**File**: `/inc/enqueue.php`

Add to existing enqueue function:

```php
/**
 * Enqueue paper stack component
 */
function aitsc_enqueue_paper_stack_component() {
    if (!aitsc_is_paper_stack_enabled()) {
        return;
    }

    wp_enqueue_style(
        'aitsc-paper-stack',
        AITSC_THEME_URI . '/components/paper-stack/paper-stack.css',
        array(),
        AITSC_VERSION
    );

    wp_enqueue_script(
        'aitsc-paper-stack-fallback',
        AITSC_THEME_URI . '/assets/js/paper-stack-fallback.js',
        array(),
        AITSC_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'aitsc_enqueue_paper_stack_component');
```

### Step 7: Update Global Styles

**File**: `/style.css`

Append to existing animation section (lines 3593+):

```css
/* ==========================================================================
   PAPER STACK SCROLL ANIMATIONS
   ========================================================================== */

/* Load component styles if not already loaded */
@supports not (animation-timeline: view()) {
    .paper-stack-section {
        /* Fallback styles (duplicate of component styles for global access) */
    }
}
```

---

## Todo List

- [ ] Create `/components/paper-stack/` directory
- [ ] Implement `paper-stack.php` (PHP component)
- [ ] Implement `paper-stack.css` (CSS animations)
- [ ] Implement `paper-stack-fallback.js` (JS fallback)
- [ ] Create `/inc/paper-stack-config.php` (WordPress integration)
- [ ] Update `/inc/enqueue.php` (enqueue system)
- [ ] Update `/style.css` (global styles)
- [ ] Create component README documentation
- [ ] Test component in isolation
- [ ] Test WordPress integration
- [ ] Verify browser compatibility
- [ ] Run performance audits

---

## Success Criteria

- [ ] Component files created and functional
- [ ] CSS Scroll-Driven Animations working in Chrome 115+, Safari 18.2+, Firefox 129+
- [ ] Intersection Observer fallback working in legacy browsers
- [ ] WordPress integration functional (enqueue, configuration)
- [ ] Mobile-responsive (tested on 375x667)
- [ ] Accessibility compliance (prefers-reduced-motion)
- [ ] Performance audit passes (Lighthouse 90+)

---

## Risk Assessment

**Low Risk**:
- Component-based architecture is isolated
- Progressive enhancement ensures fallback
- WordPress integration follows established patterns

**Medium Risk**:
- Mobile performance on older devices (mitigation: reduced animations)
- Enqueue conflicts with existing scripts (mitigation: dependency management)

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

Proceed to **[Phase 04: Integration](./phase-04-integration.md)** for template integration and implementation.

---

## Related Code Files

- `/wp-content/themes/aitsc-pro-theme/components/paper-stack/paper-stack.php`
- `/wp-content/themes/aitsc-pro-theme/components/paper-stack/paper-stack.css`
- `/wp-content/themes/aitsc-pro-theme/inc/paper-stack-config.php`
- `/wp-content/themes/aitsc-pro-theme/assets/js/paper-stack-fallback.js`
- `/wp-content/themes/aitsc-pro-theme/inc/enqueue.php`
- `/wp-content/themes/aitsc-pro-theme/style.css`
