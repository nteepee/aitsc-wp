<?php
/**
 * CTA Block Component
 *
 * A versatile call-to-action component supporting multiple variants
 * (form, button, banner, inline) for different conversion scenarios.
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render CTA Component
 *
 * @param array $args {
 *     CTA configuration arguments
 *
 *     @type string $variant      CTA variant: 'form'|'button'|'banner'|'inline'. Default 'button'.
 *     @type string $title        CTA title.
 *     @type string $description  Description text.
 *     @type string $button_text  Button text.
 *     @type string $button_link  Button URL.
 *     @type string $form_id      WordPress form shortcode (for form variant).
 *     @type string $background   Background color/gradient.
 *     @type string $text_color   Text color override.
 *     @type string $custom_class Additional CSS classes.
 * }
 * @return void
 */
function aitsc_render_cta($args = array()) {
    $defaults = array(
        'variant'      => 'button',
        'title'        => '',
        'description'  => '',
        'button_text'  => __('Learn More', 'aitsc-pro-theme'),
        'button_link'  => '',
        'form_id'      => '',
        'background'   => '',
        'text_color'   => '',
        'custom_class' => ''
    );

    $args = wp_parse_args($args, $defaults);

    // Sanitize data
    $variant      = esc_attr($args['variant']);
    $title        = wp_kses_post($args['title']);
    $description  = wp_kses_post($args['description']);
    $button_text  = esc_html($args['button_text']);
    $button_link  = esc_url($args['button_link']);
    $form_id      = esc_attr($args['form_id']);
    $background   = esc_attr($args['background']);
    $text_color   = esc_attr($args['text_color']);
    $custom_class = esc_attr($args['custom_class']);

    // Generate ARIA label for button links (WCAG 2.1 AA compliance)
    $button_aria_label = '';
    if (!empty($args['button_text']) && !empty($args['button_link'])) {
        $button_text_clean = wp_strip_all_tags($args['button_text']);
        if (!empty($title)) {
            $button_aria_label = $button_text_clean . ' - ' . wp_strip_all_tags($args['title']);
        } else {
            $button_aria_label = $button_text_clean;
        }
        $button_aria_label = esc_attr($button_aria_label);
    }

    // Build CSS classes
    $classes = array(
        'aitsc-cta',
        "aitsc-cta--{$variant}"
    );

    if (!empty($custom_class)) {
        $classes[] = $custom_class;
    }

    $class_string = implode(' ', array_filter($classes));

    // Build inline styles
    $style_string = '';
    if (!empty($background)) {
        $style_string .= sprintf('background: %s;', $background);
    }
    if (!empty($text_color)) {
        $style_string .= sprintf('color: %s;', $text_color);
    }

    // Start output
    echo sprintf('<section class="%s"%s>', $class_string, !empty($style_string) ? ' style="' . $style_string . '"' : '');

    // CTA container
    echo '<div class="aitsc-cta__container">';

    // CTA content
    echo '<div class="aitsc-cta__content">';

    // Title
    if (!empty($title)) {
        echo sprintf(
            '<h2 class="aitsc-cta__title">%s</h2>',
            $title
        );
    }

    // Description
    if (!empty($description)) {
        echo sprintf(
            '<p class="aitsc-cta__description">%s</p>',
            $description
        );
    }

    // Form variant
    if ($variant === 'form' && !empty($form_id)) {
        echo '<div class="aitsc-cta__form">';

        // Load form placeholder component
        $form_template = locate_template('components/cta/form-placeholder.php');
        if ($form_template) {
            include $form_template;
        } else {
            // Fallback: do_shortcode
            echo do_shortcode('[contact-form-7 id="' . $form_id . '"]');
        }

        echo '</div>';
    }

    echo '</div>'; // .aitsc-cta__content

    // Button/action area (for non-form variants)
    if ($variant !== 'form') {
        echo '<div class="aitsc-cta__action">';

        if (!empty($button_text) && !empty($button_link)) {
            $aria_attr = !empty($button_aria_label) ? sprintf(' aria-label="%s"', $button_aria_label) : '';
            echo sprintf(
                '<a href="%s" class="aitsc-cta__button"%s>%s</a>',
                $button_link,
                $aria_attr,
                $button_text
            );
        }

        echo '</div>'; // .aitsc-cta__action
    }

    echo '</div>'; // .aitsc-cta__container
    echo '</section>'; // .aitsc-cta
}
