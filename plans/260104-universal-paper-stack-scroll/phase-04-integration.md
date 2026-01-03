# Phase 04: Integration

**Context**: [Phase 03 Implementation](./phase-03-core-implementation.md) | [Plan Overview](./plan.md)
**Date**: 2026-01-04
**Priority**: High
**Status**: Planning

---

## Overview

Integrate the universal paper stack scroll component with existing page templates (single-solutions.php, page-fleet-safe-pro.php, front-page.php) and template-parts, ensuring seamless integration with existing content and functionality.

---

## Key Insights

### 1. Integration Points

**Primary Targets**:
- `single-solutions.php` - Solution detail pages (high priority)
- `page-fleet-safe-pro.php` - Pillar pages (high priority)
- `front-page.php` - Homepage (medium priority)

**Secondary Targets**:
- `/template-parts/solution/overview.php`
- `/template-parts/solution/specs.php`
- `/template-parts/solution/gallery.php`
- `/template-parts/solution/science.php`
- `/template-parts/solution/ecosystem.php`

### 2. Integration Strategy

**Progressive Enhancement**: Add paper stack without breaking existing functionality
**Backward Compatibility**: Existing templates work without modification
**Opt-In Model**: Enable per template via configuration

### 3. Testing Strategy

**Unit Tests**: Individual template integration
**Integration Tests**: Component + template + content
**Visual Regression**: Before/after screenshots

---

## Requirements

### Functional Requirements
1. Integration with existing templates without breaking changes
2. Enable/disable per template via configuration
3. Support existing content and shortcodes
4. Maintain existing SEO and accessibility features

### Non-Functional Requirements
1. Zero layout shift (CLS 0)
2. Performance impact < 5% overhead
3. Mobile-responsive (tested on all breakpoints)
4. Cross-browser compatibility

### Technical Constraints
1. No modification to existing component structure
2. Enqueue system integration
3. ACF field support (if available)
4. Theme customizer integration

---

## Architecture

### Template Integration Pattern

```php
<?php
// Before template content
aitsc_paper_stack([
    'enabled' => true,
    'distance' => '100px',
    'duration' => '0.6s'
]);
?>

<!-- Existing template content -->

<?php
// After template content
aitsc_paper_stack_end();
?>
```

### Configuration Flow

```
WordPress Admin (ACF/Theme Mods)
    ↓
aitsc_get_paper_stack_config()
    ↓
Template Integration (aitsc_paper_stack())
    ↓
CSS Animations (paper-stack.css)
    ↓
Intersection Observer Fallback (paper-stack-fallback.js)
```

---

## Implementation Steps

### Step 1: Single Solution Pages Integration

**File**: `/single-solutions.php`

**Current Structure**:
```php
<?php get_header(); ?>
<main class="solution-content">
    <?php while (have_posts()) : the_post(); ?>
        <!-- Template parts -->
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>
```

**New Structure**:
```php
<?php
/**
 * Template Name: Single Solution
 * Description: Solution detail page with paper stack animations
 */

get_header();

// Check if paper stack is enabled for solutions
$enable_paper_stack = apply_filters('aitsc_solution_paper_stack', true);

if ($enable_paper_stack) {
    aitsc_paper_stack([
        'enabled' => true,
        'distance' => '120px',
        'duration' => '0.7s',
        'easing' => 'ease-out'
    ]);
}
?>

<main class="solution-content">
    <?php while (have_posts()) : the_post(); ?>
        <?php
        // Hero section (no animation)
        get_template_part('template-parts/solution/hero');
        ?>

        <article class="paper-stack-section solution-overview">
            <?php get_template_part('template-parts/solution/overview'); ?>
        </article>

        <article class="paper-stack-section solution-specs">
            <?php get_template_part('template-parts/solution/specs'); ?>
        </article>

        <article class="paper-stack-section solution-gallery">
            <?php get_template_part('template-parts/solution/gallery'); ?>
        </article>

        <article class="paper-stack-section solution-science">
            <?php get_template_part('template-parts/solution/science'); ?>
        </article>

        <article class="paper-stack-section solution-ecosystem">
            <?php get_template_part('template-parts/solution/ecosystem'); ?>
        </article>

        <?php
        // Related solutions (no animation)
        get_template_part('template-parts/solution/related');
        ?>
    <?php endwhile; ?>
</main>

<?php
if ($enable_paper_stack) {
    aitsc_paper_stack_end();
}

get_footer();
?>
```

### Step 2: Pillar Pages Integration

**File**: `/page-fleet-safe-pro.php`

**Current Structure**:
```php
<?php get_header(); ?>
<main class="fleet-safe-pro">
    <!-- Fleet Safe Pro content -->
</main>
<?php get_footer(); ?>
```

