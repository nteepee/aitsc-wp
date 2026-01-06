<?php
/**
 * Universal Hero Component
 *
 * A versatile hero section component supporting multiple variants
 * (homepage, page, pillar, minimal) for different page types.
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Universal Hero Component
 *
 * @param array $args {
 *     Hero configuration arguments
 *
 *     @type string $variant           Hero variant: 'homepage'|'page'|'pillar'|'minimal'. Default 'page'.
 *     @type string $title             Hero title (required).
 *     @type string $subtitle          Subtitle/tagline.
 *     @type string $description       Description text.
 *     @type string $cta_primary       Primary CTA text.
 *     @type string $cta_primary_link  Primary CTA URL.
 *     @type string $cta_secondary     Secondary CTA text.
 *     @type string $cta_secondary_link Secondary CTA URL.
 *     @type string $image             Background/featured image URL.
 *     @type bool   $show_breadcrumb   Show breadcrumb navigation. Default false.
 *     @type string $height            Hero height: 'small'|'medium'|'large'|'full'. Default 'large'.
 *     @type string $custom_class      Additional CSS classes.
 * }
 * @return void
 */
function aitsc_render_hero($args = array())
{
    $defaults = array(
        'variant' => 'page',
        'title' => '',
        'subtitle' => '',
        'description' => '',
        'cta_primary' => '',
        'cta_primary_link' => '',
        'cta_secondary' => '',
        'cta_secondary_link' => '',
        'image' => '',
        'show_breadcrumb' => false,
        'height' => 'large',
        'custom_class' => ''
    );

    $args = wp_parse_args($args, $defaults);

    // Validate required fields
    if (empty($args['title'])) {
        return;
    }

    // Sanitize data
    $variant = esc_attr($args['variant']);
    $title = wp_kses_post($args['title']);
    $subtitle = wp_kses_post($args['subtitle']);
    $description = wp_kses_post($args['description']);
    $cta_primary = esc_html($args['cta_primary']);
    $cta_primary_link = esc_url($args['cta_primary_link']);
    $cta_secondary = esc_html($args['cta_secondary']);
    $cta_secondary_link = esc_url($args['cta_secondary_link']);
    $image = esc_url($args['image']);
    $show_breadcrumb = (bool) $args['show_breadcrumb'];
    $height = esc_attr($args['height']);
    $custom_class = esc_attr($args['custom_class']);

    // Generate ARIA labels for CTA buttons (WCAG 2.1 AA compliance)
    $cta_primary_aria_label = '';
    $cta_secondary_aria_label = '';

    if (!empty($cta_primary) && !empty($cta_primary_link)) {
        $cta_primary_text = wp_strip_all_tags($args['cta_primary']);
        if (!empty($description)) {
            $desc_text = wp_strip_all_tags($args['description']);
            $trimmed_desc = wp_trim_words($desc_text, 10, '...');
            $cta_primary_aria_label = $cta_primary_text . ' - ' . $trimmed_desc;
        } else {
            $cta_primary_aria_label = $cta_primary_text;
        }
        $cta_primary_aria_label = esc_attr($cta_primary_aria_label);
    }

    if (!empty($cta_secondary) && !empty($cta_secondary_link)) {
        $cta_secondary_text = wp_strip_all_tags($args['cta_secondary']);
        if (!empty($description)) {
            $desc_text = wp_strip_all_tags($args['description']);
            $trimmed_desc = wp_trim_words($desc_text, 10, '...');
            $cta_secondary_aria_label = $cta_secondary_text . ' - ' . $trimmed_desc;
        } else {
            $cta_secondary_aria_label = $cta_secondary_text;
        }
        $cta_secondary_aria_label = esc_attr($cta_secondary_aria_label);
    }

    // Build CSS classes
    $classes = array(
        'aitsc-hero',
        "aitsc-hero--{$variant}",
        "aitsc-hero--{$height}"
    );

    if (!empty($custom_class)) {
        $classes[] = $custom_class;
    }

    $class_string = implode(' ', array_filter($classes));

    // Background style for image
    $bg_style = '';
    if (!empty($image)) {
        $bg_style = sprintf(' style="background-image: url(\'%s\')"', $image);
    }

    // Start output
    echo sprintf('<section class="%s"%s>', $class_string, $bg_style);

    // Background overlay for image variants
    if (!empty($image) || $variant === 'homepage') {
        echo '<div class="aitsc-hero__overlay"></div>';
    }

    // Particle background for homepage variant
    if ($variant === 'homepage') {
        echo '<canvas id="particle-canvas" class="aitsc-hero__particles" aria-hidden="true"></canvas>';
    }

    // Hero content wrapper
    echo '<div class="aitsc-hero__container">';

    // Breadcrumb (if enabled)
    if ($show_breadcrumb && function_exists('aitsc_breadcrumb')) {
        echo '<div class="aitsc-hero__breadcrumb">';
        aitsc_breadcrumb();
        echo '</div>';
    }

    // Hero content
    echo '<div class="aitsc-hero__content">';

    // Subtitle
    if (!empty($subtitle)) {
        echo sprintf(
            '<p class="aitsc-hero__subtitle">%s</p>',
            $subtitle
        );
    }

    // Title
    echo sprintf(
        '<h1 class="aitsc-hero__title">%s</h1>',
        $title
    );

    // Description
    if (!empty($description)) {
        echo sprintf(
            '<p class="aitsc-hero__description">%s</p>',
            $description
        );
    }

    // CTAs
    if (!empty($cta_primary) || !empty($cta_secondary)) {
        echo '<div class="aitsc-hero__ctas">';

        // Primary CTA
        if (!empty($cta_primary) && !empty($cta_primary_link)) {
            $primary_aria = !empty($cta_primary_aria_label) ? sprintf(' aria-label="%s"', $cta_primary_aria_label) : '';
            echo sprintf(
                '<a href="%s" class="aitsc-btn aitsc-btn--primary aitsc-btn--large"%s>%s</a>',
                $cta_primary_link,
                $primary_aria,
                $cta_primary
            );
        }

        // Secondary CTA
        if (!empty($cta_secondary) && !empty($cta_secondary_link)) {
            $secondary_aria = !empty($cta_secondary_aria_label) ? sprintf(' aria-label="%s"', $cta_secondary_aria_label) : '';
            echo sprintf(
                '<a href="%s" class="aitsc-btn aitsc-btn--secondary aitsc-btn--large"%s>%s</a>',
                $cta_secondary_link,
                $secondary_aria,
                $cta_secondary
            );
        }

        echo '</div>'; // .aitsc-hero__ctas
    }

    echo '</div>'; // .aitsc-hero__content
    echo '</div>'; // .aitsc-hero__container
    echo '</section>'; // .aitsc-hero
}

