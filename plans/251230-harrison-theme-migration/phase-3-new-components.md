# Phase 3: New Harrison.ai Components

**Status**: Not Started
**Priority**: High
**Dependencies**: Phase 1, Phase 2

---

## Context

Create three new components that don't exist in current AITSC architecture but are essential for Harrison.ai design pattern.

---

## New Components

1. **Trust Bar** - Centered trust statement text
2. **Logo Carousel** - Auto-scrolling partner logos
3. **Image Composition** - Floating overlapping images

---

## 1. Trust Bar Component

### Purpose
Display trust/credibility statement (e.g., "Trusted by leading organizations globally")

### Files to Create

```
components/
  trust-bar/
    trust-bar.php
    trust-bar-styles.css
```

### PHP Implementation (`trust-bar.php`)

```php
<?php
/**
 * Trust Bar Component
 *
 * Displays centered trust statement text.
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Trust Bar Component
 *
 * @param array $args {
 *     @type string $text     Trust statement text (required)
 *     @type string $variant  Style variant: 'default'|'minimal'
 *     @type string $bg       Background: 'white'|'light'|'transparent'
 * }
 */
function aitsc_render_trust_bar($args = array()) {
    $defaults = array(
        'text'    => '',
        'variant' => 'default',
        'bg'      => 'white'
    );

    $args = wp_parse_args($args, $defaults);

    if (empty($args['text'])) {
        return;
    }

    $classes = array(
        'aitsc-trust-bar',
        'aitsc-trust-bar--' . esc_attr($args['variant']),
        'aitsc-trust-bar--bg-' . esc_attr($args['bg'])
    );

    echo '<div class="' . implode(' ', $classes) . '">';
    echo '<div class="aitsc-trust-bar__container">';
    echo '<p class="aitsc-trust-bar__text">' . wp_kses_post($args['text']) . '</p>';
    echo '</div>';
    echo '</div>';
}
```

### CSS Implementation (`trust-bar-styles.css`)

```css
/**
 * Trust Bar Component Styles
 */

.aitsc-trust-bar {
    padding: 2rem 1.5rem;
    text-align: center;
}

.aitsc-trust-bar--bg-white {
    background: var(--aitsc-bg-primary);
}

.aitsc-trust-bar--bg-light {
    background: var(--aitsc-bg-secondary);
}

.aitsc-trust-bar--bg-transparent {
    background: transparent;
}

.aitsc-trust-bar__container {
    max-width: var(--aitsc-container-width);
    margin: 0 auto;
}

.aitsc-trust-bar__text {
    font-size: 1rem;
    color: var(--aitsc-text-muted);
    font-weight: 500;
    letter-spacing: 0.02em;
    margin: 0;
}

/* Minimal variant */
.aitsc-trust-bar--minimal {
    padding: 1rem 1.5rem;
}

.aitsc-trust-bar--minimal .aitsc-trust-bar__text {
    font-size: 0.875rem;
}

@media (max-width: 47.9375rem) {
    .aitsc-trust-bar__text {
        font-size: 0.875rem;
    }
}
```

---

## 2. Logo Carousel Component

### Purpose
Auto-scrolling horizontal carousel of partner/client logos

### Files to Create

```
components/
  logo-carousel/
    logo-carousel.php
    logo-carousel-styles.css
    logo-carousel.js
```

### PHP Implementation (`logo-carousel.php`)

```php
<?php
/**
 * Logo Carousel Component
 *
 * Auto-scrolling partner logos.
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Logo Carousel Component
 *
 * @param array $args {
 *     @type array  $logos          Array of logo data [{src, alt, link}]
 *     @type int    $speed          Animation duration in seconds (default: 30)
 *     @type bool   $grayscale      Apply grayscale filter (default: true)
 *     @type bool   $pause_on_hover Pause animation on hover (default: true)
 * }
 */
function aitsc_render_logo_carousel($args = array()) {
    $defaults = array(
        'logos'          => array(),
        'speed'          => 30,
        'grayscale'      => true,
        'pause_on_hover' => true
    );

    $args = wp_parse_args($args, $defaults);

    if (empty($args['logos'])) {
        return;
    }

    $classes = array('aitsc-logo-carousel');
    if ($args['grayscale']) {
        $classes[] = 'aitsc-logo-carousel--grayscale';
    }
    if ($args['pause_on_hover']) {
        $classes[] = 'aitsc-logo-carousel--pause-hover';
    }

    $style = sprintf('--carousel-speed: %ds;', intval($args['speed']));

    echo '<div class="' . implode(' ', $classes) . '" style="' . esc_attr($style) . '">';
    echo '<div class="aitsc-logo-carousel__track">';

    // Render logos twice for seamless infinite scroll
    for ($i = 0; $i < 2; $i++) {
        foreach ($args['logos'] as $logo) {
            echo '<div class="aitsc-logo-carousel__slide">';

            if (!empty($logo['link'])) {
                echo '<a href="' . esc_url($logo['link']) . '" target="_blank" rel="noopener">';
            }

            echo '<img src="' . esc_url($logo['src']) . '" alt="' . esc_attr($logo['alt'] ?? '') . '" loading="lazy" />';

            if (!empty($logo['link'])) {
                echo '</a>';
            }

            echo '</div>';
        }
    }

    echo '</div>';
    echo '</div>';
}
```

