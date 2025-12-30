<?php
/**
 * Logo Carousel Component
 *
 * Horizontal auto-scrolling logo carousel with grayscale logos.
 * CSS-only animation with pause on hover and reduced motion support.
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 4.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Logo Carousel Component
 *
 * @param array $args {
 *     @type array  $logos Array of logo data [['name' => '', 'image' => '', 'url' => '']]
 *     @type string $title Optional section title
 *     @type string $class Additional CSS classes
 *     @type int    $speed Animation speed in seconds (default: 30)
 * }
 */
function aitsc_render_logo_carousel($args = []) {
    $defaults = [
        'logos' => [],
        'title' => '',
        'class' => '',
        'speed' => 30,
    ];

    $args = wp_parse_args($args, $defaults);

    // Use placeholder logos if none provided
    if (empty($args['logos'])) {
        $args['logos'] = [
            ['name' => 'Partner 1', 'image' => '', 'url' => ''],
            ['name' => 'Partner 2', 'image' => '', 'url' => ''],
            ['name' => 'Partner 3', 'image' => '', 'url' => ''],
            ['name' => 'Partner 4', 'image' => '', 'url' => ''],
            ['name' => 'Partner 5', 'image' => '', 'url' => ''],
            ['name' => 'Partner 6', 'image' => '', 'url' => ''],
        ];
    }

    $logos = $args['logos'];
    $title = !empty($args['title']) ? esc_html($args['title']) : '';
    $class = esc_attr($args['class']);
    $speed = absint($args['speed']);

    // Duplicate logos for seamless loop
    $all_logos = array_merge($logos, $logos);

    ?>
    <section class="aitsc-logo-carousel <?php echo esc_attr($class); ?>" role="region" aria-label="Partner logos">
        <?php if ($title): ?>
            <div class="aitsc-logo-carousel__header">
                <h2 class="aitsc-logo-carousel__title"><?php echo esc_html($title); ?></h2>
            </div>
        <?php endif; ?>

        <div class="aitsc-logo-carousel__wrapper">
            <div class="aitsc-logo-carousel__track" style="--carousel-speed: <?php echo absint($speed); ?>s;" aria-live="off">
                <?php foreach ($all_logos as $index => $logo): ?>
                    <div class="aitsc-logo-carousel__item" role="listitem">
                        <?php if (!empty($logo['url'])): ?>
                            <a href="<?php echo esc_url($logo['url']); ?>"
                               class="aitsc-logo-carousel__link"
                               target="_blank"
                               rel="noopener noreferrer"
                               aria-label="<?php echo esc_attr($logo['name']); ?>">
                        <?php endif; ?>

                        <?php if (!empty($logo['image'])): ?>
                            <img src="<?php echo esc_url($logo['image']); ?>"
                                 alt="<?php echo esc_attr($logo['name']); ?> logo"
                                 class="aitsc-logo-carousel__logo"
                                 loading="lazy">
                        <?php else: ?>
                            <!-- Text placeholder when no logo image provided -->
                            <div class="aitsc-logo-carousel__placeholder">
                                <span><?php echo esc_html($logo['name']); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($logo['url'])): ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

/**
 * Logo Carousel Shortcode Handler
 *
 * Usage: [aitsc_logo_carousel title="Our Partners" speed="30" logos="json_encoded_array"]
 */
function aitsc_logo_carousel_shortcode($atts) {
    $atts = shortcode_atts([
        'title' => '',
        'speed' => 30,
        'logos' => '',
        'class' => '',
    ], $atts);

    // Parse logos JSON if provided
    if (!empty($atts['logos'])) {
        $logos_data = json_decode(urldecode($atts['logos']), true);
        if (is_array($logos_data)) {
            $atts['logos'] = $logos_data;
        }
    }

    ob_start();
    aitsc_render_logo_carousel($atts);
    return ob_get_clean();
}
add_shortcode('aitsc_logo_carousel', 'aitsc_logo_carousel_shortcode');
