<?php
/**
 * Stats Counter Component
 *
 * Animated statistics counter with Intersection Observer for scroll-triggered animations.
 * Displays projects completed, years experience, industries served, etc.
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Stats Counter Component
 *
 * @param array $stats {
 *     Array of statistics to display
 *
 *     @type array $stat {
 *         @type int    $number Statistic number (required).
 *         @type string $label  Statistic label (required).
 *         @type string $suffix Suffix (e.g., '+', '%', 'K').
 *         @type string $prefix Prefix (e.g., '$', '#').
 *     }
 * }
 * @return void
 */
function aitsc_render_stats($stats = array()) {
    // NOTE: Stats data pending - component ready for integration
    // TODO: Update with actual statistics when available from client

    // Default placeholder stats for demo purposes
    if (empty($stats)) {
        $stats = array(
            array(
                'number' => 150,
                'label'  => __('Projects Completed', 'aitsc-pro-theme'),
                'suffix' => '+'
            ),
            array(
                'number' => 10,
                'label'  => __('Years Experience', 'aitsc-pro-theme'),
                'suffix' => '+'
            ),
            array(
                'number' => 25,
                'label'  => __('Industries Served', 'aitsc-pro-theme'),
                'suffix' => '+'
            ),
            array(
                'number' => 98,
                'label'  => __('Client Satisfaction', 'aitsc-pro-theme'),
                'suffix' => '%'
            )
        );
    }

    // Sanitize and validate stats
    $validated_stats = array();
    foreach ($stats as $stat) {
        if (isset($stat['number']) && isset($stat['label'])) {
            $validated_stats[] = array(
                'number' => absint($stat['number']),
                'label'  => sanitize_text_field($stat['label']),
                'suffix' => isset($stat['suffix']) ? sanitize_text_field($stat['suffix']) : '',
                'prefix' => isset($stat['prefix']) ? sanitize_text_field($stat['prefix']) : ''
            );
        }
    }

    if (empty($validated_stats)) {
        return;
    }

    // Start output
    echo '<section class="aitsc-stats">';

    echo '<div class="aitsc-stats__container">';

    echo '<div class="aitsc-stats__grid">';

    // Output each stat
    foreach ($validated_stats as $index => $stat) {
        $number = $stat['number'];
        $label  = $stat['label'];
        $suffix = $stat['suffix'];
        $prefix = $stat['prefix'];

        echo sprintf(
            '<div class="aitsc-stats__item" data-index="%d">',
            $index
        );

        echo '<div class="aitsc-stats__number">';

        if (!empty($prefix)) {
            echo sprintf('<span class="aitsc-stats__prefix">%s</span>', esc_html($prefix));
        }

        echo sprintf(
            '<span class="aitsc-stats__count" data-target="%d">0</span>',
            $number
        );

        if (!empty($suffix)) {
            echo sprintf('<span class="aitsc-stats__suffix">%s</span>', esc_html($suffix));
        }

        echo '</div>'; // .aitsc-stats__number

        echo sprintf(
            '<p class="aitsc-stats__label">%s</p>',
            esc_html($label)
        );

        echo '</div>'; // .aitsc-stats__item
    }

    echo '</div>'; // .aitsc-stats__grid

    echo '</div>'; // .aitsc-stats__container

    echo '</section>'; // .aitsc-stats
}