### CSS Implementation (`logo-carousel-styles.css`)

```css
/**
 * Logo Carousel Component Styles
 */

.aitsc-logo-carousel {
    --carousel-speed: 30s;
    overflow: hidden;
    padding: 2rem 0;
    background: var(--aitsc-bg-primary);
}

.aitsc-logo-carousel__track {
    display: flex;
    gap: 4rem;
    width: max-content;
    animation: logoScroll var(--carousel-speed) linear infinite;
}

@keyframes logoScroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

.aitsc-logo-carousel__slide {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 48px;
}

.aitsc-logo-carousel__slide img {
    max-height: 48px;
    max-width: 140px;
    width: auto;
    object-fit: contain;
    transition: filter 0.3s ease, opacity 0.3s ease;
}

/* Grayscale variant */
.aitsc-logo-carousel--grayscale .aitsc-logo-carousel__slide img {
    filter: grayscale(100%);
    opacity: 0.6;
}

.aitsc-logo-carousel--grayscale .aitsc-logo-carousel__slide:hover img {
    filter: grayscale(0%);
    opacity: 1;
}

/* Pause on hover */
.aitsc-logo-carousel--pause-hover:hover .aitsc-logo-carousel__track {
    animation-play-state: paused;
}

/* Respect reduced motion */
@media (prefers-reduced-motion: reduce) {
    .aitsc-logo-carousel__track {
        animation: none;
        flex-wrap: wrap;
        justify-content: center;
        width: 100%;
    }
}

@media (max-width: 47.9375rem) {
    .aitsc-logo-carousel__track {
        gap: 2rem;
    }

    .aitsc-logo-carousel__slide img {
        max-height: 36px;
        max-width: 100px;
    }
}
```

---

## 3. Image Composition Component

### Purpose
Floating overlapping images layout (Harrison.ai mission section style)

### Files to Create

```
components/
  image-composition/
    image-composition.php
    image-composition-styles.css
```

### PHP Implementation (`image-composition.php`)

```php
<?php
/**
 * Image Composition Component
 *
 * Floating overlapping images layout.
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Image Composition Component
 *
 * @param array $args {
 *     @type array  $images    Array of images [{src, alt, position, size}]
 *     @type string $layout    Layout: 'stacked'|'scattered'
 *     @type bool   $animate   Enable float animation
 * }
 */
function aitsc_render_image_composition($args = array()) {
    $defaults = array(
        'images'  => array(),
        'layout'  => 'stacked',
        'animate' => true
    );

    $args = wp_parse_args($args, $defaults);

    if (empty($args['images'])) {
        return;
    }

    $classes = array(
        'aitsc-image-comp',
        'aitsc-image-comp--' . esc_attr($args['layout'])
    );

    if ($args['animate']) {
        $classes[] = 'aitsc-image-comp--animated';
    }

    echo '<div class="' . implode(' ', $classes) . '">';

    foreach ($args['images'] as $index => $image) {
        $position = $image['position'] ?? 'center';
        $size = $image['size'] ?? 'medium';

        $item_classes = array(
            'aitsc-image-comp__item',
            'aitsc-image-comp__item--' . esc_attr($position),
            'aitsc-image-comp__item--' . esc_attr($size)
        );

        echo '<div class="' . implode(' ', $item_classes) . '">';
        echo '<img src="' . esc_url($image['src']) . '" alt="' . esc_attr($image['alt'] ?? '') . '" loading="lazy" />';
        echo '</div>';
    }

    echo '</div>';
}
```

### CSS Implementation (`image-composition-styles.css`)

