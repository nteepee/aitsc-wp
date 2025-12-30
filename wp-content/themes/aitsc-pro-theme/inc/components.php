<?php
/**
 * Component System Registration
 *
 * Registers and enqueues all universal components (card, hero, cta, stats, testimonial).
 * Provides a centralized system for component management.
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load Component Functions
 *
 * Loads all component PHP files for use in templates.
 */
function aitsc_load_components() {
    $component_dir = get_template_directory() . '/components';

    // Load card component
    require_once $component_dir . '/card/card-base.php';

    // Load hero component
    require_once $component_dir . '/hero/hero-universal.php';

    // Load CTA component
    require_once $component_dir . '/cta/cta-block.php';

    // Load stats component
    require_once $component_dir . '/stats/stats-counter.php';

    // Load testimonial component
    require_once $component_dir . '/testimonial/testimonial-carousel.php';

    // Load Phase 3 Harrison.ai components
    require_once $component_dir . '/trust-bar/trust-bar.php';
    require_once $component_dir . '/logo-carousel/logo-carousel.php';
    require_once $component_dir . '/image-composition/image-composition.php';
}
add_action('after_setup_theme', 'aitsc_load_components');

/**
 * Enqueue Component Styles
 *
 * Enqueues all component CSS files with proper dependencies and versioning.
 */
function aitsc_enqueue_component_styles() {
    $component_dir = get_template_directory_uri() . '/components';
    $component_path = get_template_directory() . '/components';

    // Card component styles
    $card_css = $component_path . '/card/card-variants.css';
    if (file_exists($card_css)) {
        wp_enqueue_style(
            'aitsc-component-card-variants',
            $component_dir . '/card/card-variants.css',
            array(),
            AITSC_VERSION
        );
    }

    $card_anim_css = $component_path . '/card/card-animations.css';
    if (file_exists($card_anim_css)) {
        wp_enqueue_style(
            'aitsc-component-card-animations',
            $component_dir . '/card/card-animations.css',
            array('aitsc-component-card-variants'),
            AITSC_VERSION
        );
    }

    // Hero component styles
    $hero_css = $component_path . '/hero/hero-variants.css';
    if (file_exists($hero_css)) {
        wp_enqueue_style(
            'aitsc-component-hero-variants',
            $component_dir . '/hero/hero-variants.css',
            array(),
            AITSC_VERSION
        );
    }

    $hero_anim_css = $component_path . '/hero/hero-animations.css';
    if (file_exists($hero_anim_css)) {
        wp_enqueue_style(
            'aitsc-component-hero-animations',
            $component_dir . '/hero/hero-animations.css',
            array('aitsc-component-hero-variants'),
            AITSC_VERSION
        );
    }

    // CTA component styles
    $cta_css = $component_path . '/cta/cta-styles.css';
    if (file_exists($cta_css)) {
        wp_enqueue_style(
            'aitsc-component-cta',
            $component_dir . '/cta/cta-styles.css',
            array(),
            AITSC_VERSION
        );
    }

    // Stats component styles
    $stats_css = $component_path . '/stats/stats-styles.css';
    if (file_exists($stats_css)) {
        wp_enqueue_style(
            'aitsc-component-stats',
            $component_dir . '/stats/stats-styles.css',
            array(),
            AITSC_VERSION
        );
    }

    // Testimonial component styles
    $testimonial_css = $component_path . '/testimonial/carousel-styles.css';
    if (file_exists($testimonial_css)) {
        wp_enqueue_style(
            'aitsc-component-testimonial',
            $component_dir . '/testimonial/carousel-styles.css',
            array(),
            AITSC_VERSION
        );
    }

    // Phase 3 Harrison.ai component styles
    $trust_bar_css = $component_path . '/trust-bar/trust-bar-styles.css';
    if (file_exists($trust_bar_css)) {
        wp_enqueue_style(
            'aitsc-component-trust-bar',
            $component_dir . '/trust-bar/trust-bar-styles.css',
            array(),
            AITSC_VERSION
        );
    }

    $logo_carousel_css = $component_path . '/logo-carousel/logo-carousel-styles.css';
    if (file_exists($logo_carousel_css)) {
        wp_enqueue_style(
            'aitsc-component-logo-carousel',
            $component_dir . '/logo-carousel/logo-carousel-styles.css',
            array(),
            AITSC_VERSION
        );
    }

    $image_composition_css = $component_path . '/image-composition/image-composition-styles.css';
    if (file_exists($image_composition_css)) {
        wp_enqueue_style(
            'aitsc-component-image-composition',
            $component_dir . '/image-composition/image-composition-styles.css',
            array(),
            AITSC_VERSION
        );
    }
}
add_action('wp_enqueue_scripts', 'aitsc_enqueue_component_styles');

