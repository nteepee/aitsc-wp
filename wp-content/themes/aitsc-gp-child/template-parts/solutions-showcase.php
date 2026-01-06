<?php
/**
 * Advanced Solutions Showcase Template Part
 *
 * Features filterable solutions grid with animations and CPT integration
 * WorldQuant-inspired design with advanced filtering
 *
 * @package AITSC_Pro_Theme
 * @since 1.0.0
 */

// Get customizer settings
$solutions_title = get_theme_mod('aitsc_solutions_title', 'Our Solutions');
$solutions_subtitle = get_theme_mod('aitsc_solutions_subtitle', 'Comprehensive safety solutions tailored to your industry needs');
$solutions_layout = get_theme_mod('aitsc_solutions_layout', 'grid'); // grid, carousel, masonry
$solutions_columns = get_theme_mod('aitsc_solutions_columns', 3); // 2, 3, 4
$solutions_display_count = get_theme_mod('aitsc_solutions_count', 6);
$solutions_enable_filtering = get_theme_mod('aitsc_solutions_filtering', true);
$solutions_show_all_button = get_theme_mod('aitsc_solutions_show_all', true);
$solutions_all_button_url = get_theme_mod('aitsc_solutions_all_url', '/solutions/');

$section_class = 'solutions-showcase';
$section_class .= ' solutions-' . $solutions_layout;
$section_class .= ' solutions-cols-' . $solutions_columns;

// Query solutions
$solutions_args = array(
    'post_type'      => 'solutions',
    'posts_per_page' => $solutions_display_count,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'post_status'    => 'publish'
);

$solutions_query = new WP_Query($solutions_args);

// Get taxonomy terms for filtering
$industry_terms = get_terms(array(
    'taxonomy' => 'industry',
    'hide_empty' => true,
));

$technology_terms = get_terms(array(
    'taxonomy' => 'technology',
    'hide_empty' => true,
));

// Handle WP_Error gracefully
$industry_terms = is_wp_error($industry_terms) ? array() : $industry_terms;
$technology_terms = is_wp_error($technology_terms) ? array() : $technology_terms;
?>