```css
/**
 * Image Composition Component Styles
 */

.aitsc-image-comp {
    position: relative;
    width: 100%;
    min-height: 400px;
}

/* Stacked layout */
.aitsc-image-comp--stacked .aitsc-image-comp__item {
    position: absolute;
    border-radius: var(--aitsc-radius-lg);
    overflow: hidden;
    box-shadow: var(--aitsc-shadow-xl);
}

.aitsc-image-comp--stacked .aitsc-image-comp__item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Position modifiers */
.aitsc-image-comp__item--top-left {
    top: 0;
    left: 0;
    z-index: 3;
}

.aitsc-image-comp__item--top-right {
    top: 10%;
    right: 0;
    z-index: 2;
}

.aitsc-image-comp__item--bottom-left {
    bottom: 10%;
    left: 10%;
    z-index: 2;
}

.aitsc-image-comp__item--bottom-right {
    bottom: 0;
    right: 5%;
    z-index: 1;
}

.aitsc-image-comp__item--center {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 2;
}

/* Size modifiers */
.aitsc-image-comp__item--large {
    width: 60%;
    height: auto;
    aspect-ratio: 4/3;
}

.aitsc-image-comp__item--medium {
    width: 45%;
    height: auto;
    aspect-ratio: 3/2;
}

.aitsc-image-comp__item--small {
    width: 35%;
    height: auto;
    aspect-ratio: 1/1;
}

/* Float animation */
.aitsc-image-comp--animated .aitsc-image-comp__item--top-left {
    animation: floatUp 6s ease-in-out infinite;
}

.aitsc-image-comp--animated .aitsc-image-comp__item--bottom-right {
    animation: floatUp 6s ease-in-out infinite 1s;
}

.aitsc-image-comp--animated .aitsc-image-comp__item--top-right {
    animation: floatUp 6s ease-in-out infinite 2s;
}

@keyframes floatUp {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

/* Respect reduced motion */
@media (prefers-reduced-motion: reduce) {
    .aitsc-image-comp--animated .aitsc-image-comp__item {
        animation: none;
    }
}

/* Responsive */
@media (max-width: 47.9375rem) {
    .aitsc-image-comp {
        min-height: 300px;
    }

    .aitsc-image-comp__item--large {
        width: 70%;
    }

    .aitsc-image-comp__item--medium {
        width: 55%;
    }

    .aitsc-image-comp__item--small {
        width: 45%;
    }
}
```

---

## Component Registration

### Update `inc/components.php`

Add to `aitsc_load_components()`:

```php
// Load trust bar component
require_once $component_dir . '/trust-bar/trust-bar.php';

// Load logo carousel component
require_once $component_dir . '/logo-carousel/logo-carousel.php';

// Load image composition component
require_once $component_dir . '/image-composition/image-composition.php';
```

Add to `aitsc_enqueue_component_styles()`:

```php
// Trust bar styles
$trust_bar_css = $component_path . '/trust-bar/trust-bar-styles.css';
if (file_exists($trust_bar_css)) {
    wp_enqueue_style(
        'aitsc-component-trust-bar',
        $component_dir . '/trust-bar/trust-bar-styles.css',
        array(),
        AITSC_VERSION
    );
}

// Logo carousel styles
$logo_carousel_css = $component_path . '/logo-carousel/logo-carousel-styles.css';
if (file_exists($logo_carousel_css)) {
    wp_enqueue_style(
        'aitsc-component-logo-carousel',
        $component_dir . '/logo-carousel/logo-carousel-styles.css',
        array(),
        AITSC_VERSION
    );
}

// Image composition styles
$image_comp_css = $component_path . '/image-composition/image-composition-styles.css';
if (file_exists($image_comp_css)) {
    wp_enqueue_style(
        'aitsc-component-image-composition',
        $component_dir . '/image-composition/image-composition-styles.css',
        array(),
        AITSC_VERSION
    );
}
```

---

## Shortcodes

Add shortcode support in `inc/components.php`:

```php
// Trust bar shortcode
function aitsc_trust_bar_shortcode($atts) {
    $atts = shortcode_atts(array(
        'text'    => '',
        'variant' => 'default',
        'bg'      => 'white'
    ), $atts);

    ob_start();
    aitsc_render_trust_bar($atts);
    return ob_get_clean();
}
add_shortcode('aitsc_trust_bar', 'aitsc_trust_bar_shortcode');
```

---

## Todo List

- [ ] Create `components/trust-bar/` directory
- [ ] Create trust-bar.php
- [ ] Create trust-bar-styles.css
- [ ] Create `components/logo-carousel/` directory
- [ ] Create logo-carousel.php
- [ ] Create logo-carousel-styles.css
- [ ] Create `components/image-composition/` directory
- [ ] Create image-composition.php
- [ ] Create image-composition-styles.css
- [ ] Update inc/components.php with require statements
- [ ] Update inc/components.php with style enqueues
- [ ] Add shortcodes for new components
- [ ] Test trust bar rendering
- [ ] Test logo carousel infinite scroll
- [ ] Test logo carousel pause on hover
- [ ] Test image composition positioning
- [ ] Test animations respect prefers-reduced-motion
- [ ] Responsive testing

---

## Success Criteria

1. All three components render without errors
2. Logo carousel animates smoothly (CSS-only)
3. Image composition positions correctly
4. All components respect prefers-reduced-motion
5. Components work with shortcodes
6. Responsive across all breakpoints