/**
 * Enqueue Component Scripts
 *
 * Enqueues all component JavaScript files with proper dependencies.
 */
function aitsc_enqueue_component_scripts() {
    $component_dir = get_template_directory_uri() . '/components';
    $component_path = get_template_directory() . '/components';

    // Stats counter script
    $stats_js = $component_path . '/stats/stats-counter.js';
    if (file_exists($stats_js)) {
        wp_enqueue_script(
            'aitsc-component-stats',
            $component_dir . '/stats/stats-counter.js',
            array(),
            AITSC_VERSION,
            true
        );
    }

    // Testimonial carousel script
    $testimonial_js = $component_path . '/testimonial/carousel.js';
    if (file_exists($testimonial_js)) {
        wp_enqueue_script(
            'aitsc-component-testimonial',
            $component_dir . '/testimonial/carousel.js',
            array(),
            AITSC_VERSION,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'aitsc_enqueue_component_scripts');

/**
 * Register Material Symbols Icon Font
 *
 * Required by components for icon display (Material Symbols Outlined).
 */
function aitsc_enqueue_material_symbols() {
    wp_enqueue_style(
        'material-symbols-outlined',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'aitsc_enqueue_material_symbols');

/**
 * Component Shortcodes
 *
 * Provides shortcode shortcuts for component usage.
 */

// Card shortcode
function aitsc_card_shortcode($atts) {
    $atts = shortcode_atts(array(
        'variant'     => 'solid',
        'title'       => '',
        'description' => '',
        'link'        => '',
        'icon'        => '',
        'image'       => '',
        'cta_text'    => __('Learn More', 'aitsc-pro-theme'),
        'size'        => 'medium'
    ), $atts);

    ob_start();
    aitsc_render_card($atts);
    return ob_get_clean();
}
add_shortcode('aitsc_card', 'aitsc_card_shortcode');

// Hero shortcode
function aitsc_hero_shortcode($atts) {
    $atts = shortcode_atts(array(
        'variant'     => 'page',
        'title'       => '',
        'subtitle'    => '',
        'description' => '',
        'cta_primary' => '',
        'cta_primary_link' => '',
        'cta_secondary' => '',
        'cta_secondary_link' => '',
        'height'      => 'large'
    ), $atts);

    ob_start();
    aitsc_render_hero($atts);
    return ob_get_clean();
}
add_shortcode('aitsc_hero', 'aitsc_hero_shortcode');

// CTA shortcode
function aitsc_cta_shortcode($atts) {
    $atts = shortcode_atts(array(
        'variant'     => 'button',
        'title'       => '',
        'description' => '',
        'button_text' => '',
        'button_link' => ''
    ), $atts);

    ob_start();
    aitsc_render_cta($atts);
    return ob_get_clean();
}
add_shortcode('aitsc_cta', 'aitsc_cta_shortcode');

// Stats shortcode
function aitsc_stats_shortcode($atts) {
    // Parse stats from JSON format
    $stats_json = isset($atts['stats']) ? $atts['stats'] : '';

    if (!empty($stats_json)) {
        $stats = json_decode(urldecode($stats_json), true);
    } else {
        $stats = array();
    }

    ob_start();
    aitsc_render_stats($stats);
    return ob_get_clean();
}
add_shortcode('aitsc_stats', 'aitsc_stats_shortcode');

// Testimonials shortcode
function aitsc_testimonials_shortcode($atts) {
    $testimonials_json = isset($atts['testimonials']) ? $atts['testimonials'] : '';

    if (!empty($testimonials_json)) {
        $testimonials = json_decode(urldecode($testimonials_json), true);
    } else {
        $testimonials = array();
    }

    ob_start();
    aitsc_render_testimonials($testimonials);
    return ob_get_clean();
}
add_shortcode('aitsc_testimonials', 'aitsc_testimonials_shortcode');

/**
 * ==============================================================
 * SOLUTION PAGE COMPONENTS
 * ==============================================================
 * Specialized components for ACF-powered solution landing pages
 */

/**
 * Render Feature Box Component
 *
 * Glassmorphism feature card with icon, title, description.
 *
 * @param array $args {
 *     @type string $icon Icon name (Material Symbols)
 *     @type string $title Feature title
 *     @type string $description Feature description
 *     @type string $variant Card variant (glass|solid)
 * }
 */
function aitsc_component_feature_box($args = []) {
    $defaults = [
        'icon' => 'check_circle',
        'title' => '',
        'description' => '',
        'variant' => 'glass',
    ];

    $args = wp_parse_args($args, $defaults);
    extract($args);

    $variant_class = ($variant === 'solid') ? 'bg-blue-600/20' : 'bg-white/5 backdrop-blur-xl';
    ?>

    <div class="group relative <?php echo esc_attr($variant_class); ?> border border-blue-600/30
                rounded-2xl p-8 hover:bg-white/10 hover:border-blue-600/60
                transition-all duration-300 cursor-pointer">

        <!-- Background Gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/5 to-purple-600/5
                    rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

        <!-- Content -->
        <div class="relative z-10">
            <!-- Icon -->
            <div class="w-16 h-16 bg-blue-600/20 rounded-xl flex items-center justify-center mb-6
                        group-hover:bg-blue-600/30 transition-colors duration-200">
                <span class="material-symbols-outlined text-4xl text-blue-400"><?php echo esc_html($icon); ?></span>
            </div>

            <!-- Title -->
            <h3 class="text-xl font-semibold text-white mb-3 group-hover:text-blue-300 transition-colors duration-200">
                <?php echo esc_html($title); ?>
            </h3>

            <!-- Description -->
            <p class="text-sm text-slate-400 leading-relaxed">
                <?php echo esc_html($description); ?>
            </p>

            <!-- Arrow -->
            <div class="mt-6 flex items-center gap-2 text-blue-400 opacity-0 group-hover:opacity-100
                        transform translate-x-0 group-hover:translate-x-2 transition-all duration-300">
                <span class="text-sm font-semibold">Explore</span>
                <span class="material-symbols-outlined text-xl">arrow_forward</span>
            </div>
        </div>
    </div>

    <?php
}

/**
 * Render Specification Table Component
 *
 * Technical specifications table with responsive design.
 *
 * @param array $specs Array of specification rows [label => value]
 */
function aitsc_component_spec_table($specs = []) {
    if (empty($specs)) {
        return;
    }
    ?>

    <div class="bg-slate-950/50 rounded-2xl border border-blue-600/20 p-8 md:p-12 overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b border-blue-600/20">
                    <th class="text-left py-4 px-4 text-base font-semibold text-slate-300">Specification</th>
                    <th class="text-left py-4 px-4 text-base font-semibold text-slate-300">Details</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($specs as $label => $value): ?>
                    <tr class="border-b border-slate-800/50 hover:bg-blue-600/5 transition-colors duration-150">
                        <td class="py-4 px-4 text-blue-400 font-medium"><?php echo esc_html($label); ?></td>
                        <td class="py-4 px-4 text-slate-300"><?php echo esc_html($value); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php
}

/**
 * Render CTA Section Component
 *
 * Call-to-action section with form or buttons.
 *
 * @param array $args {
 *     @type string $title CTA title
 *     @type string $description CTA description
 *     @type string $button_text Primary button text
 *     @type string $button_link Primary button link
 *     @type string $form_shortcode Optional form shortcode
 * }
 */
function aitsc_component_cta_section($args = []) {
    $defaults = [
        'title' => 'Ready to Get Started?',
        'description' => 'Contact us to discuss how our solutions can help your project',
        'button_text' => 'Request Quote',
        'button_link' => '#contact',
        'form_shortcode' => '',
    ];

    $args = wp_parse_args($args, $defaults);
    extract($args);
    ?>

    <section class="bg-gradient-to-r from-blue-600/10 to-purple-600/10 border-y border-blue-600/20 py-16">
        <div class="max-w-4xl mx-auto px-4 md:px-8">
            <div class="text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4"><?php echo esc_html($title); ?></h2>

                <?php if ($description): ?>
                    <p class="text-lg md:text-xl text-slate-300 mb-8">
                        <?php echo esc_html($description); ?>
                    </p>
                <?php endif; ?>
            </div>

            <?php if ($form_shortcode): ?>
                <div class="mt-8">
                    <?php echo do_shortcode($form_shortcode); ?>
                </div>
            <?php else: ?>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?php echo esc_url($button_link); ?>"
                       class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200 text-center">
                        <?php echo esc_html($button_text); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>"
                       class="px-8 py-4 border-2 border-blue-600 text-blue-400 hover:bg-blue-600/10 font-semibold rounded-lg transition-all duration-200 text-center">
                        Contact Us
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php
}

/**
 * Render Case Study Card Component
 *
 * Card for displaying case studies in solution pages.
 *
 * @param int $post_id Case study post ID
 */
function aitsc_component_case_study_card($post_id) {
    if (!$post_id) {
        return;
    }

    $title = get_the_title($post_id);
    $excerpt = get_the_excerpt($post_id);
    $permalink = get_permalink($post_id);
    $thumbnail = get_the_post_thumbnail_url($post_id, 'medium');
    $client = get_post_meta($post_id, '_case_study_client', true);
    $industry = get_post_meta($post_id, '_case_study_client_industry', true);
    ?>

    <div class="bg-gradient-to-br from-blue-600/10 to-purple-600/10 border border-blue-600/20 rounded-xl overflow-hidden hover:border-blue-600/60 transition-all duration-300 group">
        <?php if ($thumbnail): ?>
            <div class="relative h-48 overflow-hidden">
                <img src="<?php echo esc_url($thumbnail); ?>"
                     alt="<?php echo esc_attr($title); ?>"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            </div>
        <?php endif; ?>

        <div class="p-6">
            <h3 class="text-xl font-bold text-white mb-3 group-hover:text-blue-300 transition-colors">
                <?php echo esc_html($title); ?>
            </h3>

            <?php if ($excerpt): ?>
                <p class="text-sm text-slate-400 mb-4 line-clamp-3">
                    <?php echo esc_html($excerpt); ?>
                </p>
            <?php endif; ?>

            <div class="flex items-center justify-between pt-4 border-t border-blue-600/20 text-sm">
                <?php if ($client): ?>
                    <span class="text-blue-400"><?php echo esc_html($client); ?></span>
                <?php endif; ?>
                <?php if ($industry): ?>
                    <span class="text-slate-400"><?php echo esc_html($industry); ?></span>
                <?php endif; ?>
            </div>

            <a href="<?php echo esc_url($permalink); ?>"
               class="mt-4 inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 transition-colors">
                <span class="text-sm font-semibold">View Case Study</span>
                <span class="material-symbols-outlined text-xl">arrow_forward</span>
            </a>
        </div>
    </div>

    <?php
}