**New Structure**:
```php
<?php
/**
 * Template Name: Fleet Safe Pro
 * Description: Pillar page with paper stack animations
 */

get_header();

// Check ACF field or theme option
$enable_paper_stack = get_field('enable_paper_stack') ?? true;

if ($enable_paper_stack) {
    aitsc_paper_stack([
        'enabled' => true,
        'distance' => '100px',
        'duration' => '0.6s',
        'class' => 'fleet-safe-paper-stack'
    ]);
}
?>

<main class="fleet-safe-pro">
    <?php while (have_posts()) : the_post(); ?>

        <?php
        // Hero section (no animation)
        get_template_part('components/hero/hero', 'fleet-safe');
        ?>

        <section class="paper-stack-section introduction">
            <?php get_template_part('components/problem-solution/problem-solution', null, [
                'title' => get_field('introduction_title'),
                'content' => get_field('introduction_content')
            ]); ?>
        </section>

        <section class="paper-stack-section benefits">
            <?php get_template_part('components/card/card', null, [
                'variant' => 'bento-grid',
                'cards' => get_field('benefits_cards')
            ]); ?>
        </section>

        <section class="paper-stack-section features">
            <?php get_template_part('components/steps/steps', null, [
                'steps' => get_field('feature_steps')
            ]); ?>
        </section>

        <!-- More sections -->

    <?php endwhile; ?>
</main>

<?php
if ($enable_paper_stack) {
    aitsc_paper_stack_end();
}

get_footer();
?>
```

### Step 3: Homepage Integration

**File**: `/front-page.php`

**Current Structure**:
```php
<?php get_header(); ?>
<main class="home-page">
    <!-- Homepage content -->
</main>
<?php get_footer(); ?>
```

**New Structure**:
```php
<?php
/**
 * Template Name: Front Page
 * Description: Homepage with selective paper stack animations
 */

get_header();

// Enable only for specific sections
$enable_paper_stack = get_theme_mod('homepage_paper_stack', false);
?>

<main class="home-page">
    <?php while (have_posts()) : the_post(); ?>

        <?php
        // Hero section (no animation - particle system already present)
        get_template_part('components/hero/hero', 'home');
        ?>

        <?php if ($enable_paper_stack) : ?>
            <?php aitsc_paper_stack(['distance' => '80px', 'duration' => '0.5s']); ?>
        <?php endif; ?>

        <section class="paper-stack-section services-preview">
            <?php get_template_part('template-parts/services-preview'); ?>
        </section>

        <section class="paper-stack-section case-studies">
            <?php get_template_part('template-parts/case-studies-preview'); ?>
        </section>

        <?php if ($enable_paper_stack) : ?>
            <?php aitsc_paper_stack_end(); ?>
        <?php endif; ?>

        <!-- CTA section (no animation) -->
        <?php get_template_part('components/cta/cta', 'primary'); ?>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
```

### Step 4: Template-Parts Integration

**Overview Template**: `/template-parts/solution/overview.php`

```php
<?php
/**
 * Solution Overview Template Part
 * Wrapped in paper-stack-section by parent template
 */

$solution_overview = get_field('solution_overview');
?>

<div class="solution-overview-content">
    <h2><?php echo esc_html($solution_overview['title']); ?></h2>
    <div class="overview-grid">
        <div class="overview-text">
            <?php echo wp_kses_post($solution_overview['description']); ?>
        </div>
        <div class="overview-features">
            <?php foreach ($solution_overview['features'] as $feature) : ?>
                <div class="feature-item">
                    <span class="feature-icon"><?php echo esc_html($feature['icon']); ?></span>
                    <h3><?php echo esc_html($feature['title']); ?></h3>
                    <p><?php echo esc_html($feature['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
```

### Step 5: ACF Integration (Optional)

**File**: `/inc/acf-paper-stack-fields.php`

```php
<?php
/**
 * ACF Fields for Paper Stack Configuration
 *
 * @package AITSC_Pro_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Paper Stack Settings Page
 */
function aitsc_acf_paper_stack_settings_page() {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_sub_page([
            'page_title' => 'Paper Stack Settings',
            'menu_title' => 'Paper Stack',
            'parent_slug' => 'options-general.php',
            'capability' => 'manage_options'
        ]);
    }
}
add_action('acf/init', 'aitsc_acf_paper_stack_settings_page');

/**
 * Register Paper Stack Fields
 */
function aitsc_acf_register_paper_stack_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key' => 'group_paper_stack_settings',
        'title' => 'Paper Stack Settings',
        'fields' => [
            [
                'key' => 'field_paper_stack_enabled',
                'label' => 'Enable Paper Stack',
                'name' => 'paper_stack_enabled',
                'type' => 'true_false',
                'instructions' => 'Enable paper stack scroll animations globally',
                'default_value' => 1,
                'ui' => 1
            ],
            [
                'key' => 'field_paper_stack_distance',
                'label' => 'Animation Distance',
                'name' => 'paper_stack_distance',
                'type' => 'select',
                'choices' => [
                    '50px' => 'Small (50px)',
                    '100px' => 'Medium (100px)',
                    '150px' => 'Large (150px)'
                ],
                'default_value' => '100px'
            ],
            [
                'key' => 'field_paper_stack_duration',
                'label' => 'Animation Duration',
                'name' => 'paper_stack_duration',
                'type' => 'select',
                'choices' => [
                    '0.4s' => 'Fast (0.4s)',
                    '0.6s' => 'Medium (0.6s)',
                    '0.8s' => 'Slow (0.8s)'
                ],
                'default_value' => '0.6s'
            ],
            [
                'key' => 'field_paper_stack_easing',
                'label' => 'Animation Easing',
                'name' => 'paper_stack_easing',
                'type' => 'select',
                'choices' => [
                    'ease-out' => 'Ease Out',
                    'ease-in-out' => 'Ease In Out',
                    'linear' => 'Linear'
                ],
                'default_value' => 'ease-out'
            ]
        ],
        'location' => [
            [
                [
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-paper-stack-settings'
                ]
            ]
        ]
    ]);
}
add_action('acf/init', 'aitsc_acf_register_paper_stack_fields');
```

