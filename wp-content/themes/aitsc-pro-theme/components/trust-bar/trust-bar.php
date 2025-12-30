<?php
/**
 * Trust Bar Component
 *
 * Displays a centered trust statement on white background with cyan color.
 * Inspired by Harrison.ai design patterns.
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 4.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Trust Bar Component
 *
 * @param array $args {
 *     @type string $text Trust bar text content
 *     @type string $tag HTML tag for text (default: 'p')
 *     @type string $class Additional CSS classes
 * }
 */
function aitsc_render_trust_bar($args = []) {
    $defaults = [
        'text' => 'Trusted by leading transport safety organizations across Australia',
        'tag' => 'p',
        'class' => '',
    ];

    $args = wp_parse_args($args, $defaults);

    // Sanitize
    $text = wp_kses_post($args['text']);
    $tag = tag_escape($args['tag']);
    $additional_classes = esc_attr($args['class']);

    ?>
    <section class="aitsc-trust-bar <?php echo esc_attr($additional_classes); ?>" role="region" aria-label="Trust statement">
        <div class="aitsc-trust-bar__container">
            <<?php echo esc_html($tag); ?> class="aitsc-trust-bar__text">
                <?php echo wp_kses_post($text); ?>
            </<?php echo esc_html($tag); ?>>
        </div>
    </section>
    <?php
}

/**
 * Trust Bar Shortcode Handler
 *
 * Usage: [aitsc_trust_bar text="Your custom text" tag="h2"]
 */
function aitsc_trust_bar_shortcode($atts) {
    $atts = shortcode_atts([
        'text' => 'Trusted by leading transport safety organizations across Australia',
        'tag' => 'p',
        'class' => '',
    ], $atts);

    ob_start();
    aitsc_render_trust_bar($atts);
    return ob_get_clean();
}
add_shortcode('aitsc_trust_bar', 'aitsc_trust_bar_shortcode');