<section class="<?php echo esc_attr($section_class); ?> section">
    <div class="container">
        <!-- Section Header -->
        <div class="solutions-header">
            <h2 class="section-title animate-slide-up">
                <?php echo esc_html($solutions_title); ?>
            </h2>
            <?php if ($solutions_subtitle) : ?>
            <p class="section-subtitle animate-slide-up delay-1">
                <?php echo esc_html($solutions_subtitle); ?>
            </p>
            <?php endif; ?>
        </div>

        <!-- Filter Controls -->
        <?php if ($solutions_enable_filtering && (!empty($industry_terms) || !empty($technology_terms))) : ?>
        <div class="solutions-filters animate-fade-in-up delay-2">
            <!-- Industry Filter -->
            <?php if (!empty($industry_terms)) : ?>
            <div class="filter-group">
                <label class="filter-label">Industry:</label>
                <div class="filter-buttons">
                    <button class="filter-button active" data-filter="*" data-taxonomy="industry">
                        All Industries
                    </button>
                    <?php foreach ($industry_terms as $term) : ?>
                    <button class="filter-button"
                            data-filter="<?php echo '.' . esc_attr($term->slug); ?>"
                            data-taxonomy="industry">
                        <?php echo esc_html($term->name); ?>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Technology Filter -->
            <?php if (!empty($technology_terms)) : ?>
            <div class="filter-group">
                <label class="filter-label">Technology:</label>
                <div class="filter-buttons">
                    <button class="filter-button active" data-filter="*" data-taxonomy="technology">
                        All Technologies
                    </button>
                    <?php foreach ($technology_terms as $term) : ?>
                    <button class="filter-button"
                            data-filter="<?php echo '.' . esc_attr($term->slug); ?>"
                            data-taxonomy="technology">
                        <?php echo esc_html($term->name); ?>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Solutions Grid -->
        <div class="solutions-grid-container">
            <div class="solutions-grid <?php echo $solutions_enable_filtering ? 'filter-grid' : ''; ?>"
                 <?php echo $solutions_enable_filtering ? 'data-grid-count="' . $solutions_query->post_count . '"' : ''; ?>>

                <?php if ($solutions_query->have_posts()) : ?>
                    <?php while ($solutions_query->have_posts()) : $solutions_query->the_post(); ?>

                        <?php
                        // Get solution metadata
                        $solution_icon = get_post_meta(get_the_ID(), 'solution_icon', true);
                        $solution_price = get_post_meta(get_the_ID(), 'solution_price', true);
                        $solution_features = get_post_meta(get_the_ID(), 'solution_features', true);
                        $solution_demo_url = get_post_meta(get_the_ID(), 'solution_demo_url', true);

                        // Get taxonomy classes for filtering
                        $item_classes = array('solution-item');
                        $industries = get_the_terms(get_the_ID(), 'industry');
                        if ($industries && !is_wp_error($industries)) {
                            foreach ($industries as $industry) {
                                $item_classes[] = $industry->slug;
                            }
                        }
                        $technologies = get_the_terms(get_the_ID(), 'technology');
                        if ($technologies && !is_wp_error($technologies)) {
                            foreach ($technologies as $tech) {
                                $item_classes[] = $tech->slug;
                            }
                        }
                        ?>

                        <div class="<?php echo esc_attr(implode(' ', $item_classes)); ?> animate-fade-in-up"
                             style="--animation-delay: <?php echo (($solutions_query->current_post - 1) * 0.1); ?>s;">

                            <?php
                            // Build features HTML for custom card content
                            $features_html = '';
                            if ($solution_features && !empty($solution_features)) {
                                $features = is_array($solution_features) ? $solution_features : explode("\n", $solution_features);
                                $features = array_slice($features, 0, 3);

                                $features_html = '<ul class="solution-features">';
                                foreach ($features as $feature) {
                                    if (!empty(trim($feature))) {
                                        $features_html .= '<li class="solution-feature">';
                                        $features_html .= '<span class="feature-icon dashicons dashicons-yes"></span>';
                                        $features_html .= '<span class="feature-text">' . esc_html(trim($feature)) . '</span>';
                                        $features_html .= '</li>';
                                    }
                                }
                                $features_html .= '</ul>';
                            }

                            // Build price badge HTML
                            $price_html = '';
                            if ($solution_price) {
                                $price_html = '<div class="solution-price">' . esc_html($solution_price) . '</div>';
                            }

                            // Build demo button HTML
                            $demo_button_html = '';
                            if ($solution_demo_url) {
                                $demo_button_html = '<a href="' . esc_url($solution_demo_url) . '" class="btn btn-neon btn-sm" target="_blank" rel="noopener">View Demo</a>';
                            }

                            // Combine description with features
                            $full_description = wp_trim_words(get_the_excerpt(), 15, '...');
                            if (!empty($features_html)) {
                                $full_description .= $features_html;
                            }
                            if (!empty($price_html)) {
                                $full_description = $price_html . $full_description;
                            }

                            // Combine CTA with demo button
                            $cta_html = 'Learn More';
                            if (!empty($demo_button_html)) {
                                $cta_html .= ' ' . $demo_button_html;
                            }

                            // Render unified card
                            aitsc_render_card([
                                'variant' => has_post_thumbnail() ? 'image' : 'solution',
                                'title' => get_the_title(),
                                'description' => $full_description,
                                'link' => get_permalink(),
                                'icon' => $solution_icon ? str_replace(['dashicons-', 'dashicons '], '', $solution_icon) : 'shield',
                                'image' => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'aitsc-feature') : '',
                                'cta_text' => $cta_html,
                                'size' => 'medium',
                                'custom_class' => 'card-hover-lift animate-slide-up'
                            ]);
                            ?>
                        </div>

                    <?php endwhile; wp_reset_postdata(); ?>

                <?php else : ?>
                    <div class="no-solutions">
                        <p><?php esc_html_e('No solutions found.', 'aitsc-pro-theme'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Show All Button -->
        <?php if ($solutions_show_all_button) : ?>
        <div class="solutions-footer text-center animate-fade-in-up">
            <a href="<?php echo esc_url($solutions_all_button_url); ?>"
               class="btn btn-neon btn-lg">
                View All Solutions
                <span class="btn-arrow dashicons dashicons-arrow-right-alt"></span>
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php
/**
 * Inline styles for dynamic settings
 */
$solutions_custom_styles = '';

// Grid columns layout
$grid_columns = '';
switch ($solutions_columns) {
    case 2:
        $grid_columns = '.solutions-showcase .solutions-grid { grid-template-columns: repeat(2, 1fr); }';
        break;
    case 3:
        $grid_columns = '.solutions-showcase .solutions-grid { grid-template-columns: repeat(3, 1fr); }';
        break;
    case 4:
        $grid_columns = '.solutions-showcase .solutions-grid { grid-template-columns: repeat(4, 1fr); }';
        break;
}

if ($grid_columns) {
    $solutions_custom_styles .= $grid_columns . "\n";
}

// Responsive adjustments
$solutions_custom_styles .= '@media (max-width: 61.9375rem) {
    .solutions-showcase .solutions-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 47.9375rem) {
    .solutions-showcase .solutions-grid { grid-template-columns: 1fr; }
}';

// Masonry layout styles
if ($solutions_layout === 'masonry') {
    $solutions_custom_styles .= '
    .solutions-showcase.solutions-masonry .solutions-grid {
        display: block;
        column-count: ' . $solutions_columns . ';
        column-gap: 24px;
    }
    .solutions-showcase.solutions-masonry .solution-item {
        break-inside: avoid;
        margin-bottom: 24px;
    }
    @media (max-width: 47.9375rem) {
        .solutions-showcase.solutions-masonry .solutions-grid { column-count: 1; }
    }
    ';
}

// Animation delays for grid items
$animation_delays = '';
$max_items = min($solutions_display_count, $solutions_query->post_count);
for ($i = 0; $i < $max_items; $i++) {
    $delay = $i * 0.1;
    $animation_delays .= ".solutions-showcase .solution-item:nth-child(" . ($i + 1) . ") { animation-delay: {$delay}s; }\n";
}

if (!empty($animation_delays)) {
    $solutions_custom_styles .= $animation_delays;
}

if (!empty($solutions_custom_styles)) :
    wp_add_inline_style('aitsc-homepage-advanced', $solutions_custom_styles);
endif;
?>