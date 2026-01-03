<?php
/**
 * Hero Solution Page Component
 *
 * Universal hero component for solution pages with ACF integration
 * WorldQuant-inspired design with animations and optional data ticker
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Hero for Solution Pages
 *
 * @param array $args Component configuration
 *   - variant (string): Component variant (default: 'solution-page')
 *   - show_ticker (bool): Display data ticker (default: false)
 *   - animation (bool): Enable animations (default: true)
 *   - post_id (int): Post ID for ACF data (default: current post)
 */
function aitsc_render_hero_solution($args = array()) {
    $defaults = array(
        'variant' => 'solution-page',
        'show_ticker' => false,
        'animation' => true,
        'post_id' => get_the_ID()
    );

    $args = wp_parse_args($args, $defaults);

    // Get ACF hero section data
    $hero_data = get_field('hero_section', $args['post_id']);

    // Fallback values if ACF data missing
    $title = !empty($hero_data['title']) ? $hero_data['title'] : get_the_title($args['post_id']);
    $subtitle = !empty($hero_data['subtitle']) ? $hero_data['subtitle'] : '';
    $description = !empty($hero_data['description']) ? $hero_data['description'] : get_the_excerpt($args['post_id']);
    $cta_primary_text = !empty($hero_data['cta_text']) ? $hero_data['cta_text'] : 'Request Demo';
    $cta_primary_link = !empty($hero_data['cta_link']) ? $hero_data['cta_link'] : '#contact';
    $cta_secondary_text = !empty($hero_data['cta_secondary_text']) ? $hero_data['cta_secondary_text'] : 'View Technical Specs';
    $cta_secondary_link = !empty($hero_data['cta_secondary_link']) ? $hero_data['cta_secondary_link'] : '#technical-specs';

    // Hero image
    $hero_image = !empty($hero_data['image']) ? $hero_data['image'] : '';

    // Data ticker items (optional)
    $ticker_items = !empty($hero_data['ticker_items']) ? $hero_data['ticker_items'] : array();

    // Animation classes
    $animate_class = $args['animation'] ? 'animate-fade-in' : '';
    $animate_title = $args['animation'] ? 'animate-title' : '';

    ?>
    <!-- Hero Section (Solution Page - WorldQuant Style) -->
    <section class="scroll-section hero-section hero-solution <?php echo esc_attr($args['variant']); ?>"
        style="padding-top: 15vh; padding-bottom: 10vh; min-height: 100vh; position: relative;">
        <div class="aitsc-container">
            <div style="max-width: 83.33%; margin: 0 auto; text-align: center;">

                <?php if ($subtitle): ?>
                <!-- Subtitle (appears above title) -->
                <p class="aitsc-hero__subtitle <?php echo esc_attr($animate_class); ?> delay-1">
                    <?php echo esc_html($subtitle); ?>
                </p>
                <?php endif; ?>

                <!-- Animated Title -->
                <h1 class="aitsc-hero__title <?php echo esc_attr($animate_title); ?>" style="margin-bottom: 2rem;">
                    <?php echo esc_html($title); ?>
                </h1>

                <?php if ($description): ?>
                <!-- Description -->
                <p class="aitsc-hero__description mt-4 <?php echo esc_attr($animate_class); ?> delay-2"
                    style="max-width: 56.25rem; margin-left: auto; margin-right: auto; font-size: 1.25rem; line-height: 1.8;">
                    <?php echo esc_html($description); ?>
                </p>
                <?php endif; ?>

                <!-- Hero CTAs -->
                <div class="hero-cta-group <?php echo esc_attr($animate_class); ?> delay-3"
                    style="margin-top: 3rem; display: flex; gap: 1.5rem; justify-content: center; align-items: center; flex-wrap: wrap;">

                    <?php if ($cta_primary_text && $cta_primary_link): ?>
                    <a href="<?php echo esc_url($cta_primary_link); ?>" class="hero-cta-primary">
                        <span><?php echo esc_html($cta_primary_text); ?></span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                    <?php endif; ?>

                    <?php if ($cta_secondary_text && $cta_secondary_link): ?>
                    <a href="<?php echo esc_url($cta_secondary_link); ?>" class="hero-cta-secondary">
                        <span><?php echo esc_html($cta_secondary_text); ?></span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if ($args['show_ticker'] && !empty($ticker_items)): ?>
        <!-- Bottom Data Ticker -->
        <div class="data-ticker-wrap"
            style="position: absolute; bottom: 0; left: 0; width: 100%; overflow: hidden; background: rgba(0, 0, 0, 0.5); border-top: 1px solid var(--aitsc-grid-line); padding: 0.75rem 0; backdrop-filter: blur(5px);">
            <div class="data-ticker" style="display: flex; white-space: nowrap; animation: ticker 35s linear infinite;">
                <?php foreach ($ticker_items as $item): ?>
                <span class="ticker-item">
                    <?php echo esc_html($item['label']); ?>:
                    <strong class="<?php echo esc_attr($item['color_class']); ?>">
                        <?php echo esc_html($item['value']); ?>
                    </strong>
                </span>
                <?php endforeach; ?>
                <!-- Duplicate for seamless loop -->
                <?php foreach ($ticker_items as $item): ?>
                <span class="ticker-item">
                    <?php echo esc_html($item['label']); ?>:
                    <strong class="<?php echo esc_attr($item['color_class']); ?>">
                        <?php echo esc_html($item['value']); ?>
                    </strong>
                </span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php elseif ($args['show_ticker']): ?>
        <!-- Default ticker if no ACF data -->
        <div class="data-ticker-wrap"
            style="position: absolute; bottom: 0; left: 0; width: 100%; overflow: hidden; background: rgba(0, 0, 0, 0.5); border-top: 1px solid var(--aitsc-grid-line); padding: 0.75rem 0; backdrop-filter: blur(5px);">
            <div class="data-ticker" style="display: flex; white-space: nowrap; animation: ticker 35s linear infinite;">
                <span class="ticker-item">REAL-TIME MONITORING: <strong class="text-green">ACTIVE</strong></span>
                <span class="ticker-item">PLUG & PLAY SETUP: <strong class="text-blue">100%</strong></span>
                <span class="ticker-item">AUTO-CONFIGURATION: <strong class="text-green">ZERO PROGRAMMING</strong></span>
                <span class="ticker-item">WARRANTY COVERAGE: <strong class="text-blue">12 MONTHS</strong></span>
                <!-- Duplicate for seamless loop -->
                <span class="ticker-item">REAL-TIME MONITORING: <strong class="text-green">ACTIVE</strong></span>
                <span class="ticker-item">PLUG & PLAY SETUP: <strong class="text-blue">100%</strong></span>
            </div>
        </div>
        <?php endif; ?>
    </section>
    <?php
}
