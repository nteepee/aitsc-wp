<?php
/**
 * Paper Stack Scroll Effect Component
 *
 * Universal section-by-section scroll animation wrapper
 *
 * @package AITSC_Pro_Theme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Output opening paper stack wrapper
 *
 * @param array $args {
 *     Optional. Array of arguments.
 *
 *     @type bool   $enabled     Enable/disable paper stack effect. Default true.
 *     @type string $distance    Animation distance (50px/75px/100px/120px). Default '100px'.
 *     @type string $duration    Animation duration (0.3s/0.4s/0.5s/0.6s/0.7s/0.8s/1s). Default '0.6s'.
 *     @type string $easing      Animation easing (ease-out/ease-in-out/linear). Default 'ease-out'.
 *     @type string $variant     Animation variant (default/subtle/dramatic/fast/slow). Default 'default'.
 *     @type string $class       Custom CSS classes. Default empty.
 *     @type string $id          Custom element ID. Default empty.
 *     @type bool   $stagger     Enable staggered delays. Default true.
 * }
 */
function aitsc_paper_stack($args = []) {
    $defaults = [
        'enabled'  => true,
        'distance' => '100px',
        'duration' => '0.6s',
        'easing'   => 'ease-out',
        'variant'  => 'default',
        'class'    => '',
        'id'       => '',
        'stagger'  => true,
    ];

    $args = wp_parse_args($args, $defaults);

    // Check if reduced motion is preferred
    $reduced_motion = apply_filters('aitsc_paper_stack_reduced_motion', false);

    // Disable if user prefers reduced motion
    if ($reduced_motion) {
        $args['enabled'] = false;
    }

    // Build CSS classes
    $classes = ['paper-stack-wrapper'];

    if (!empty($args['variant']) && 'default' !== $args['variant']) {
        $classes[] = 'paper-stack-wrapper--' . sanitize_html_class($args['variant']);
    }

    if (!empty($args['class'])) {
        $classes[] = esc_attr($args['class']);
    }

    // Store settings for use in sections
    aitsc_paper_stack_set_settings($args);

    // Output opening tag
    printf(
        '<div class="%s"%s%s>',
        esc_attr(implode(' ', $classes)),
        !empty($args['id']) ? ' id="' . esc_attr($args['id']) . '"' : '',
        $args['enabled'] ? '' : ' data-paper-stack-disabled'
    );

    /**
     * Fires after opening paper stack wrapper
     *
     * @param array $args Component arguments.
     */
    do_action('aitsc_paper_stack_open', $args);
}

/**
 * Output paper stack section wrapper
 *
 * @param array $args {
 *     Optional. Array of arguments.
 *
 *     @type string $class       Custom CSS classes. Default empty.
 *     @type string $id          Custom element ID. Default empty.
 *     @type bool   $enabled     Enable animation for this section. Default true.
 *     @type string $delay       Custom delay (0s/0.1s/0.2s/etc). Default auto.
 * }
 */
function aitsc_paper_stack_section($args = []) {
    $defaults = [
        'class'   => '',
        'id'      => '',
        'enabled' => true,
        'delay'   => '',
    ];

    $args = wp_parse_args($args, $defaults);

    // Get current settings
    $settings = aitsc_paper_stack_get_settings();
    $enabled = $settings['enabled'] ?? true;

    // Build CSS classes
    $classes = ['paper-stack-section'];

    if (!$enabled || !$args['enabled']) {
        $classes[] = 'paper-stack-section--disabled';
    }

    if (!empty($args['class'])) {
        $classes[] = esc_attr($args['class']);
    }

    // Build inline styles for custom settings
    $styles = [];
    if (!$enabled && !$args['enabled']) {
        // No styles needed for disabled sections
    } elseif (!empty($args['delay'])) {
        $styles[] = '--ps-delay: ' . esc_attr($args['delay']);
    }

    // Output opening tag
    printf(
        '<section class="%s"%s%s%s>',
        esc_attr(implode(' ', $classes)),
        !empty($args['id']) ? ' id="' . esc_attr($args['id']) . '"' : '',
        !empty($styles) ? ' style="' . implode('; ', $styles) . '"' : '',
        !$enabled ? ' data-paper-stack-section-disabled' : ''
    );

    /**
     * Fires after opening paper stack section
     *
     * @param array $args Section arguments.
     */
    do_action('aitsc_paper_stack_section_open', $args);
}

/**
 * Output closing paper stack section wrapper
 */
function aitsc_paper_stack_section_end() {
    /**
     * Fires before closing paper stack section
     */
    do_action('aitsc_paper_stack_section_close');

    echo '</section>';
}

/**
 * Output closing paper stack wrapper
 */
function aitsc_paper_stack_end() {
    /**
     * Fires before closing paper stack wrapper
     */
    do_action('aitsc_paper_stack_close');

    // Clear settings
    aitsc_paper_stack_clear_settings();

    echo '</div>';
}

/**
 * Get current paper stack settings
 *
 * @return array Current settings
 */
function aitsc_paper_stack_get_settings() {
    static $settings = [];

    return $settings;
}

/**
 * Set paper stack settings
 *
 * @param array $args Component arguments.
 */
function aitsc_paper_stack_set_settings($args) {
    static $settings = [];

    $settings = $args;
}

/**
 * Clear paper stack settings
 */
function aitsc_paper_stack_clear_settings() {
    static $settings = [];

    $settings = [];
}

/**
 * Paper Stack Shortcode
 *
 * @param array  $atts    Shortcode attributes.
 * @param string $content Shortcode content.
 * @return string Output HTML.
 */
function aitsc_paper_stack_shortcode($atts, $content = '') {
    $atts = shortcode_atts([
        'enabled'  => 'true',
        'distance' => '100px',
        'duration' => '0.6s',
        'easing'   => 'ease-out',
        'variant'  => 'default',
        'class'    => '',
        'id'       => '',
        'stagger'  => 'true',
    ], $atts, 'aitsc_paper_stack');

    // Convert string booleans
    $atts['enabled'] = filter_var($atts['enabled'], FILTER_VALIDATE_BOOLEAN);
    $atts['stagger'] = filter_var($atts['stagger'], FILTER_VALIDATE_BOOLEAN);

    ob_start();
    aitsc_paper_stack($atts);
    echo do_shortcode($content);
    aitsc_paper_stack_end();
    return ob_get_clean();
}
add_shortcode('aitsc_paper_stack', 'aitsc_paper_stack_shortcode');

/**
 * Paper Stack Section Shortcode
 *
 * @param array  $atts    Shortcode attributes.
 * @param string $content Shortcode content.
 * @return string Output HTML.
 */
function aitsc_paper_stack_section_shortcode($atts, $content = '') {
    $atts = shortcode_atts([
        'class'   => '',
        'id'      => '',
        'enabled' => 'true',
        'delay'   => '',
    ], $atts, 'aitsc_paper_stack_section');

    $atts['enabled'] = filter_var($atts['enabled'], FILTER_VALIDATE_BOOLEAN);

    ob_start();
    aitsc_paper_stack_section($atts);
    echo do_shortcode($content);
    aitsc_paper_stack_section_end();
    return ob_get_clean();
}
add_shortcode('aitsc_paper_stack_section', 'aitsc_paper_stack_section_shortcode');