### Step 6: Theme Customizer Integration (Alternative)

**File**: `/inc/customizer-paper-stack.php`

```php
<?php
/**
 * Theme Customizer: Paper Stack Settings
 *
 * @package AITSC_Pro_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Paper Stack Settings
 */
function aitsc_customizer_paper_stack_settings($wp_customize) {
    // Add Paper Stack Section
    $wp_customize->add_section('aitsc_paper_stack', [
        'title' => __('Paper Stack Animations', 'aitsc-pro'),
        'priority' => 30,
        'capability' => 'edit_theme_options'
    ]);

    // Enable Paper Stack
    $wp_customize->add_setting('paper_stack_enabled', [
        'default' => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
        'transport' => 'refresh'
    ]);

    $wp_customize->add_control('paper_stack_enabled', [
        'label' => __('Enable Paper Stack Animations', 'aitsc-pro'),
        'section' => 'aitsc_paper_stack',
        'type' => 'checkbox'
    ]);

    // Animation Distance
    $wp_customize->add_setting('paper_stack_distance', [
        'default' => '100px',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh'
    ]);

    $wp_customize->add_control('paper_stack_distance', [
        'label' => __('Animation Distance', 'aitsc-pro'),
        'section' => 'aitsc_paper_stack',
        'type' => 'select',
        'choices' => [
            '50px' => __('Small (50px)', 'aitsc-pro'),
            '100px' => __('Medium (100px)', 'aitsc-pro'),
            '150px' => __('Large (150px)', 'aitsc-pro')
        ]
    ]);

    // Animation Duration
    $wp_customize->add_setting('paper_stack_duration', [
        'default' => '0.6s',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh'
    ]);

    $wp_customize->add_control('paper_stack_duration', [
        'label' => __('Animation Duration', 'aitsc-pro'),
        'section' => 'aitsc_paper_stack',
        'type' => 'select',
        'choices' => [
            '0.4s' => __('Fast (0.4s)', 'aitsc-pro'),
            '0.6s' => __('Medium (0.6s)', 'aitsc-pro'),
            '0.8s' => __('Slow (0.8s)', 'aitsc-pro')
        ]
    ]);
}
add_action('customize_register', 'aitsc_customizer_paper_stack_settings');
```

---

## Todo List

- [ ] Integrate paper stack into `single-solutions.php`
- [ ] Integrate paper stack into `page-fleet-safe-pro.php`
- [ ] Integrate paper stack into `front-page.php` (selective)
- [ ] Update solution template-parts for paper stack
- [ ] Create ACF integration (optional)
- [ ] Create Theme Customizer integration (alternative)
- [ ] Test each template individually
- [ ] Test cross-template navigation
- [ ] Verify mobile responsiveness
- [ ] Run performance audits
- [ ] Create before/after screenshots

---

## Success Criteria

- [ ] All target templates integrated with paper stack
- [ ] Existing functionality preserved (no breaking changes)
- [ ] Configuration system functional (ACF or Theme Customizer)
- [ ] Mobile-responsive (tested on all breakpoints)
- [ ] Performance impact < 5% overhead
- [ ] Zero layout shift (CLS 0)
- [ ] Accessibility compliance maintained

---

## Risk Assessment

**Low Risk**:
- Progressive enhancement ensures backward compatibility
- Opt-in model prevents forced changes
- Isolated component structure

**Medium Risk**:
- Template conflicts with existing animations (mitigation: CSS specificity)
- Performance impact on lower-end devices (mitigation: reduced animations on mobile)

**High Risk**:
- None identified

---

## Security Considerations

- Output escaping in template files (`esc_html()`, `esc_attr()`)
- Capability checks for admin settings (`manage_options`)
- Nonce verification for ACF forms
- Sanitization of user inputs

---

## Next Steps

Proceed to **[Phase 05: Testing & QA](./phase-05-testing-qa.md)** for comprehensive testing and validation strategy.

---

## Related Code Files

- `/wp-content/themes/aitsc-pro-theme/single-solutions.php`
- `/wp/content/themes/aitsc-pro-theme/page-fleet-safe-pro.php`
- `/wp-content/themes/aitsc-pro-theme/front-page.php`
- `/wp-content/themes/aitsc-pro-theme/template-parts/solution/*.php`
- `/wp-content/themes/aitsc-pro-theme/inc/acf-paper-stack-fields.php`
- `/wp-content/themes/aitsc-pro-theme/inc/customizer-paper-stack.php`
