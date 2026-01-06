<?php
/**
 * Paper Stack Configuration
 * WordPress integration for Paper Stack component
 *
 * @package AITSC_Pro_Theme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue Paper Stack assets
 */
function aitsc_enqueue_paper_stack_assets() {
    $css_file = AITSC_THEME_DIR . '/components/paper-stack/paper-stack.css';
    if (file_exists($css_file)) {
        wp_enqueue_style(
            'aitsc-paper-stack',
            AITSC_THEME_URI . '/components/paper-stack/paper-stack.css',
            [],
            AITSC_VERSION
        );
    }

    $js_file = AITSC_THEME_DIR . '/assets/js/paper-stack-fallback.js';
    if (file_exists($js_file)) {
        wp_enqueue_script(
            'aitsc-paper-stack-fallback',
            AITSC_THEME_URI . '/assets/js/paper-stack-fallback.js',
            [],
            AITSC_VERSION,
            true
        );

        // Localize script for data passing
        wp_localize_script('aitsc-paper-stack-fallback', 'paperStackData', [
            'rootMargin' => '0px 0px -10% 0px',
            'threshold' => [0, 0.1, 0.25, 0.5, 0.75, 1],
            'enabled' => true
        ]);
    }
}
add_action('wp_enqueue_scripts', 'aitsc_enqueue_paper_stack_assets');

/**
 * Load Paper Stack component
 */
function aitsc_load_paper_stack_component() {
    $component_path = AITSC_THEME_DIR . '/components/paper-stack/paper-stack.php';

    if (file_exists($component_path)) {
        require_once $component_path;
    }
}
add_action('after_setup_theme', 'aitsc_load_paper_stack_component');

/**
 * Check if reduced motion is preferred
 */
function aitsc_paper_stack_check_reduced_motion() {
    return apply_filters('aitsc_paper_stack_reduced_motion', false);
}

/**
 * Add reduced motion detection
 */
function aitsc_paper_stack_reduced_motion_filter() {
    // Check for prefers-reduced-motion media query
    ?>
    <script>
    (function() {
        var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (reducedMotion) {
            document.documentElement.classList.add('prefers-reduced-motion');
        }
    })();
    </script>
    <?php
}
add_action('wp_head', 'aitsc_paper_stack_reduced_motion_filter', 1);

/**
 * Theme Customizer settings for Paper Stack
 */