/**
 * Breadcrumb Function
 * Generates breadcrumb navigation for hero section
 *
 * @return void
 */
function aitsc_breadcrumb()
{
    if (is_front_page()) {
        return;
    }

    $breadcrumbs = array();
    $breadcrumbs[] = array(
        'url' => home_url('/'),
        'text' => __('Home', 'aitsc-pro-theme')
    );

    // Add post type archives
    if (is_post_type_archive()) {
        $post_type = get_post_type();
        $breadcrumbs[] = array(
            'url' => '',
            'text' => post_type_archive_title('', false)
        );
    }

    // Add single posts
    if (is_singular()) {
        $post_type = get_post_type();

        if ($post_type !== 'page') {
            $post_type_obj = get_post_type_object($post_type);
            if ($post_type_obj && $post_type_obj->has_archive) {
                $breadcrumbs[] = array(
                    'url' => get_post_type_archive_link($post_type),
                    'text' => $post_type_obj->labels->name
                );
            }
        }

        $breadcrumbs[] = array(
            'url' => '',
            'text' => get_the_title()
        );
    }

    // Output breadcrumbs
    echo '<nav class="aitsc-breadcrumb" aria-label="Breadcrumb">';
    echo '<ol class="aitsc-breadcrumb__list">';

    foreach ($breadcrumbs as $index => $crumb) {
        $is_last = ($index === count($breadcrumbs) - 1);

        echo '<li class="aitsc-breadcrumb__item">';

        if ($is_last) {
            echo sprintf('<span class="aitsc-breadcrumb__current">%s</span>', esc_html($crumb['text']));
        } else {
            echo sprintf('<a href="%s" class="aitsc-breadcrumb__link">%s</a>', esc_url($crumb['url']), esc_html($crumb['text']));
        }

        if (!$is_last) {
            echo '<span class="aitsc-breadcrumb__separator">/</span>';
        }

        echo '</li>';
    }

    echo '</ol>';
    echo '</nav>';
}
