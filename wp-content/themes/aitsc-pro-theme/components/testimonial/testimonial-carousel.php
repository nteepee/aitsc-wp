<?php
/**
 * Testimonial Carousel Component
 *
 * Client testimonial slider with navigation and auto-play.
 * Displays customer feedback with author details.
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Testimonial Carousel Component
 *
 * @param array $testimonials {
 *     Array of testimonials to display
 *
 *     @type array $testimonial {
 *         @type string $quote   Testimonial text (required).
 *         @type string $author  Author name (required).
 *         @type string $company Company name.
 *         @type string $role    Author role/title.
 *         @type string $image   Author headshot URL.
 *         @type int    $rating  Star rating (1-5).
 *     }
 * }
 * @return void
 */
function aitsc_render_testimonials($testimonials = array()) {
    // NOTE: Testimonials pending - component ready for integration
    // TODO: Update with actual client testimonials when available

    // Default placeholder testimonials for demo purposes
    if (empty($testimonials)) {
        $testimonials = array(
            array(
                'quote'   => __('Exceptional service and expertise. AITSC delivered beyond our expectations with professional transport safety consulting.', 'aitsc-pro-theme'),
                'author'  => 'John Smith',
                'company' => 'TechCorp Transport',
                'role'    => 'Fleet Manager',
                'rating'  => 5
            ),
            array(
                'quote'   => __('Highly recommend their NHVAS accreditation services. The team was knowledgeable, efficient, and ensured full compliance.', 'aitsc-pro-theme'),
                'author'  => 'Sarah Johnson',
                'company' => 'Logistics Solutions Ltd',
                'role'    => 'Compliance Officer',
                'rating'  => 5
            ),
            array(
                'quote'   => __('Professional Chain of Responsibility training that significantly improved our safety culture. Outstanding results!', 'aitsc-pro-theme'),
                'author'  => 'Michael Brown',
                'company' => 'National Freight Co',
                'role'    => 'Operations Director',
                'rating'  => 5
            )
        );
    }

    // Sanitize and validate testimonials
    $validated_testimonials = array();
    foreach ($testimonials as $testimonial) {
        if (isset($testimonial['quote']) && isset($testimonial['author'])) {
            $validated_testimonials[] = array(
                'quote'   => wp_kses_post($testimonial['quote']),
                'author'  => sanitize_text_field($testimonial['author']),
                'company' => isset($testimonial['company']) ? sanitize_text_field($testimonial['company']) : '',
                'role'    => isset($testimonial['role']) ? sanitize_text_field($testimonial['role']) : '',
                'image'   => isset($testimonial['image']) ? esc_url($testimonial['image']) : '',
                'rating'  => isset($testimonial['rating']) ? absint($testimonial['rating']) : 5
            );
        }
    }

    if (empty($validated_testimonials)) {
        return;
    }

    // Start output
    echo '<section class="aitsc-testimonials">';

    echo '<div class="aitsc-testimonials__container">';

    // Section header (optional)
    echo '<div class="aitsc-testimonials__header">';
    echo sprintf(
        '<h2 class="aitsc-testimonials__title">%s</h2>',
        esc_html__('What Our Clients Say', 'aitsc-pro-theme')
    );
    echo '</div>';

    // Carousel wrapper
    echo '<div class="aitsc-testimonials__carousel" data-autoplay="true" data-autoplay-delay="5000">';

    // Testimonials track
    echo '<div class="aitsc-testimonials__track">';

    // Output each testimonial
    foreach ($validated_testimonials as $index => $testimonial) {
        $quote   = $testimonial['quote'];
        $author  = $testimonial['author'];
        $company = $testimonial['company'];
        $role    = $testimonial['role'];
        $image   = $testimonial['image'];
        $rating  = $testimonial['rating'];

        echo sprintf(
            '<div class="aitsc-testimonials__slide" data-index="%d">',
            $index
        );

        echo '<div class="aitsc-testimonials__card">';

        // Rating stars
        if ($rating > 0) {
            echo '<div class="aitsc-testimonials__rating">';
            for ($i = 1; $i <= 5; $i++) {
                $star_class = $i <= $rating ? 'material-symbols-outlined is-filled' : 'material-symbols-outlined';
                echo sprintf('<span class="%s">star</span>', $star_class);
            }
            echo '</div>';
        }

        // Quote
        echo sprintf(
            '<blockquote class="aitsc-testimonials__quote">%s</blockquote>',
            $quote
        );

        // Author info
        echo '<div class="aitsc-testimonials__author">';

        // Author image
        if (!empty($image)) {
            echo sprintf(
                '<div class="aitsc-testimonials__image">' .
                    '<img src="%s" alt="%s" loading="lazy" />' .
                '</div>',
                esc_url($image),
                esc_attr($author)
            );
        } else {
            // Default avatar
            echo '<div class="aitsc-testimonials__image aitsc-testimonials__image--placeholder">' .
                '<span class="material-symbols-outlined">account_circle</span>' .
            '</div>';
        }

        // Author details
        echo '<div class="aitsc-testimonials__details">';

        echo sprintf(
            '<cite class="aitsc-testimonials__name">%s</cite>',
            esc_html($author)
        );

        if (!empty($role)) {
            echo sprintf(
                '<p class="aitsc-testimonials__role">%s</p>',
                esc_html($role)
            );
        }

        if (!empty($company)) {
            echo sprintf(
                '<p class="aitsc-testimonials__company">%s</p>',
                esc_html($company)
            );
        }

        echo '</div>'; // .aitsc-testimonials__details
        echo '</div>'; // .aitsc-testimonials__author

        echo '</div>'; // .aitsc-testimonials__card
        echo '</div>'; // .aitsc-testimonials__slide
    }

    echo '</div>'; // .aitsc-testimonials__track

    // Navigation controls
    echo '<div class="aitsc-testimonials__controls">';

    echo sprintf(
        '<button class="aitsc-testimonials__nav aitsc-testimonials__nav--prev" aria-label="%s" type="button">' .
            '<span class="material-symbols-outlined">chevron_left</span>' .
        '</button>',
        esc_attr__('Previous testimonial', 'aitsc-pro-theme')
    );

    // Dots/pagination
    echo '<div class="aitsc-testimonials__dots">';
    foreach ($validated_testimonials as $index => $testimonial) {
        $active_class = $index === 0 ? 'is-active' : '';
        echo sprintf(
            '<button class="aitsc-testimonials__dot %s" data-index="%d" aria-label="%s %d" type="button"></button>',
            $active_class,
            $index,
            esc_attr__('Go to testimonial', 'aitsc-pro-theme'),
            $index + 1
        );
    }
    echo '</div>';

    echo sprintf(
        '<button class="aitsc-testimonials__nav aitsc-testimonials__nav--next" aria-label="%s" type="button">' .
            '<span class="material-symbols-outlined">chevron_right</span>' .
        '</button>',
        esc_attr__('Next testimonial', 'aitsc-pro-theme')
    );

    echo '</div>'; // .aitsc-testimonials__controls

    echo '</div>'; // .aitsc-testimonials__carousel
    echo '</div>'; // .aitsc-testimonials__container
    echo '</section>'; // .aitsc-testimonials
}
