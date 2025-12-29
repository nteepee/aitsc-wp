<?php
/**
 * Universal Card Component
 *
 * A versatile card component supporting multiple variants (glass, solid, outlined, image, icon)
 * for use across solutions, case studies, blog posts, and services.
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Universal Card Component
 *
 * @param array $args {
 *     Card configuration arguments
 *
 *     @type string $variant      Card variant: 'glass'|'solid'|'outlined'|'image'|'icon'|'solution'|'blog'. Default 'solid'.
 *     @type string $title        Card title (required).
 *     @type string $description  Card description text.
 *     @type string $link         Card URL.
 *     @type string $icon         Material Symbol icon name (for icon variant).
 *     @type string $image        Image URL (for image variant).
 *     @type string $cta_text     CTA button text. Default 'Learn More'.
 *     @type string $size         Card size: 'small'|'medium'|'large'. Default 'medium'.
 *     @type string $custom_class Additional CSS classes.
 *     @type array  $custom_attrs Custom HTML attributes.
 *     @type array  $meta         Metadata for blog cards (author, date, read_time, category).
 * }
 * @return void
 */
function aitsc_render_card($args = array()) {
    $defaults = array(
        'variant'      => 'solid',
        'title'        => '',
        'description'  => '',
        'link'         => '',
        'icon'         => '',
        'image'        => '',
        'cta_text'     => __('Learn More', 'aitsc-pro-theme'),
        'size'         => 'medium',
        'custom_class' => '',
        'custom_attrs' => array(),
        'meta'         => array() // For blog cards: author, date, category, read_time
    );

    $args = wp_parse_args($args, $defaults);

    // Validate required fields
    if (empty($args['title'])) {
        return;
    }

    // Sanitize data
    $variant      = esc_attr($args['variant']);
    $title        = wp_kses_post($args['title']);
    $description  = wp_kses_post($args['description']);
    $link         = esc_url($args['link']);
    $icon         = esc_attr($args['icon']);
    $image        = esc_url($args['image']);
    $cta_text     = esc_html($args['cta_text']);
    $size         = esc_attr($args['size']);
    $custom_class = esc_attr($args['custom_class']);

    // Generate ARIA label for screen reader accessibility (WCAG 2.1 AA compliance)
    $aria_label = '';
    if (!empty($link)) {
        // Strip HTML tags from title for ARIA label
        $title_text = wp_strip_all_tags($args['title']);

        // Create descriptive ARIA label combining title and description
        if (!empty($description)) {
            // Trim description to reasonable length (first 10 words + ellipsis)
            $desc_text = wp_strip_all_tags($args['description']);
            $trimmed_desc = wp_trim_words($desc_text, 10, '...');
            $aria_label = $title_text . ' - ' . $trimmed_desc;
        } else {
            $aria_label = $title_text;
        }

        // Escape the ARIA label for safe HTML output
        $aria_label = esc_attr($aria_label);
    }

    // Build CSS classes
    $classes = array(
        'aitsc-card',
        "aitsc-card--{$variant}",
        "aitsc-card--{$size}"
    );

    if (!empty($custom_class)) {
        $classes[] = $custom_class;
    }

    $class_string = implode(' ', array_filter($classes));

    // Build custom attributes
    $attrs_string = '';
    if (!empty($args['custom_attrs']) && is_array($args['custom_attrs'])) {
        foreach ($args['custom_attrs'] as $attr_name => $attr_value) {
            $attrs_string .= sprintf(' %s="%s"', esc_attr($attr_name), esc_attr($attr_value));
        }
    }

    // Start output
    $output = '';

    // Card wrapper
    if (!empty($link)) {
        // Add aria-label attribute for accessibility if label is available
        $aria_attr = !empty($aria_label) ? sprintf(' aria-label="%s"', $aria_label) : '';
        $output .= sprintf('<a href="%s" class="%s"%s%s>', $link, $class_string, $aria_attr, $attrs_string);
    } else {
        $output .= sprintf('<div class="%s"%s>', $class_string, $attrs_string);
    }

    // Card content based on variant
    switch ($variant) {
        case 'icon':
        case 'solution': // Solution cards use icons like icon variant
            // Icon variant: displays icon + content
            if (!empty($icon)) {
                $aria_hidden = isset($args['icon_aria']) && $args['icon_aria'] ? ' aria-hidden="true"' : '';
                $output .= sprintf(
                    '<div class="aitsc-card__icon">' .
                        '<span class="material-symbols-outlined"%s>%s</span>' .
                    '</div>',
                    $aria_hidden,
                    $icon
                );
            }
            break;

        case 'image':
        case 'blog': // Blog cards display images
            // Image variant: displays featured image + content
            if (!empty($image)) {
                $output .= sprintf(
                    '<div class="aitsc-card__image">' .
                        '<img src="%s" alt="%s" loading="lazy" />' .
                    '</div>',
                    $image,
                    esc_attr($title)
                );
            }
            break;
    }

    // Card body (common to all variants)
    $output .= '<div class="aitsc-card__body">';

    // Blog card metadata (before title)
    if ($variant === 'blog' && !empty($args['meta'])) {
        $meta = $args['meta'];
        $output .= '<div class="aitsc-card__meta">';

        if (!empty($meta['category'])) {
            $output .= sprintf(
                '<span class="aitsc-card__badge">%s</span>',
                esc_html($meta['category'])
            );
        }

        if (!empty($meta['date']) || !empty($meta['read_time'])) {
            $output .= '<div class="aitsc-card__meta-info">';

            if (!empty($meta['date'])) {
                $output .= sprintf(
                    '<span class="aitsc-card__date">%s</span>',
                    esc_html($meta['date'])
                );
            }

            if (!empty($meta['read_time'])) {
                $output .= sprintf(
                    '<span class="aitsc-card__read-time">%s</span>',
                    esc_html($meta['read_time'])
                );
            }

            $output .= '</div>';
        }

        $output .= '</div>';
    }

    // Card title
    $output .= sprintf(
        '<h3 class="aitsc-card__title">%s</h3>',
        $title
    );

    // Card description
    if (!empty($description)) {
        $output .= sprintf(
            '<p class="aitsc-card__description">%s</p>',
            $description
        );
    }

    // Card CTA (only if link exists)
    if (!empty($link) && !empty($cta_text)) {
        $output .= sprintf(
            '<span class="aitsc-card__cta">%s</span>',
            $cta_text
        );
    }

    $output .= '</div>'; // .aitsc-card__body

    // Close wrapper
    if (!empty($link)) {
        $output .= '</a>';
    } else {
        $output .= '</div>';
    }

    echo $output;
}