function aitsc_paper_stack_customizer($wp_customize) {
    // Paper Stack Section
    $wp_customize->add_section('aitsc_paper_stack', [
        'title' => __('Paper Stack Animations', 'aitsc-pro'),
        'description' => __('Configure universal scroll animations for section-by-section transitions.', 'aitsc-pro'),
        'priority' => 150,
    ]);

    // Enable/Disable Paper Stack
    $wp_customize->add_setting('aitsc_paper_stack_enabled', [
        'default' => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('aitsc_paper_stack_enabled', [
        'label' => __('Enable Paper Stack Animations', 'aitsc-pro'),
        'description' => __('Enable universal section-by-section scroll animations', 'aitsc-pro'),
        'section' => 'aitsc_paper_stack',
        'type' => 'checkbox',
    ]);

    // Animation Distance
    $wp_customize->add_setting('aitsc_paper_stack_distance', [
        'default' => '100',
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('aitsc_paper_stack_distance', [
        'label' => __('Animation Distance (px)', 'aitsc-pro'),
        'description' => __('Distance sections travel during animation', 'aitsc-pro'),
        'section' => 'aitsc_paper_stack',
        'type' => 'number',
        'input_attrs' => [
            'min' => 0,
            'max' => 200,
            'step' => 10,
        ],
    ]);

    // Animation Duration
    $wp_customize->add_setting('aitsc_paper_stack_duration', [
        'default' => '0.6',
        'sanitize_callback' => 'aitsc_sanitize_float',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('aitsc_paper_stack_duration', [
        'label' => __('Animation Duration (seconds)', 'aitsc-pro'),
        'description' => __('Duration of animation in seconds', 'aitsc-pro'),
        'section' => 'aitsc_paper_stack',
        'type' => 'number',
        'input_attrs' => [
            'min' => 0.1,
            'max' => 2,
            'step' => 0.1,
        ],
    ]);

    // Animation Easing
    $wp_customize->add_setting('aitsc_paper_stack_easing', [
        'default' => 'ease-out',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('aitsc_paper_stack_easing', [
        'label' => __('Animation Easing', 'aitsc-pro'),
        'section' => 'aitsc_paper_stack',
        'type' => 'select',
        'choices' => [
            'ease-out' => __('Ease Out (Recommended)', 'aitsc-pro'),
            'ease-in-out' => __('Ease In Out', 'aitsc-pro'),
            'linear' => __('Linear', 'aitsc-pro'),
        ],
    ]);

    // Animation Variant
    $wp_customize->add_setting('aitsc_paper_stack_variant', [
        'default' => 'default',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('aitsc_paper_stack_variant', [
        'label' => __('Animation Style', 'aitsc-pro'),
        'section' => 'aitsc_paper_stack',
        'type' => 'select',
        'choices' => [
            'default' => __('Default', 'aitsc-pro'),
            'subtle' => __('Subtle (Minimal)', 'aitsc-pro'),
            'dramatic' => __('Dramatic (Pronounced)', 'aitsc-pro'),
            'fast' => __('Fast (Quick)', 'aitsc-pro'),
            'slow' => __('Slow (Cinematic)', 'aitsc-pro'),
        ],
    ]);

    // Respect Reduced Motion
    $wp_customize->add_setting('aitsc_paper_stack_respect_reduced_motion', [
        'default' => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('aitsc_paper_stack_respect_reduced_motion', [
        'label' => __('Respect Reduced Motion Preference', 'aitsc-pro'),
        'description' => __('Disable animations for users who prefer reduced motion', 'aitsc-pro'),
        'section' => 'aitsc_paper_stack',
        'type' => 'checkbox',
    ]);
}
add_action('customize_register', 'aitsc_paper_stack_customizer');

/**
 * Sanitize float value
 */
function aitsc_sanitize_float($value) {
    return floatval($value);
}

/**
 * Output custom CSS based on Customizer settings
 */
function aitsc_paper_stack_customizer_css() {
    $enabled = get_theme_mod('aitsc_paper_stack_enabled', true);
    $distance = get_theme_mod('aitsc_paper_stack_distance', 100);
    $duration = get_theme_mod('aitsc_paper_stack_duration', 0.6);
    $easing = get_theme_mod('aitsc_paper_stack_easing', 'ease-out');

    if (!$enabled) {
        return;
    }

    ?>
    <style id="aitsc-paper-stack-customizer">
        :root {
            --ps-distance: <?php echo esc_attr($distance); ?>px;
            --ps-duration: <?php echo esc_attr($duration); ?>s;
            --ps-easing: <?php echo esc_attr($easing); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'aitsc_paper_stack_customizer_css', 20);

/**
 * ACF integration for Paper Stack settings per page
 */
function aitsc_paper_stack_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key' => 'group_paper_stack_settings',
        'title' => 'Paper Stack Animation Settings',
        'fields' => [
            [
                'key' => 'field_paper_stack_enabled',
                'label' => 'Enable Paper Stack',
                'name' => 'paper_stack_enabled',
                'type' => 'true_false',
                'instructions' => 'Enable paper stack scroll animations for this page',
                'default_value' => 1,
                'ui' => 1,
            ],
            [
                'key' => 'field_paper_stack_variant',
                'label' => 'Animation Style',
                'name' => 'paper_stack_variant',
                'type' => 'select',
                'choices' => [
                    'default' => 'Default',
                    'subtle' => 'Subtle',
                    'dramatic' => 'Dramatic',
                    'fast' => 'Fast',
                    'slow' => 'Slow',
                ],
                'default_value' => 'default',
                'conditional_logic' => [
                    [
                        [
                            'field' => 'field_paper_stack_enabled',
                            'operator' => '==',
                            'value' => '1',
                        ],
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ],
            ],
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'solutions',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
    ]);
}
add_action('acf/init', 'aitsc_paper_stack_acf_fields');

/**
 * Get Paper Stack settings for current page
 */
function aitsc_get_paper_stack_settings() {
    $settings = [
        'enabled' => true,
        'variant' => 'default',
    ];

    // Check theme mod
    if (!get_theme_mod('aitsc_paper_stack_enabled', true)) {
        $settings['enabled'] = false;
        return $settings;
    }

    // Check ACF field if available
    if (function_exists('get_field')) {
        $acf_enabled = get_field('paper_stack_enabled');
        $acf_variant = get_field('paper_stack_variant');

        if (is_bool($acf_enabled)) {
            $settings['enabled'] = $acf_enabled;
        }

        if ($acf_variant) {
            $settings['variant'] = $acf_variant;
        }
    }

    return $settings;
}
