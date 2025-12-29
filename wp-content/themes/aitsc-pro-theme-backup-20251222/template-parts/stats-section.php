<?php
/**
 * Animated Statistics/Metrics Section Template Part
 *
 * Features animated counters, progress bars, and dynamic metrics display
 * WorldQuant-inspired design with smooth animations
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

// Get customizer settings
$stats_background = get_theme_mod('aitsc_stats_background', 'dark'); // dark, light, gradient
$stats_title = get_theme_mod('aitsc_stats_title', 'Transport Safety Excellence');
$stats_subtitle = get_theme_mod('aitsc_stats_subtitle', 'Leading Australian transport safety consulting with proven results across the logistics industry');
$stats_layout = get_theme_mod('aitsc_stats_layout', 'grid'); // grid, cards, mixed
$stats_animation_style = get_theme_mod('aitsc_stats_animation_style', 'counter'); // counter, progress, mixed
$stats_columns = get_theme_mod('aitsc_stats_columns', 4); // 2, 3, 4

// Get individual stats data
$stats_data = array();
for ($i = 1; $i <= 6; $i++) {
    if (get_theme_mod("aitsc_stat_{$i}_number")) {
        $stats_data[] = array(
            'number' => get_theme_mod("aitsc_stat_{$i}_number"),
            'label' => get_theme_mod("aitsc_stat_{$i}_label"),
            'prefix' => get_theme_mod("aitsc_stat_{$i}_prefix", ''),
            'suffix' => get_theme_mod("aitsc_stat_{$i}_suffix", ''),
            'icon' => get_theme_mod("aitsc_stat_{$i}_icon"),
            'progress' => get_theme_mod("aitsc_stat_{$i}_progress", 100),
            'color' => get_theme_mod("aitsc_stat_{$i}_color", '#00e128')
        );
    }
}

// Limit to columns count
$stats_data = array_slice($stats_data, 0, $stats_columns);

$section_class = 'stats-section';
$section_class .= ' stats-' . $stats_background;
$section_class .= ' stats-' . $stats_layout;
$section_class .= ' stats-' . $stats_animation_style;
$section_class .= ' stats-cols-' . $stats_columns;
?>

<section class="<?php echo esc_attr($section_class); ?>">
    <div class="container">
        <!-- Section Header -->
        <div class="stats-header text-center">
            <h2 class="stats-title animate-slide-up">
                <?php echo esc_html($stats_title); ?>
            </h2>
            <?php if ($stats_subtitle) : ?>
            <p class="stats-subtitle animate-slide-up delay-1">
                <?php echo esc_html($stats_subtitle); ?>
            </p>
            <?php endif; ?>
        </div>

        <!-- Stats Grid -->
        <div class="stats-container">
            <?php foreach ($stats_data as $index => $stat) : ?>
            <div class="stat-item animate-fade-in-up delay-<?php echo $index + 1; ?>"
                 data-stat-index="<?php echo $index; ?>">

                <?php if ($stats_layout === 'mixed' && !empty($stat['icon'])) : ?>
                <div class="stat-icon">
                    <span class="<?php echo esc_attr($stat['icon']); ?>"></span>
                </div>
                <?php endif; ?>

                <div class="stat-content">
                    <!-- Counter Animation -->
                    <?php if ($stats_animation_style === 'counter' || $stats_animation_style === 'mixed') : ?>
                    <div class="stat-counter stat-number">
                        <span class="stat-prefix"><?php echo esc_html($stat['prefix']); ?></span>
                        <span class="js-counter"
                              data-target="<?php echo esc_attr($stat['number']); ?>"
                              data-count="<?php echo esc_attr($stat['number']); ?>"
                              data-duration="2000"
                              data-delay="<?php echo $index * 200; ?>">0</span>
                        <span class="stat-suffix"><?php echo esc_html($stat['suffix']); ?></span>
                    </div>
                    <?php endif; ?>

                    <!-- Progress Bar -->
                    <?php if ($stats_animation_style === 'progress' || $stats_animation_style === 'mixed') : ?>
                    <div class="stat-progress">
                        <div class="progress-bar stat-progress-bar"
                             style="width: 0%; --target-width: <?php echo esc_attr($stat['progress']); ?>%; background-color: <?php echo esc_attr($stat['color']); ?>;">
                            <div class="progress-fill"
                                 data-progress="<?php echo esc_attr($stat['progress']); ?>"
                                 style="background-color: <?php echo esc_attr($stat['color']); ?>;">
                            </div>
                        </div>
                        <div class="progress-percentage">
                            <span class="stat-prefix"><?php echo esc_html($stat['prefix']); ?></span>
                            <span class="progress-number">0</span>
                            <span class="stat-suffix"><?php echo esc_html($stat['suffix']); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Stat Label -->
                    <div class="stat-label">
                        <?php echo esc_html($stat['label']); ?>
                    </div>
                </div>

                <!-- Additional Info for Mixed Layout -->
                <?php if ($stats_layout === 'mixed' && get_theme_mod("aitsc_stat_" . ($index + 1) . "_description")) : ?>
                <div class="stat-description">
                    <?php echo esc_html(get_theme_mod("aitsc_stat_" . ($index + 1) . "_description")); ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Trust Indicators -->
        <?php if (get_theme_mod('aitsc_stats_trust_indicators', false)) : ?>
        <div class="stats-trust-indicators">
            <div class="trust-indicator">
                <span class="trust-icon dashicons dashicons-awards"></span>
                <span class="trust-text">Industry Certified</span>
            </div>
            <div class="trust-indicator">
                <span class="trust-icon dashicons dashicons-shield-alt"></span>
                <span class="trust-text">ISO 26262 Compliant</span>
            </div>
            <div class="trust-indicator">
                <span class="trust-icon dashicons dashicons-star-filled"></span>
                <span class="trust-text">99% Client Satisfaction</span>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php
/**
 * Inline styles for dynamic settings
 */
$stats_custom_styles = '';

// Custom background colors
if ($stats_background === 'custom' && get_theme_mod('aitsc_stats_bg_color')) {
    $bg_color = get_theme_mod('aitsc_stats_bg_color');
    $stats_custom_styles .= ".stats-section { background-color: {$bg_color}; }\n";
}

// Custom text colors
if (get_theme_mod('aitsc_stats_text_color')) {
    $text_color = get_theme_mod('aitsc_stats_text_color');
    $stats_custom_styles .= ".stats-section { color: {$text_color}; }\n";
}

// Custom accent colors
if (get_theme_mod('aitsc_stats_accent_color')) {
    $accent_color = get_theme_mod('aitsc_stats_accent_color');
    $stats_custom_styles .= ".stats-section .stat-number, .stats-section .progress-fill { color: {$accent_color}; background-color: {$accent_color}; }\n";
}

// Animation delays for better performance
$animation_delays = '';
foreach ($stats_data as $index => $stat) {
    $delay = $index * 0.2; // 200ms between each animation
    $animation_delays .= ".stats-section .stat-item:nth-child(" . ($index + 1) . ") { animation-delay: {$delay}s; }\n";
}

if (!empty($animation_delays)) {
    $stats_custom_styles .= $animation_delays;
}

if (!empty($stats_custom_styles)) :
    wp_add_inline_style('aitsc-homepage-advanced', $stats_custom_styles);
endif;
?>